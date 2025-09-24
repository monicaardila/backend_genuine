<?php
// Archivo para ver logs de Railway
$logFile = '/tmp/railway_debug.log';

header('Content-Type: text/plain');

if (file_exists($logFile)) {
    echo "=== RAILWAY DEBUG LOGS ===\n\n";
    echo file_get_contents($logFile);
} else {
    echo "No log file found at: $logFile\n";
}

echo "\n=== SERVER INFO ===\n";
echo "PHP Version: " . phpversion() . "\n";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "\n";
echo "Script Name: " . $_SERVER['SCRIPT_NAME'] . "\n";
echo "Request URI: " . $_SERVER['REQUEST_URI'] . "\n";
echo "Server Port: " . $_SERVER['SERVER_PORT'] . "\n";
echo "HTTP Host: " . $_SERVER['HTTP_HOST'] . "\n";

echo "\n=== FILES IN PUBLIC DIRECTORY ===\n";
$files = scandir('.');
foreach ($files as $file) {
    if ($file != '.' && $file != '..') {
        echo "- $file\n";
    }
}
?>
