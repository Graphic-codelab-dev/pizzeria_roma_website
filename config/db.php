<?php
/**
 * Devuelve una instancia PDO conectada. Credenciales desde .env
 * (ver .env.example) — nunca hardcodeadas aquí.
 * Uso: $pdo = require ROOT_PATH . '/config/db.php';
 */

require_once __DIR__ . '/env.php';
load_env(dirname(__DIR__) . '/.env');

$dbHost = env('DB_HOST', '127.0.0.1');
$dbName = env('DB_NAME', 'pizzeria_roma');
$dbUser = env('DB_USER', 'root');
$dbPass = env('DB_PASS', '');

$dsn = "mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    throw new RuntimeException('Database connection failed.', 0, $e);
}

return $pdo;
