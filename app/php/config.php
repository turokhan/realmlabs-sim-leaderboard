<?php
$dbHost = getenv('DB_HOST') ?: '127.0.0.1';
$dbUsername = getenv('DB_USER') ?: 'leaderboard';
$dbPassword = getenv('DB_PASSWORD') ?: '';
$dbName = getenv('DB_NAME') ?: 'sim_racing';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
    $conn->set_charset('utf8mb4');
} catch (mysqli_sql_exception $e) {
    http_response_code(503);
    exit('Database unavailable. Check the hosting configuration.');
}
