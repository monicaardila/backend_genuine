<?php
// Script de inicio simple para Railway
$port = $_ENV['PORT'] ?? 8000;
$host = '0.0.0.0';

echo "Starting PHP server on $host:$port\n";
echo "Document root: " . __DIR__ . "/public\n";

// Crear archivo de healthcheck simple
$healthFile = __DIR__ . '/public/health.txt';
file_put_contents($healthFile, 'OK');

// Iniciar servidor
$command = "php -S $host:$port -t public";
echo "Command: $command\n";

// Ejecutar comando
passthru($command);
?>
