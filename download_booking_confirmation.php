<?php
session_start();
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/services/patient_portal_service.php';

hq_require_login('login.php');

$userId = (int) ($_SESSION['user_id'] ?? 0);
$appointmentId = (int) ($_GET['id'] ?? 0);
$detail = hq_fetch_patient_appointment_detail($conn, $userId, $appointmentId);

if (!$detail) {
    http_response_code(404);
    exit('Appointment not found.');
}

function hq_pdf_clean_text(string $text): string
{
    $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
    $text = preg_replace('/\s+/', ' ', trim($text)) ?? '';

    $replacements = [
        "\r" => ' ',
        "\n" => ' ',
        "\t" => ' ',
        "\xE2\x80\x93" => '-',
        "\xE2\x80\x94" => '-',
        "\xE2\x80\xA2" => '-',
        "\xC2\xA0" => ' ',
        '•' => '-',
        '–' => '-',
        '—' => '-',
        '’' => "'",
        '“' => '"',
        '”' => '"',
    ];

    $text = strtr($text, $replacements);
    $converted = @iconv('UTF-8', 'Windows-1252//TRANSLIT//IGNORE', $text);
    return $converted !== false ? $converted : $text;
}

function hq_pdf_escape(string $text): string
{
    return str_replace(
        ['\\', '(', ')'],
        ['\\\\', '\(', '\)'],
        hq_pdf_clean_text($text)
    );
}

function hq_pdf_wrap_text(string $text, int $maxChars = 82): array
{
    $clean = hq_pdf_clean_text($text);
    if ($clean === '') {
        return [''];
    }

    $words = preg_split('/\s+/', $clean) ?: [];
    $lines = [];
    $current = '';

    foreach ($words as $word) {
        $candidate = $current === '' ? $word : $current . ' ' . $word;
        if (strlen($candidate) <= $maxChars) {
            $current = $candidate;
            continue;
        }

        if ($current !== '') {
            $lines[] = $current;
        }

        while (strlen($word) > $maxChars) {
            $lines[] = substr($word, 0, $maxChars);
            $word = substr($word, $maxChars);
        }

        $current = $word;
    }

    if ($current !== '') {
        $lines[] = $current;
    }

    return $lines ?: [''];
}

function hq_pdf_draw_line(array &$ops, string $text, float $x, float $y, int $fontSize = 11): void
{
    $ops[] = "BT /F1 {$fontSize} Tf 1 0 0 1 " . number_format($x, 2, '.', '') . ' ' . number_format($y, 2, '.', '') . " Tm (" . hq_pdf_escape($text) . ") Tj ET";
}

function hq_pdf_color(float $r, float $g, float $b): string
{
    return number_format($r, 3, '.', '') . ' ' . number_format($g, 3, '.', '') . ' ' . number_format($b, 3, '.', '');
}

function hq_pdf_draw_text(array &$ops, string $text, float $x, float $y, int $fontSize = 11, array $rgb = [0.12, 0.18, 0.16]): void
{
    $ops[] = hq_pdf_color($rgb[0], $rgb[1], $rgb[2]) . " rg";
    hq_pdf_draw_line($ops, $text, $x, $y, $fontSize);
}

function hq_pdf_draw_rect(array &$ops, float $x, float $y, float $w, float $h, ?array $fill = null, ?array $stroke = null, float $lineWidth = 1): void
{
    $parts = [];
    if ($fill !== null) {
        $parts[] = hq_pdf_color($fill[0], $fill[1], $fill[2]) . ' rg';
    }
    if ($stroke !== null) {
        $parts[] = hq_pdf_color($stroke[0], $stroke[1], $stroke[2]) . ' RG';
        $parts[] = number_format($lineWidth, 2, '.', '') . ' w';
    }
    $parts[] = number_format($x, 2, '.', '') . ' ' . number_format($y, 2, '.', '') . ' '
        . number_format($w, 2, '.', '') . ' ' . number_format($h, 2, '.', '') . ' re '
        . ($fill !== null && $stroke !== null ? 'B' : ($fill !== null ? 'f' : 'S'));
    $ops[] = implode("\n", $parts);
}

function hq_pdf_draw_rule(array &$ops, float $x, float $y, float $w, array $rgb = [0.85, 0.91, 0.88]): void
{
    $ops[] = hq_pdf_color($rgb[0], $rgb[1], $rgb[2]) . " RG\n0.80 w\n"
        . number_format($x, 2, '.', '') . ' ' . number_format($y, 2, '.', '') . " m\n"
        . number_format($x + $w, 2, '.', '') . ' ' . number_format($y, 2, '.', '') . " l S";
}

function hq_pdf_estimate_item_height(string $value, int $wrap = 52): float
{
    return 26 + (count(hq_pdf_wrap_text($value, $wrap)) * 14);
}

function hq_pdf_measure_summary_height(array $items, int $wrap = 24): float
{
    $rows = array_chunk($items, 2);
    $height = 18;
    foreach ($rows as $row) {
        $rowHeight = 0;
        foreach ($row as [, $value]) {
            $rowHeight = max($rowHeight, 24 + (count(hq_pdf_wrap_text((string) $value, $wrap)) * 14));
        }
        $height += $rowHeight;
    }
    return $height;
}

function hq_pdf_draw_footer(array &$ops, int $pageNumber): void
{
    hq_pdf_draw_rule($ops, 42, 42, 528, [0.84, 0.90, 0.87]);
    hq_pdf_draw_text($ops, 'HealthQuarters Diagnostic and Laboratory', 42, 28, 9, [0.35, 0.45, 0.41]);
    hq_pdf_draw_text($ops, 'Appointment Confirmation', 250, 28, 9, [0.35, 0.45, 0.41]);
    hq_pdf_draw_text($ops, 'Page ' . $pageNumber, 525, 28, 9, [0.35, 0.45, 0.41]);
}

function hq_generate_simple_pdf(array $pages): string
{
    $objects = [];

    $objects[] = "<< /Type /Catalog /Pages 2 0 R >>";

    $kids = [];
    $fontObjectNumber = 3 + (count($pages) * 2);
    for ($i = 0; $i < count($pages); $i++) {
        $kids[] = (3 + ($i * 2)) . " 0 R";
    }
    $objects[] = "<< /Type /Pages /Count " . count($pages) . " /Kids [" . implode(' ', $kids) . "] >>";

    foreach ($pages as $index => $stream) {
        $pageObjectNumber = 3 + ($index * 2);
        $contentObjectNumber = $pageObjectNumber + 1;
        $objects[] = "<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Resources << /Font << /F1 {$fontObjectNumber} 0 R >> >> /Contents {$contentObjectNumber} 0 R >>";
        $objects[] = "<< /Length " . strlen($stream) . " >>\nstream\n{$stream}\nendstream";
    }

    $objects[] = "<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>";

    $pdf = "%PDF-1.4\n";
    $offsets = [0];
    foreach ($objects as $i => $object) {
        $offsets[] = strlen($pdf);
        $pdf .= ($i + 1) . " 0 obj\n{$object}\nendobj\n";
    }

    $xrefOffset = strlen($pdf);
    $pdf .= "xref\n0 " . (count($objects) + 1) . "\n";
    $pdf .= "0000000000 65535 f \n";
    for ($i = 1; $i <= count($objects); $i++) {
        $pdf .= str_pad((string) $offsets[$i], 10, '0', STR_PAD_LEFT) . " 00000 n \n";
    }

    $pdf .= "trailer\n<< /Size " . (count($objects) + 1) . " /Root 1 0 R >>\nstartxref\n{$xrefOffset}\n%%EOF";
    return $pdf;
}

$patientFullName = trim(implode(' ', array_filter([
    $detail['first_name'] ?? '',
    $detail['middle_name'] ?? '',
    $detail['last_name'] ?? '',
])));

$createdAt = !empty($detail['created_at']) ? date('F j, Y g:i A', strtotime((string) $detail['created_at'])) : 'Not available';
$dobLabel = !empty($detail['dob']) ? date('F j, Y', strtotime((string) $detail['dob'])) : 'Not provided';
$ageLabel = $detail['age'] !== '' && $detail['age'] !== null ? (string) $detail['age'] : 'Not provided';
$altContact = $detail['alt_contact'] !== '' ? (string) $detail['alt_contact'] : 'Not provided';
$notes = $detail['notes'] !== '' ? (string) $detail['notes'] : 'No special notes provided.';
$prep = $detail['prep_note'] !== '' ? (string) $detail['prep_note'] : 'No special preparation instructions recorded.';

$summaryPairs = [
    ['Reference No.', $detail['reference'] ?? ('HS-' . str_pad((string) $detail['id'], 6, '0', STR_PAD_LEFT))],
    ['Status', $detail['status'] ?? 'Pending'],
    ['Service', $detail['service'] ?? 'Appointment'],
    ['Submitted On', $createdAt],
    ['Preferred Date', $detail['date_label'] ?? 'Date pending'],
    ['Preferred Time', $detail['time_label'] ?? 'Time pending'],
];

$sections = [
    [
        'title' => 'Appointment Details',
        'items' => [
            ['Appointment Type', $detail['appointment_type'] ?? 'Home Service'],
            ['Assigned Branch', $detail['branch'] ?? 'HealthQuarters'],
            ['Service Requested', $detail['service'] ?? 'Appointment'],
            ['Current Status', $detail['status'] ?? 'Pending'],
        ],
    ],
    [
        'title' => 'Patient Information',
        'items' => [
            ['Patient Name', $patientFullName !== '' ? $patientFullName : 'Not provided'],
            ['Date of Birth', $dobLabel],
            ['Age', $ageLabel],
            ['Gender', $detail['gender'] !== '' ? (string) $detail['gender'] : 'Not provided'],
        ],
    ],
    [
        'title' => 'Contact Information',
        'items' => [
            ['Primary Contact', $detail['contact'] !== '' ? (string) $detail['contact'] : 'Not provided'],
            ['Alternate Contact', $altContact],
            ['Email Address', $detail['email'] !== '' ? (string) $detail['email'] : 'Not provided'],
        ],
    ],
    [
        'title' => 'Service Address',
        'items' => [
            ['Address', $detail['address'] !== '' ? (string) $detail['address'] : 'Not provided'],
        ],
    ],
    [
        'title' => 'Notes and Preparation',
        'items' => [
            ['Notes', $notes],
            ['Preparation Reminder', $prep],
        ],
    ],
];

$pageStreams = [];
$ops = [];
$cursorY = 0.0;
$pageNumber = 0;

$startPage = function () use (&$ops, &$cursorY, &$pageNumber): void {
    $pageNumber++;
    $ops = [];
    hq_pdf_draw_rect($ops, 0, 0, 612, 792, [0.985, 0.988, 0.985], null);
    hq_pdf_draw_rect($ops, 28, 28, 556, 736, [1, 1, 1], [0.72, 0.80, 0.76], 1.1);
    hq_pdf_draw_rect($ops, 44, 676, 524, 70, [0.12, 0.27, 0.18], null);
    hq_pdf_draw_text($ops, 'HEALTHQUARTERS DIAGNOSTIC AND LABORATORY', 58, 723, 11, [0.92, 0.98, 0.95]);
    hq_pdf_draw_text($ops, 'HOME SERVICE APPOINTMENT CONFIRMATION', 58, 698, 18, [1, 1, 1]);
    hq_pdf_draw_text($ops, 'Official patient reference copy', 430, 723, 9, [0.92, 0.98, 0.95]);
    hq_pdf_draw_rule($ops, 44, 662, 524, [0.76, 0.84, 0.80]);
    hq_pdf_draw_footer($ops, $pageNumber);
    $cursorY = 640;
};

$ensureSpace = function (float $needed) use (&$cursorY, &$pageStreams, &$ops, &$startPage): void {
    if ($cursorY - $needed < 72) {
        $pageStreams[] = implode("\n", $ops);
        $startPage();
    }
};

$drawSummary = function (array $items) use (&$ops, &$cursorY): void {
    hq_pdf_draw_text($ops, 'DOCUMENT SUMMARY', 52, $cursorY, 10, [0.18, 0.40, 0.26]);
    $cursorY -= 18;
    $summaryHeight = hq_pdf_measure_summary_height($items, 24);
    $cardTop = $cursorY;
    $cardBottom = $cardTop - $summaryHeight;
    hq_pdf_draw_rect($ops, 44, $cardBottom, 524, $summaryHeight, [0.975, 0.982, 0.977], [0.84, 0.90, 0.87]);

    $rows = array_chunk($items, 2);
    $leftX = 58;
    $rightX = 322;
    $rowTop = $cardTop - 16;

    foreach ($rows as $rowIndex => $row) {
        $rowHeight = 0;
        foreach ($row as [, $value]) {
            $rowHeight = max($rowHeight, 24 + (count(hq_pdf_wrap_text((string) $value, 24)) * 14));
        }

        foreach ($row as $colIndex => [$label, $value]) {
            $x = $colIndex === 0 ? $leftX : $rightX;
            hq_pdf_draw_text($ops, strtoupper((string) $label), $x, $rowTop, 8, [0.43, 0.53, 0.48]);
            $lines = hq_pdf_wrap_text((string) $value, 24);
            foreach ($lines as $lineIndex => $line) {
                hq_pdf_draw_text($ops, $line, $x, $rowTop - 16 - ($lineIndex * 14), 11, [0.12, 0.18, 0.16]);
            }
        }

        if ($rowIndex < count($rows) - 1) {
            hq_pdf_draw_rule($ops, 58, $rowTop - $rowHeight + 4, 496, [0.90, 0.94, 0.91]);
        }

        $rowTop -= $rowHeight;
    }

    $cursorY = $cardBottom - 18;
};

$drawSection = function (string $title, array $items) use (&$ops, &$cursorY, &$ensureSpace): void {
    $height = 20;
    foreach ($items as [$label, $value]) {
        $height += hq_pdf_estimate_item_height((string) $value, 52);
    }

    $ensureSpace($height + 34);

    hq_pdf_draw_text($ops, strtoupper($title), 52, $cursorY, 10, [0.18, 0.40, 0.26]);
    hq_pdf_draw_rule($ops, 44, $cursorY - 8, 524, [0.84, 0.90, 0.87]);
    $cursorY -= 28;

    $cardTop = $cursorY;
    $cardY = $cardTop - $height;
    hq_pdf_draw_rect($ops, 44, $cardY, 524, $height, [1, 1, 1], [0.85, 0.91, 0.88]);

    $labelX = 54;
    $valueX = 218;
    $innerY = $cardTop - 16;

    foreach ($items as $index => [$label, $value]) {
        $valueLines = hq_pdf_wrap_text((string) $value, 52);
        hq_pdf_draw_text($ops, strtoupper((string) $label), $labelX, $innerY, 8, [0.43, 0.53, 0.48]);

        foreach ($valueLines as $lineIndex => $line) {
            hq_pdf_draw_text($ops, $line, $valueX, $innerY - ($lineIndex * 14), 11, [0.12, 0.18, 0.16]);
        }

        $rowHeight = max(26, count($valueLines) * 14 + 8);
        if ($index < count($items) - 1) {
            hq_pdf_draw_rule($ops, 54, $innerY - $rowHeight + 6, 494, [0.91, 0.94, 0.92]);
        }
        $innerY -= ($rowHeight + 8);
    }

    $cursorY = $cardY - 18;
};

$drawChecklist = function (array $items) use (&$ops, &$cursorY, &$ensureSpace): void {
    if (empty($items)) {
        return;
    }

    $height = 24;
    foreach ($items as $item) {
        $height += max(26, count(hq_pdf_wrap_text((string) $item, 64)) * 14 + 8);
    }

    $ensureSpace($height + 24);

    hq_pdf_draw_text($ops, 'PATIENT CHECKLIST', 52, $cursorY, 10, [0.18, 0.40, 0.26]);
    hq_pdf_draw_rule($ops, 44, $cursorY - 8, 524, [0.84, 0.90, 0.87]);
    $cursorY -= 28;

    $cardTop = $cursorY;
    $cardY = $cardTop - $height;
    hq_pdf_draw_rect($ops, 44, $cardY, 524, $height, [0.948, 0.976, 0.958], [0.80, 0.88, 0.83]);
    $innerY = $cardTop - 16;

    foreach ($items as $index => $item) {
        hq_pdf_draw_rect($ops, 56, $innerY - 5, 8, 8, [0.176, 0.749, 0.722], null);
        $lines = hq_pdf_wrap_text((string) $item, 64);
        foreach ($lines as $lineIndex => $line) {
            hq_pdf_draw_text($ops, $line, 78, $innerY - ($lineIndex * 14), 11, [0.12, 0.18, 0.16]);
        }
        $innerY -= max(26, count($lines) * 14 + 8);
        if ($index < count($items) - 1) {
            hq_pdf_draw_rule($ops, 54, $innerY + 4, 494, [0.86, 0.92, 0.88]);
        }
    }

    $cursorY = $cardY - 18;
};

$drawClosing = function () use (&$ops, &$cursorY, &$ensureSpace): void {
    $ensureSpace(92);
    hq_pdf_draw_rect($ops, 44, $cursorY - 72, 524, 72, [0.985, 0.988, 0.985], [0.84, 0.90, 0.87]);
    hq_pdf_draw_text($ops, 'IMPORTANT NOTICE', 58, $cursorY - 18, 9, [0.18, 0.40, 0.26]);
    hq_pdf_draw_text($ops, 'This confirmation acknowledges that your request has been successfully recorded in the system.', 58, $cursorY - 36, 10, [0.22, 0.30, 0.27]);
    hq_pdf_draw_text($ops, 'Schedule approval remains subject to clinic review and final confirmation by the HealthQuarters team.', 58, $cursorY - 52, 10, [0.22, 0.30, 0.27]);
    $cursorY -= 88;
};

$startPage();
$drawSummary($summaryPairs);

foreach ($sections as $section) {
    $drawSection((string) $section['title'], $section['items']);
}

if (!empty($detail['checklist']) && is_array($detail['checklist'])) {
    $drawChecklist($detail['checklist']);
}

$drawClosing();

$pageStreams[] = implode("\n", $ops);

$pdf = hq_generate_simple_pdf($pageStreams);
$fileName = 'appointment-confirmation-' . ($detail['reference'] ?? ('HS-' . $detail['id'])) . '.pdf';

header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . preg_replace('/[^A-Za-z0-9._-]/', '-', $fileName) . '"');
header('Content-Length: ' . strlen($pdf));
header('Cache-Control: private, max-age=0, must-revalidate');

echo $pdf;
exit;
