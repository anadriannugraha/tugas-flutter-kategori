<?php

class AuthController {
    public function login() {
        // Hanya izinkan method POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['status' => 'error', 'message' => 'Method not allowed'], JSON_PRETTY_PRINT);
            return;
        }

        // Ambil data JSON dari body
        $data = json_decode(file_get_contents("php://input"));

        // Validasi input
        if (empty($data->username) || empty($data->password)) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Username dan password harus diisi'], JSON_PRETTY_PRINT);
            return;
        }

        // Simulasi Login (karena kita belum punya tabel users di database)
        if ($data->username === 'admin' && $data->password === 'password123') {
            http_response_code(200);
            echo json_encode([
                'status' => 'success',
                'message' => 'Login berhasil! Selamat datang di GudangZilla',
                'data' => [
                    'token' => 'token_rahasia_gudangzilla_999',
                    'user' => [
                        'username' => 'admin',
                        'role' => 'Administrator'
                    ]
                ]
            ], JSON_PRETTY_PRINT);
        } else {
            http_response_code(401);
            echo json_encode([
                'status' => 'error',
                'message' => 'Username atau password salah'
            ], JSON_PRETTY_PRINT);
        }
    }
}
?>
