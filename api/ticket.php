<?php

require __DIR__."/../autoload.php";
require __DIR__."/../functions.php";

use Controllers\TicketController;
use Controllers\DBController;

header('Content-Type: application/json');

// Allow Cross-Origin requests (optional, for development purposes)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');


$controller = new TicketController(new DBController("ticket"));

// Handle OPTIONS requests (for preflight CORS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);
$id = $_GET['id'] ?? null;
//This kind of transformer would be useful elsewhere
$response = [
    'method' => $method,
    'params' => $input,
];

// Handle different HTTP methods
switch ($method) {
    case 'GET':
        if ($id) {
            $data = $controller->show($id);
        }
        else {
            $data = $controller->list($input);
        }
        $response['data'] = $data;
        break;

    case 'POST':
        $data = $controller->create($input);
        break;

    case 'PUT':
        $data = $controller->update($id, $input);
        break;

    case 'DELETE':
        $data = $controller->delete($id);
        break;

    default:
        break;
}

echo json_encode($response);
exit;
