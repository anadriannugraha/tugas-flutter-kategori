<?php
// Handles produk logic and endpoints

require_once __DIR__ . '/../models/Produk.php';

class ProdukController {
    private $produk;
    
    public function __construct() {
        $this->produk = new Produk();
    }
    
    public function getAll() {
        $search = $_GET['search'] ?? '';
        $result = $this->produk->getAll($search);
        http_response_code(200);
        echo json_encode(['status' => 'success', 'data' => $result], JSON_PRETTY_PRINT);
    }
    
    public function getById($id) {
        $result = $this->produk->getById($id);
        if ($result) {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'data' => $result], JSON_PRETTY_PRINT);
        } else {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Produk not found'], JSON_PRETTY_PRINT);
        }
    }
    
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($input['nama_produk']) || empty(trim($input['nama_produk']))) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'nama_produk is required'], JSON_PRETTY_PRINT);
                return;
            }
            
            if (!isset($input['harga']) || !is_numeric($input['harga'])) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'harga is required and must be numeric'], JSON_PRETTY_PRINT);
                return;
            }
            
            if (!isset($input['kategori_id']) || !is_numeric($input['kategori_id'])) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'kategori_id is required and must be numeric'], JSON_PRETTY_PRINT);
                return;
            }
            
            if ($this->produk->create([
                'kode_barang' => $input['kode_barang'] ?? '',
                'nama_produk' => trim($input['nama_produk']),
                'harga' => $input['harga'],
                'stok' => $input['stok'] ?? 0,
                'deskripsi' => $input['deskripsi'] ?? '',
                'kategori_id' => $input['kategori_id']
            ])) {
                http_response_code(201);
                echo json_encode(['status' => 'success', 'message' => 'Produk created successfully'], JSON_PRETTY_PRINT);
            } else {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Failed to create produk'], JSON_PRETTY_PRINT);
            }
        }
    }
    
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!isset($input['nama_produk']) || empty(trim($input['nama_produk']))) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'nama_produk is required'], JSON_PRETTY_PRINT);
                return;
            }
            
            if (!isset($input['harga']) || !is_numeric($input['harga'])) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'harga is required and must be numeric'], JSON_PRETTY_PRINT);
                return;
            }
            
            if (!isset($input['kategori_id']) || !is_numeric($input['kategori_id'])) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'kategori_id is required and must be numeric'], JSON_PRETTY_PRINT);
                return;
            }
            
            if ($this->produk->update($id, [
                'kode_barang' => $input['kode_barang'] ?? '',
                'nama_produk' => trim($input['nama_produk']),
                'harga' => $input['harga'],
                'stok' => $input['stok'] ?? 0,
                'deskripsi' => $input['deskripsi'] ?? '',
                'kategori_id' => $input['kategori_id']
            ])) {
                http_response_code(200);
                echo json_encode(['status' => 'success', 'message' => 'Produk updated successfully'], JSON_PRETTY_PRINT);
            } else {
                http_response_code(404);
                echo json_encode(['status' => 'error', 'message' => 'Produk not found or failed to update'], JSON_PRETTY_PRINT);
            }
        }
    }
    
    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            if ($this->produk->delete($id)) {
                http_response_code(200);
                echo json_encode(['status' => 'success', 'message' => 'Produk deleted successfully'], JSON_PRETTY_PRINT);
            } else {
                http_response_code(404);
                echo json_encode(['status' => 'error', 'message' => 'Produk not found'], JSON_PRETTY_PRINT);
            }
        }
    }
    
    public function getByKategori($kategori_id) {
        $result = $this->produk->getByKategori($kategori_id);
        if ($result) {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'data' => $result], JSON_PRETTY_PRINT);
        } else {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'data' => [], 'message' => 'No products found in this category'], JSON_PRETTY_PRINT);
        }
    }
}
?>
