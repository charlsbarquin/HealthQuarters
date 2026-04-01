<?php
require_once __DIR__ . '/includes/bootstrap.php';

$dbConfig = hq_config('database');

$servername = $dbConfig['host'] ?? 'localhost';
$username = $dbConfig['username'] ?? 'root';
$password = $dbConfig['password'] ?? '';
$dbname = $dbConfig['dbname'] ?? 'healthquarters';
$charset = $dbConfig['charset'] ?? 'utf8mb4';

try {
  $conn = new PDO(
      "mysql:host=$servername;dbname=$dbname;charset=$charset",
      $username,
      $password
  );
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
  die("Connection failed: " . $e->getMessage());
}
?>
