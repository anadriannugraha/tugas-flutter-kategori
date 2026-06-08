<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=mydb', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "CREATE TABLE IF NOT EXISTS produk (
        id int(11) NOT NULL AUTO_INCREMENT,
        nama_produk varchar(200) NOT NULL,
        harga decimal(10,2) NOT NULL,
        deskripsi text,
        kategori_id int(11) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        FOREIGN KEY (kategori_id) REFERENCES kategori(id) ON DELETE CASCADE
    )";
    
    $pdo->exec($sql);
    echo "Tabel produk berhasil dibuat\n";
    
    // Tambah sample data
    $pdo->exec("INSERT IGNORE INTO produk (nama_produk, harga, deskripsi, kategori_id) VALUES 
        ('Laptop ASUS', 8500000.00, 'Laptop gaming 15.6 inch', 1),
        ('Mouse Logitech', 250000.00, 'Wireless mouse ergonomic', 1),
        ('Kemeja Formal', 150000.00, 'Kemeja katun formal', 2)");
    echo "Sample data berhasil ditambahkan\n";
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
