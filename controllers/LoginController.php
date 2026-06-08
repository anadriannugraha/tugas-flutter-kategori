<?php
// LoginController.php - unified login endpoint
// Accepts JSON with either {"username":"...","password":"..."} or {"email":"...","password":"..."}
// Returns JWT-like token (placeholder) on success.

class LoginController {
    public function login() {
        // Allow only POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Method not allowed'], JSON_PRETTY_PRINT);
            return;
        }
        $data = json_decode(file_get_contents('php://input'));
        if (empty($data)) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Invalid JSON body'], JSON_PRETTY_PRINT);
            return;
        }
        // Determine login type
        $isUsername = property_exists($data, 'username');
        $isEmail = property_exists($data, 'email');
        if ($isUsername) {
            if (empty($data->username) || empty($data->password)) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'Username and password required'], JSON_PRETTY_PRINT);
                return;
            }
            // Simple static check (replace with DB in production)
            if ($data->username === 'admin' && $data->password === 'password123') {
                $this->respondSuccess($data->username);
                return;
            }
        } elseif ($isEmail) {
            if (empty($data->email) || empty($data->password)) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'Email and password required'], JSON_PRETTY_PRINT);
                return;
            }
            if ($data->email === 'adrian@bsi.ac.id' && $data->password === 'P@ssword') {
                $this->respondSuccess($data->email);
                return;
            }
        } else {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Missing login identifier'], JSON_PRETTY_PRINT);
            return;
        }
        // If we reach here, authentication failed
        http_response_code(401);
        echo json_encode(['status' => 'error', 'message' => 'Invalid credentials'], JSON_PRETTY_PRINT);
    }

    private function respondSuccess($identifier) {
        http_response_code(200);
        echo json_encode([
            'status' => 'success',
            'message' => 'Login successful',
            'data' => [
                'identifier' => $identifier,
                'token' => 'placeholder_token_' . bin2hex(random_bytes(8))
            ]
        ], JSON_PRETTY_PRINT);
    }
}
?>
