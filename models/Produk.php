<?php
/**
 * Produk Model - CRUD operations for produk table
 */

require_once __DIR__ . '/../config/Database.php';

class Produk {
    private $conn;
    private $table = 'produk';
    
    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }
    
    public function getAll($search = '') {
        $query = "SELECT p.*, k.nama_kategori 
                 FROM {$this->table} p 
                 LEFT JOIN kategori k ON p.kategori_id = k.id ";
                 
        if (!empty($search)) {
            $query .= " WHERE p.nama_produk LIKE :search OR p.kode_barang LIKE :search ";
        }
        
        $query .= " ORDER BY p.created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        
        if (!empty($search)) {
            $keyword = "%{$search}%";
            $stmt->bindParam(':search', $keyword);
        }
        
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getById($id) {
        $query = "SELECT p.*, k.nama_kategori 
                 FROM {$this->table} p 
                 LEFT JOIN kategori k ON p.kategori_id = k.id 
                 WHERE p.id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function create($data) {
        $query = "INSERT INTO {$this->table} (kode_barang, nama_produk, harga, stok, deskripsi, kategori_id) 
                 VALUES (:kode_barang, :nama_produk, :harga, :stok, :deskripsi, :kategori_id)";
        
        $stmt = $this->conn->prepare($query);
        
        $kode_barang = htmlspecialchars(strip_tags($data['kode_barang'] ?? ''));
        $nama_produk = htmlspecialchars(strip_tags($data['nama_produk']));
        $harga = htmlspecialchars(strip_tags($data['harga']));
        $stok = htmlspecialchars(strip_tags($data['stok'] ?? 0));
        $deskripsi = htmlspecialchars(strip_tags($data['deskripsi'] ?? ''));
        $kategori_id = htmlspecialchars(strip_tags($data['kategori_id']));
        
        $stmt->bindParam(':kode_barang', $kode_barang);
        $stmt->bindParam(':nama_produk', $nama_produk);
        $stmt->bindParam(':harga', $harga);
        $stmt->bindParam(':stok', $stok);
        $stmt->bindParam(':deskripsi', $deskripsi);
        $stmt->bindParam(':kategori_id', $kategori_id);
        
        return $stmt->execute();
    }
    
    public function update($id, $data) {
        $query = "UPDATE {$this->table} 
                 SET kode_barang = :kode_barang,
                     nama_produk = :nama_produk, 
                     harga = :harga, 
                     stok = :stok,
                     deskripsi = :deskripsi, 
                     kategori_id = :kategori_id 
                 WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $kode_barang = htmlspecialchars(strip_tags($data['kode_barang'] ?? ''));
        $nama_produk = htmlspecialchars(strip_tags($data['nama_produk']));
        $harga = htmlspecialchars(strip_tags($data['harga']));
        $stok = htmlspecialchars(strip_tags($data['stok'] ?? 0));
        $deskripsi = htmlspecialchars(strip_tags($data['deskripsi'] ?? ''));
        $kategori_id = htmlspecialchars(strip_tags($data['kategori_id']));
        
        $stmt->bindParam(':kode_barang', $kode_barang);
        $stmt->bindParam(':nama_produk', $nama_produk);
        $stmt->bindParam(':harga', $harga);
        $stmt->bindParam(':stok', $stok);
        $stmt->bindParam(':deskripsi', $deskripsi);
        $stmt->bindParam(':kategori_id', $kategori_id);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }
    
    public function delete($id) {
        $query = "DELETE FROM {$this->table} WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        
        return $stmt->execute();
    }
    
    public function getByKategori($kategori_id) {
        $query = "SELECT p.*, k.nama_kategori 
                 FROM {$this->table} p 
                 LEFT JOIN kategori k ON p.kategori_id = k.id 
                 WHERE p.kategori_id = ? 
                 ORDER BY p.nama_produk";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $kategori_id);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
