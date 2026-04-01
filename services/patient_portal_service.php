<?php

require_once __DIR__ . '/../includes/bootstrap.php';
require_once __DIR__ . '/../includes/runtime_schema.php';
require_once __DIR__ . '/notification_service.php';

function hq_normalize_appointment_status(string $status): string
{
    return match (strtolower(trim($status))) {
        'approved' => 'Confirmed',
        'confirmed' => 'Confirmed',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
        default => 'Pending',
    };
}

function hq_status_badge_class(string $status): string
{
    return match (hq_normalize_appointment_status($status)) {
        'Confirmed' => 'status-approved',
        'Completed' => 'status-completed',
        'Cancelled' => 'status-cancelled',
        default => 'status-pending',
    };
}

function hq_portal_prep_notes(): array
{
    return [
        'Blood Chemistry Test' => 'Stop eating and drinking except plain water by 10 PM tonight.',
        'Blood Chemistry' => 'Stop eating and drinking except plain water by 10 PM tonight.',
        'Lipid Profile' => '9-12 hours fasting required. Drink only plain water tonight.',
        'Fasting Blood Sugar' => '8 hours fasting required. Drink only plain water before your test.',
        'Ultrasound' => 'Drink 4-6 glasses of water 1 hour before and do not urinate before the test.',
        'Drug Test' => 'Do not urinate 1-2 hours before your appointment. Bring a valid ID.',
    ];
}

function hq_portal_fasting_keywords(): array
{
    return ['Blood Chemistry Test', 'Blood Chemistry', 'FBS', 'Fasting Blood Sugar', 'Lipid Profile', 'Cholesterol Test'];
}

function hq_patient_branch_options(): array
{
    return [
        'Ligao Branch' => ['label' => 'Ligao Branch', 'city' => 'Ligao City', 'slot_capacity' => 2],
        'Polangui Branch' => ['label' => 'Polangui Branch', 'city' => 'Polangui, Albay', 'slot_capacity' => 2],
        'Tabaco Branch' => ['label' => 'Tabaco Branch', 'city' => 'Tabaco City', 'slot_capacity' => 3],
    ];
}

function hq_booking_allowed_slots(): array
{
    return ['7:00 AM', '8:00 AM', '9:00 AM', '10:00 AM', '11:00 AM', '1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM'];
}

function hq_booking_branch_capacity(string $branch): int
{
    $branches = hq_patient_branch_options();
    return (int) ($branches[$branch]['slot_capacity'] ?? 1);
}

function hq_patient_next_steps(array $context): array
{
    $steps = [];
    $user = $context['user'];
    $nextAppointment = $context['next_appointment'];
    $labResults = $context['lab_results'];
    $notifications = $context['notifications'];
    $corporate = $context['corporate_inquiries'];
    $reschedules = $context['reschedule_requests'];

    if (hq_profile_completion_score($user) < 100) {
        $steps[] = [
            'title' => 'Complete your patient profile',
            'detail' => 'Adding your contact details helps the clinic confirm appointments faster.',
            'href' => 'profile.php?tab=info',
            'badge' => 'Profile',
        ];
    }

    if ($nextAppointment) {
        $steps[] = [
            'title' => 'Review your next appointment',
            'detail' => 'Check schedule, preparation reminders, and reschedule status in one place.',
            'href' => 'profile.php?tab=appointments',
            'badge' => 'Appointment',
        ];
    } else {
        $steps[] = [
            'title' => 'Book your next home service',
            'detail' => 'Choose a branch, preferred schedule, and requested services.',
            'href' => 'booking.php',
            'badge' => 'Booking',
        ];
    }

    if (!empty($corporate)) {
        $steps[] = [
            'title' => 'Track your corporate inquiry',
            'detail' => 'Review your submitted company package requests and saved details.',
            'href' => 'profile.php?tab=appointments',
            'badge' => 'Corporate',
        ];
    }

    if (!empty($reschedules)) {
        $steps[] = [
            'title' => 'Check your reschedule request',
            'detail' => 'See whether your requested change is pending, approved, or updated.',
            'href' => 'profile.php?tab=appointments',
            'badge' => 'Reschedule',
        ];
    }

    if (count(array_filter($notifications, fn($row) => (int) ($row['is_read'] ?? 0) === 0)) > 0) {
        $steps[] = [
            'title' => 'Review unread updates',
            'detail' => 'Appointment, result, and inquiry updates are waiting in your inbox.',
            'href' => 'profile.php?tab=inbox',
            'badge' => 'Inbox',
        ];
    }

    return array_slice($steps, 0, 4);
}

function hq_patient_recent_activity(array $appointments, array $corporateInquiries, array $labResults, array $notifications): array
{
    $items = [];

    foreach ($appointments as $appointment) {
        $items[] = [
            'title' => ($appointment['service_type'] ?? 'Appointment') . ' request',
            'detail' => hq_normalize_appointment_status($appointment['status'] ?? 'Pending') . ' • ' . (($appointment['preferred_time'] ?? 'Time pending')),
            'date' => $appointment['created_at'] ?? $appointment['appointment_date'] ?? null,
            'href' => 'profile.php?tab=appointments',
            'kind' => 'appointment',
        ];
    }

    foreach ($corporateInquiries as $inquiry) {
        $items[] = [
            'title' => ($inquiry['company_name'] ?? 'Corporate inquiry'),
            'detail' => ($inquiry['status'] ?? 'Pending') . ' • ' . ($inquiry['service_type'] ?? 'Corporate service'),
            'date' => $inquiry['created_at'] ?? null,
            'href' => 'profile.php?tab=appointments',
            'kind' => 'corporate',
        ];
    }

    foreach (array_slice($notifications, 0, 6) as $notification) {
        $items[] = [
            'title' => (string) ($notification['title'] ?? 'Notification'),
            'detail' => strip_tags((string) ($notification['message'] ?? '')),
            'date' => $notification['created_at'] ?? null,
            'href' => $notification['action_url'] ?: 'profile.php?tab=inbox',
            'kind' => 'notification',
        ];
    }

    usort($items, function ($left, $right) {
        return strcmp((string) ($right['date'] ?? ''), (string) ($left['date'] ?? ''));
    });

    return array_slice($items, 0, 6);
}

function hq_result_summary(array $labResults): array
{
    $latest = $labResults[0] ?? null;

    return [
        'count' => count($labResults),
        'latest_title' => $latest['title'] ?? 'No results yet',
        'latest_date' => !empty($latest['created_at']) ? date('M j, Y', strtotime($latest['created_at'])) : 'Waiting for release',
        'latest_branch' => $latest['branch'] ?? 'HealthQuarters',
    ];
}

function hq_patient_appointment_cards(array $appointments, array $rescheduleByAppointment, array $prepNotes, array $fastingKeywords): array
{
    $cards = [];

    foreach ($appointments as $appointment) {
        $service = $appointment['service_type'] ?? 'Appointment';
        $status = hq_normalize_appointment_status($appointment['status'] ?? 'Pending');
        $date = $appointment['appointment_date'] ?? '';
        $time = $appointment['preferred_time'] ?? '—';
        $prep = '';
        foreach ($prepNotes as $keyword => $note) {
            if (stripos($service, $keyword) !== false) {
                $prep = $note;
                break;
            }
        }
        $flags = [];
        if (in_array($status, ['Pending', 'Confirmed'], true)) {
            $flags[] = $status;
        }
        foreach ($fastingKeywords as $keyword) {
            if (stripos($service, $keyword) !== false) {
                $flags[] = 'Fasting';
                break;
            }
        }
        if (isset($rescheduleByAppointment[(int) ($appointment['id'] ?? 0)])) {
            $flags[] = 'Reschedule ' . ($rescheduleByAppointment[(int) $appointment['id']]['status'] ?? 'Pending');
        }

        $cards[] = [
            'id' => (int) ($appointment['id'] ?? 0),
            'service' => $service,
            'status' => $status,
            'date' => $date ? date('M j, Y', strtotime($date)) : 'Date pending',
            'time' => $time,
            'flags' => $flags,
            'prep_note' => $prep,
        ];
    }

    return array_slice($cards, 0, 4);
}

function hq_validate_booking_payload(PDO $conn, array $payload): array
{
    $errors = [];
    $branch = trim((string) ($payload['branch'] ?? ''));
    $date = trim((string) ($payload['appt_date'] ?? ''));
    $time = trim((string) ($payload['appt_time'] ?? ''));
    $service = trim((string) ($payload['service_type'] ?? ''));
    $email = strtolower(trim((string) ($payload['email'] ?? '')));
    $contactNumber = trim((string) ($payload['contact_num'] ?? ''));

    if (!array_key_exists($branch, hq_patient_branch_options())) {
        $errors[] = 'Please choose a valid branch.';
    }

    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date) || $date < date('Y-m-d')) {
        $errors[] = 'Please choose a valid future appointment date.';
    }

    if (!in_array($time, hq_booking_allowed_slots(), true)) {
        $errors[] = 'Please choose a valid appointment time.';
    }

    if ($service === '') {
        $errors[] = 'Please choose at least one requested service.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }

    if ($contactNumber === '' || !preg_match('/^[0-9+\-\s]{7,20}$/', $contactNumber)) {
        $errors[] = 'Please enter a valid contact number.';
    }

    if ($date !== '' && $time !== '' && $branch !== '' && empty($errors)) {
        $stmt = $conn->prepare("
            SELECT COUNT(*)
            FROM home_service_appointments
            WHERE appointment_date = ?
              AND preferred_time = ?
              AND branch = ?
              AND status NOT IN ('Cancelled')
        ");
        $stmt->execute([$date, $time, $branch]);
        $count = (int) $stmt->fetchColumn();

        if ($count >= hq_booking_branch_capacity($branch)) {
            $errors[] = 'That branch and time slot is already full. Please choose another schedule.';
        }
    }

    return $errors;
}

function hq_build_appointment_detail(?array $appointment, ?array $reschedule = null): ?array
{
    if (!$appointment) {
        return null;
    }

    $service = $appointment['service_type'] ?? 'Appointment';
    $status = hq_normalize_appointment_status($appointment['status'] ?? 'Pending');
    $date = $appointment['appointment_date'] ?? '';
    $time = $appointment['preferred_time'] ?? '—';
    $prep = '';
    foreach (hq_portal_prep_notes() as $keyword => $note) {
        if (stripos($service, $keyword) !== false) {
            $prep = $note;
            break;
        }
    }

    $checklist = [
        'Keep your phone nearby for confirmation and status updates.',
        'Prepare a valid ID before the scheduled visit.',
    ];

    if ($prep !== '') {
        $checklist[] = $prep;
    }

    if (!empty($appointment['address'])) {
        $checklist[] = 'Confirm that your address details are correct for the attending team.';
    }

    return [
        'id' => (int) ($appointment['id'] ?? 0),
        'reference' => 'HS-' . str_pad((string) ((int) ($appointment['id'] ?? 0)), 6, '0', STR_PAD_LEFT),
        'service' => $service,
        'status' => $status,
        'status_class' => hq_status_badge_class($status),
        'date_label' => $date ? date('F j, Y', strtotime($date)) : 'Date pending',
        'time_label' => $time,
        'appointment_date' => $date,
        'preferred_time' => $time,
        'branch' => $appointment['branch'] ?? 'HealthQuarters',
        'appointment_type' => $appointment['appointment_type'] ?? 'Home Service',
        'notes' => $appointment['notes'] ?? '',
        'address' => $appointment['address'] ?? '',
        'first_name' => $appointment['first_name'] ?? '',
        'last_name' => $appointment['last_name'] ?? '',
        'middle_name' => $appointment['middle_name'] ?? '',
        'dob' => $appointment['dob'] ?? '',
        'age' => $appointment['age'] ?? '',
        'gender' => $appointment['gender'] ?? '',
        'contact' => $appointment['contact_num'] ?? '',
        'alt_contact' => $appointment['alt_contact'] ?? '',
        'email' => $appointment['email'] ?? '',
        'created_at' => $appointment['created_at'] ?? null,
        'reschedule' => $reschedule,
        'prep_note' => $prep,
        'checklist' => $checklist,
    ];
}

function hq_fetch_patient_appointment_detail(PDO $conn, int $userId, int $appointmentId): ?array
{
    $stmt = $conn->prepare("
        SELECT *
        FROM home_service_appointments
        WHERE id = ? AND user_id = ?
        LIMIT 1
    ");
    $stmt->execute([$appointmentId, $userId]);
    $appointment = $stmt->fetch(PDO::FETCH_ASSOC) ?: null;

    if (!$appointment) {
        return null;
    }

    $rescheduleStmt = $conn->prepare("
        SELECT *
        FROM reschedule_requests
        WHERE appointment_id = ? AND user_id = ?
        ORDER BY created_at DESC
        LIMIT 1
    ");
    $rescheduleStmt->execute([$appointmentId, $userId]);
    $reschedule = $rescheduleStmt->fetch(PDO::FETCH_ASSOC) ?: null;

    return hq_build_appointment_detail($appointment, $reschedule);
}

function hq_fetch_notifications(PDO $conn, int $userId, string $filter = 'all', int $limit = 100): array
{
    hq_ensure_runtime_schema($conn);
    $sql = "
        SELECT id, appointment_id, source_type, source_id, category, type, title, message, action_url, is_read, created_at, email_sent
        FROM user_notifications
        WHERE user_id = ?
    ";
    $params = [$userId];

    if ($filter === 'unread') {
        $sql .= " AND is_read = 0";
    } elseif ($filter !== 'all') {
        $sql .= " AND category = ?";
        $params[] = $filter;
    }

    $sql .= " ORDER BY is_read ASC, created_at DESC LIMIT " . max(1, (int) $limit);

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as &$row) {
        $meta = hq_notification_meta($row['type']);
        $row['icon'] = $meta['icon'];
        $row['category'] = $row['category'] ?: $meta['category'];
        $row['time_ago'] = hq_time_ago($row['created_at']);
    }

    return $rows;
}

function hq_fetch_patient_context(PDO $conn, int $userId): array
{
    hq_ensure_runtime_schema($conn);

    $today = date('Y-m-d');
    $tomorrow = date('Y-m-d', strtotime('+1 day'));
    $threeDays = date('Y-m-d', strtotime('+3 days'));
    $fastingKeywords = hq_portal_fasting_keywords();
    $prepNotes = hq_portal_prep_notes();

    $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];

    $apptStmt = $conn->prepare("
        SELECT *
        FROM home_service_appointments
        WHERE user_id = ?
        ORDER BY appointment_date DESC, created_at DESC
    ");
    $apptStmt->execute([$userId]);
    $appointments = $apptStmt->fetchAll(PDO::FETCH_ASSOC);

    $rescheduleStmt = $conn->prepare("
        SELECT *
        FROM reschedule_requests
        WHERE user_id = ?
        ORDER BY created_at DESC
    ");
    $rescheduleStmt->execute([$userId]);
    $rescheduleRequests = $rescheduleStmt->fetchAll(PDO::FETCH_ASSOC);

    $rescheduleByAppointment = [];
    foreach ($rescheduleRequests as $request) {
        $appointmentId = (int) $request['appointment_id'];
        if (!isset($rescheduleByAppointment[$appointmentId])) {
            $rescheduleByAppointment[$appointmentId] = $request;
        }
    }

    $corpStmt = $conn->prepare("
        SELECT *
        FROM corporate_inquiries
        WHERE user_id = ?
        ORDER BY created_at DESC
    ");
    $corpStmt->execute([$userId]);
    $corpInquiries = $corpStmt->fetchAll(PDO::FETCH_ASSOC);

    $labResults = [];

    $notifications = hq_fetch_notifications($conn, $userId, 'all', 100);
    $unreadCount = count(array_filter($notifications, fn($row) => (int) $row['is_read'] === 0));

    $activeAppointments = array_values(array_filter($appointments, function ($appt) use ($today) {
        $status = hq_normalize_appointment_status($appt['status'] ?? 'Pending');
        return !in_array($status, ['Cancelled', 'Completed'], true) && ($appt['appointment_date'] ?? '') >= $today;
    }));

    usort($activeAppointments, function ($left, $right) {
        return strcmp(($left['appointment_date'] ?? '') . ' ' . ($left['preferred_time'] ?? ''), ($right['appointment_date'] ?? '') . ' ' . ($right['preferred_time'] ?? ''));
    });

    $nextAppointment = $activeAppointments[0] ?? null;
    $todayAppointments = array_values(array_filter($appointments, function ($appt) use ($today) {
        return ($appt['appointment_date'] ?? '') === $today && hq_normalize_appointment_status($appt['status'] ?? '') === 'Confirmed';
    }));

    $timelineItems = [];
    foreach ($activeAppointments as $appt) {
        $service = $appt['service_type'] ?? 'Appointment';
        $status = hq_normalize_appointment_status($appt['status'] ?? 'Pending');
        $apptDate = $appt['appointment_date'] ?? '';
        $time = $appt['preferred_time'] ?? '—';
        $label = $apptDate ? date('M j, Y', strtotime($apptDate)) : 'Date pending';

        $timelineItems[] = [
            'title' => $service,
            'subtitle' => $label . ' at ' . $time,
            'status' => $status,
            'is_next' => $nextAppointment && (int) $nextAppointment['id'] === (int) $appt['id'],
        ];
    }

    $dashboardCards = [
        [
            'label' => 'Next Appointment',
            'value' => $nextAppointment ? date('M j', strtotime($nextAppointment['appointment_date'])) : 'None',
            'detail' => $nextAppointment ? ($nextAppointment['service_type'] ?? 'Scheduled service') : 'No upcoming home service request',
            'link' => 'profile.php',
        ],
        [
            'label' => 'Upcoming Requests',
            'value' => (string) count(array_filter($appointments, fn($appt) => !in_array(hq_normalize_appointment_status($appt['status'] ?? ''), ['Completed', 'Cancelled'], true))),
            'detail' => 'Upcoming home service schedules saved in your account',
            'link' => 'profile.php',
        ],
        [
            'label' => 'Unread Notifications',
            'value' => (string) $unreadCount,
            'detail' => 'Updates from appointments, results, and corporate inquiries',
            'link' => 'profile.php?tab=inbox',
        ],
        [
            'label' => 'Profile Completion',
            'value' => hq_profile_completion_score($user) . '%',
            'detail' => 'Keep your patient details updated',
            'link' => 'profile.php?tab=info',
        ],
        [
            'label' => 'Today Schedule',
            'value' => (string) count($todayAppointments),
            'detail' => 'Confirmed home service schedules happening today',
            'link' => 'profile.php?tab=appointments',
        ],
        [
            'label' => 'Corporate Requests',
            'value' => (string) count($corpInquiries),
            'detail' => 'Track package and company inquiry updates',
            'link' => 'profile.php?tab=appointments',
        ],
    ];

    $quickLinks = [
        ['label' => 'Book Home Service', 'href' => 'booking.php'],
        ['label' => 'Open Inbox', 'href' => 'profile.php?tab=inbox'],
        ['label' => 'Corporate Inquiry', 'href' => 'corporateservice.php'],
        ['label' => 'Update Profile', 'href' => 'profile.php?tab=info'],
    ];

    $banners = [];
    foreach ($appointments as $appt) {
        $status = hq_normalize_appointment_status($appt['status'] ?? 'Pending');
        $service = $appt['service_type'] ?? '';
        $date = $appt['appointment_date'] ?? '';
        $time = $appt['preferred_time'] ?? '';
        $appointmentId = (int) ($appt['id'] ?? 0);
        if ($status === 'Cancelled' || $status === 'Completed') {
            continue;
        }

        if ($status === 'Confirmed') {
            if ($date === $today) {
                $banners[] = [
                    'type' => 'today',
                    'icon' => 'TD',
                    'title' => 'Appointment Today',
                    'msg' => "Your confirmed <strong>{$service}</strong> appointment is scheduled today at <strong>{$time}</strong>.",
                    'color' => 'green',
                ];
            } elseif ($date === $tomorrow) {
                $banners[] = [
                    'type' => 'tomorrow',
                    'icon' => 'TM',
                    'title' => 'Appointment Tomorrow',
                    'msg' => "Your confirmed <strong>{$service}</strong> appointment is tomorrow at <strong>{$time}</strong>.",
                    'color' => 'teal',
                ];
            } elseif ($date === $threeDays) {
                $banners[] = [
                    'type' => '3day',
                    'icon' => 'PL',
                    'title' => 'Appointment in 3 Days',
                    'msg' => "Your confirmed <strong>{$service}</strong> appointment is on <strong>" . date('F j, Y', strtotime($date)) . " at {$time}</strong>.",
                    'color' => 'green',
                ];
            }
        }

        foreach ($fastingKeywords as $keyword) {
            if ($status === 'Confirmed' && $date === $tomorrow && stripos($service, $keyword) !== false) {
                $banners[] = [
                    'type' => 'fasting',
                    'icon' => 'PR',
                    'title' => 'Preparation Reminder',
                    'msg' => $prepNotes[$keyword] ?? 'Please follow the preparation instructions for your service.',
                    'color' => 'yellow',
                    'important' => true,
                ];
                break;
            }
        }

        if (isset($rescheduleByAppointment[$appointmentId])) {
            $request = $rescheduleByAppointment[$appointmentId];
            $banners[] = [
                'type' => 'reschedule_requested',
                'icon' => 'RS',
                'title' => 'Reschedule Request Submitted',
                'msg' => 'Your request to move this appointment is currently under review.',
                'color' => 'gray',
            ];
        }
    }

    return [
        'today' => $today,
        'tomorrow' => $tomorrow,
        'three_days' => $threeDays,
        'user' => $user,
        'appointments' => $appointments,
        'active_appointments' => $activeAppointments,
        'next_appointment' => $nextAppointment,
        'today_appointments' => $todayAppointments,
        'corporate_inquiries' => $corpInquiries,
        'lab_results' => $labResults,
        'notifications' => $notifications,
        'unread_count' => $unreadCount,
        'quick_links' => $quickLinks,
        'dashboard_cards' => $dashboardCards,
        'timeline_items' => $timelineItems,
        'banners' => $banners,
        'reschedule_requests' => $rescheduleRequests,
        'reschedule_by_appointment' => $rescheduleByAppointment,
        'fasting_keywords' => $fastingKeywords,
        'prep_notes' => $prepNotes,
        'recent_activity' => hq_patient_recent_activity($appointments, $corpInquiries, $labResults, $notifications),
        'next_steps' => hq_patient_next_steps([
            'user' => $user,
            'next_appointment' => $nextAppointment,
            'lab_results' => $labResults,
            'notifications' => $notifications,
            'corporate_inquiries' => $corpInquiries,
            'reschedule_requests' => $rescheduleRequests,
        ]),
        'result_summary' => hq_result_summary($labResults),
        'appointment_cards' => hq_patient_appointment_cards($activeAppointments, $rescheduleByAppointment, $prepNotes, $fastingKeywords),
    ];
}

function hq_profile_completion_score(array $user): int
{
    $fields = ['fullname', 'email', 'contact_number', 'address', 'dob'];
    $complete = 0;
    foreach ($fields as $field) {
        if (!empty($user[$field])) {
            $complete++;
        }
    }
    return (int) round(($complete / count($fields)) * 100);
}

function hq_request_reschedule(PDO $conn, int $appointmentId, int $userId, string $date, string $time, string $reason = ''): bool
{
    hq_ensure_runtime_schema($conn);

    $lookup = $conn->prepare("
        SELECT *
        FROM home_service_appointments
        WHERE id = ? AND user_id = ?
        LIMIT 1
    ");
    $lookup->execute([$appointmentId, $userId]);
    $appointment = $lookup->fetch(PDO::FETCH_ASSOC);

    if (!$appointment) {
        return false;
    }

    $status = hq_normalize_appointment_status($appointment['status'] ?? 'Pending');
    if (in_array($status, ['Cancelled', 'Completed'], true)) {
        return false;
    }

    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date) || $date < date('Y-m-d')) {
        return false;
    }

    if (!in_array($time, hq_booking_allowed_slots(), true)) {
        return false;
    }

    $existing = $conn->prepare("
        SELECT id
        FROM reschedule_requests
        WHERE appointment_id = ? AND user_id = ? AND status = 'Pending'
        LIMIT 1
    ");
    $existing->execute([$appointmentId, $userId]);
    if ($existing->fetchColumn()) {
        return false;
    }

    $stmt = $conn->prepare("
        INSERT INTO reschedule_requests (appointment_id, user_id, requested_date, requested_time, reason, status, created_at, updated_at)
        VALUES (?, ?, ?, ?, ?, 'Pending', NOW(), NOW())
    ");
    $stmt->execute([$appointmentId, $userId, $date, $time, $reason]);

    hq_create_notification($conn, [
        'user_id' => $userId,
        'appointment_id' => $appointmentId,
        'source_type' => 'appointment',
        'source_id' => $appointmentId,
        'type' => 'reschedule_requested',
        'title' => 'Reschedule Request Received',
        'message' => 'Your request to move your appointment has been submitted to our team for review.',
        'action_url' => 'profile.php?tab=appointments',
    ]);

    return true;
}
