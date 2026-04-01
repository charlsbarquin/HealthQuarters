<?php

function hq_table_exists(PDO $conn, string $table): bool
{
    $stmt = $conn->prepare("
        SELECT COUNT(*)
        FROM information_schema.tables
        WHERE table_schema = DATABASE() AND table_name = ?
    ");
    $stmt->execute([$table]);

    return (int) $stmt->fetchColumn() > 0;
}

function hq_column_exists(PDO $conn, string $table, string $column): bool
{
    $stmt = $conn->prepare("
        SELECT COUNT(*)
        FROM information_schema.columns
        WHERE table_schema = DATABASE() AND table_name = ? AND column_name = ?
    ");
    $stmt->execute([$table, $column]);

    return (int) $stmt->fetchColumn() > 0;
}

function hq_ensure_runtime_schema(PDO $conn): void
{
    // Request-time schema mutations were intentionally removed.
    // Use the SQL setup scripts for schema maintenance.
}
