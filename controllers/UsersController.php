<?php

class UsersController {
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
        if (empty($data->email) || empty($data->password)) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Email dan password harus diisi'], JSON_PRETTY_PRINT);
            return;
        }

        // Validasi Email & Password secara statis sesuai permintaan tugas
        if ($data->email === 'adrian@bsi.ac.id' && $data->password === 'P@ssword') {
            http_response_code(200);
            echo json_encode([
                'status' => 'success',
                'message' => 'Login successful',
                'data' => [
                    'id' => 1,
                    'nama' => 'Adrian Nugraha',
                    'username' => '15230869',
                    'email' => 'adrian@bsi.ac.id',
                    'role_id' => 1,
                    'is_active' => 1,
                    'created_at' => '2024-10-09',
                    'updated_at' => '2024-10-09'
                ]
            ], JSON_PRETTY_PRINT);
        } else {
            http_response_code(401);
            echo json_encode([
                'status' => 'error',
                'message' => 'Email atau password salah'
            ], JSON_PRETTY_PRINT);
        }
    }
}
?>
