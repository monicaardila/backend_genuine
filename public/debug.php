<?php
// Archivo de debug para Railway
$logFile = '/tmp/railway_debug.log';
$timestamp = date('Y-m-d H:i:s');
$requestUri = $_SERVER['REQUEST_URI'] ?? 'unknown';
$method = $_SERVER['REQUEST_METHOD'] ?? 'unknown';
$port = $_SERVER['PORT'] ?? 'unknown';
$host = $_SERVER['HTTP_HOST'] ?? 'unknown';

$logMessage = "[$timestamp] URI: $requestUri, Method: $method, Port: $port, Host: $host\n";

// Escribir al log
file_put_contents($logFile, $logMessage, FILE_APPEND | LOCK_EX);

// También escribir a error_log
error_log($logMessage);

// Respuesta simple
header('Content-Type: application/json');
http_response_code(200);
echo json_encode([
    'status' => 'debug',
    'message' => 'Debug info logged',
    'timestamp' => $timestamp,
    'request_uri' => $requestUri,
    'method' => $method,
    'port' => $port,
    'host' => $host,
    'log_file' => $logFile
]);
?>
