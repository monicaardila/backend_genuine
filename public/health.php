<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With, Accept, Origin');
http_response_code(200);
echo json_encode([
    'status' => 'ok',
    'message' => 'API is running',
    'timestamp' => date('c'),
    'service' => 'Laravel API'
]);
exit;
