<?php
// InfinityFree Configuration
$host = 'sql303.infinityfree.com';
$dbname = 'if0_41961050_mydb';
$username = 'if0_41961050';
$password = 'adrian154';

try {
    $db = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8mb4", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check and add kode_barang
    try {
        $db->exec("ALTER TABLE produk ADD COLUMN kode_barang VARCHAR(50) NULL AFTER id");
        echo "Kolom kode_barang berhasil ditambahkan.\n";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate column name') !== false) {
            echo "Kolom kode_barang sudah ada.\n";
        } else {
            throw $e;
        }
    }

    // Check and add stok
    try {
        $db->exec("ALTER TABLE produk ADD COLUMN stok INT NOT NULL DEFAULT 0 AFTER harga");
        echo "Kolom stok berhasil ditambahkan.\n";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate column name') !== false) {
            echo "Kolom stok sudah ada.\n";
        } else {
            throw $e;
        }
    }
    
    // Update existing products to have default kode_barang if empty
    $db->exec("UPDATE produk SET kode_barang = CONCAT('BRG-', id) WHERE kode_barang IS NULL OR kode_barang = ''");
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
