<?php

declare(strict_types=1);

function db(): ?mysqli {
  static $conn = null;
  if ($conn instanceof mysqli) return $conn;

  $cfg = [];
  $cfgPath = __DIR__ . '/../config.local.php';
  if (is_file($cfgPath)) {
    $cfg = require $cfgPath;
    if (!is_array($cfg)) $cfg = [];
  }

  $host = (string)($cfg['DB_HOST'] ?? '127.0.0.1');
  $user = (string)($cfg['DB_USER'] ?? 'root');
  $pass = (string)($cfg['DB_PASS'] ?? '');
  $name = (string)($cfg['DB_NAME'] ?? 'fitness');
  $port = (int)($cfg['DB_PORT'] ?? 3306);

  $mysqli = @new mysqli($host, $user, $pass, $name, $port);
  if ($mysqli->connect_errno) {
    return null;
  }

  $mysqli->set_charset('utf8mb4');
  $conn = $mysqli;
  return $conn;
}
