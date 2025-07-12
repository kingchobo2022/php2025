<?php
$dsn = 'mysql:host=localhost;dbname=kingchobo;charset=utf8mb4';
$username = 'root';
$password = 'kingchobopassword';

try {
  $pdo = new PDO($dsn, $username, $password, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  ]);
  
} catch (PDOException $e) {
  echo "DB connection error : ". $e->getMessage();
}
