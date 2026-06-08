<?php
// App Router
// Handles routing for API endpoints

// Enable CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json; charset=UTF-8');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once __DIR__ . '/controllers/KategoriController.php';
require_once __DIR__ . '/controllers/ProdukController.php';
require_once __DIR__ . '/controllers/LoginController.php';
require_once __DIR__ . '/controllers/UsersController.php';
require_once __DIR__ . '/controllers/AuthController.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestUri = trim($requestUri, '/');

// Dynamically detect and remove base path (works for subdirectories under XAMPP/Apache)
$scriptDir = trim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
if ($scriptDir !== '') {
    if (strpos($requestUri, $scriptDir) === 0) {
        $requestUri = substr($requestUri, strlen($scriptDir));
    }
}
$requestUri = trim($requestUri, '/');

$pathParts = explode('/', $requestUri);
$resource = $pathParts[0] ?? '';
$id = $pathParts[1] ?? null;
$subResource = $pathParts[2] ?? null;

try {
    switch ($resource) {
        case 'kategori':
            $controller = new KategoriController();
            if ($id === null) {
                // /kategori
                if ($requestMethod === 'GET') {
                    $controller->getAll();
                } elseif ($requestMethod === 'POST') {
                    $controller->create();
                } else {
                    http_response_code(405);
                    echo json_encode(['status' => 'error', 'message' => 'Method not allowed'], JSON_PRETTY_PRINT);
                }
            } else {
                // /kategori/{id} or /kategori/{id}/produk
                if ($subResource === 'produk') {
                    // /kategori/{id}/produk - get products by category
                    if ($requestMethod === 'GET') {
                        $produkController = new ProdukController();
                        $produkController->getByKategori($id);
                    } else {
                        http_response_code(405);
                        echo json_encode(['status' => 'error', 'message' => 'Method not allowed'], JSON_PRETTY_PRINT);
                    }
                } else {
                    // /kategori/{id}
                    if ($requestMethod === 'GET') {
                        $controller->getById($id);
                    } elseif ($requestMethod === 'PUT') {
                        $controller->update($id);
                    } elseif ($requestMethod === 'DELETE') {
                        $controller->delete($id);
                    } else {
                        http_response_code(405);
                        echo json_encode(['status' => 'error', 'message' => 'Method not allowed'], JSON_PRETTY_PRINT);
                    }
                }
            }
            break;
            
        case 'produk':
            $produkController = new ProdukController();
            if ($id === null) {
                // /produk
                if ($requestMethod === 'GET') {
                    $produkController->getAll();
                } elseif ($requestMethod === 'POST') {
                    $produkController->create();
                } else {
                    http_response_code(405);
                    echo json_encode(['status' => 'error', 'message' => 'Method not allowed'], JSON_PRETTY_PRINT);
                }
            } else {
                // /produk/{id}
                if ($requestMethod === 'GET') {
                    $produkController->getById($id);
                } elseif ($requestMethod === 'PUT') {
                    $produkController->update($id);
                } elseif ($requestMethod === 'DELETE') {
                    $produkController->delete($id);
                } else {
                    http_response_code(405);
                    echo json_encode(['status' => 'error', 'message' => 'Method not allowed'], JSON_PRETTY_PRINT);
                }
            }
            break;
        case 'users':
            if ($id === 'login' && $requestMethod === 'POST') {
                $usersController = new UsersController();
                $usersController->login();
            } else {
                http_response_code(404);
                echo json_encode(['status' => 'error', 'message' => 'Endpoint not found'], JSON_PRETTY_PRINT);
            }
            break;
            
        case 'login':
            $loginController = new LoginController();
            $loginController->login();
            break;
            
        case '':
            header('Location: frontend/index.html');
            exit();
            
        default:
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Endpoint not found'], JSON_PRETTY_PRINT);
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()], JSON_PRETTY_PRINT);
}
?>
