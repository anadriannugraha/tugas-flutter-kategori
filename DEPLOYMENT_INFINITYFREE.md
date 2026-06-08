# Deployment Guide - InfinityFree Hosting

## Langkah 1: Setup Database di InfinityFree

1. Login ke cPanel InfinityFree Anda
2. Buka **MySQL Databases**
3. Buat database baru:
   - Database name: `if0_xxxxxxxx_mydb` (catat nama database)
   - Username: `if0_xxxxxxxx` (catat username)
   - Password: (buat password dan catat)
   - Host: `sqlxxx.infinityfree.com` (catat hostname dari panel)

4. Klik **phpMyAdmin** untuk database yang baru dibuat
5. Jalankan SQL berikut untuk membuat tabel:

```sql
CREATE TABLE `kategori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `produk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_barang` varchar(50) DEFAULT NULL,
  `nama_produk` varchar(100) DEFAULT NULL,
  `harga` decimal(10,2) DEFAULT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `kategori_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
);
```

## Langkah 2: Update Konfigurasi Database

### Update `config/Database.php`

Buka file `config/Database.php` dan uncomment baris konfigurasi InfinityFree:

```php
private $host = 'sqlxxx.infinityfree.com'; // Ganti dengan hostname Anda
private $dbname = 'if0_xxxxxxxx_mydb';     // Ganti dengan nama database Anda
private $username = 'if0_xxxxxxxx';         // Ganti dengan username Anda
private $password = 'your_password_here';   // Ganti dengan password Anda
```

Comment atau hapus baris konfigurasi localhost:
```php
// private $host = 'localhost';
// private $dbname = 'mydb';
// private $username = 'root';
// private $password = '';
```

### Update `migrate.php`

Buka file `migrate.php` dan update dengan kredensial yang sama:

```php
$host = 'sqlxxx.infinityfree.com';
$dbname = 'if0_xxxxxxxx_mydb';
$username = 'if0_xxxxxxxx';
$password = 'your_password_here';
```

## Langkah 3: Upload File ke InfinityFree

### Via File Manager (cPanel)

1. Login ke cPanel InfinityFree
2. Buka **Online File Manager**
3. Masuk ke folder `htdocs`
4. Upload semua file dari project:
   - `index.php`
   - `.htaccess`
   - Folder `config/`
   - Folder `controllers/`
   - Folder `models/`
   - Folder `frontend/` (opsional)
   - `migrate.php` (untuk setup awal)
   - `create_produk_table.php` (opsional)

### Via FTP

1. Gunakan FileZilla atau FTP client lain
2. Gunakan kredensial FTP dari cPanel InfinityFree
3. Upload semua file ke folder `htdocs`

## Langkah 4: Jalankan Migration (Opsional)

Jika perlu menjalankan migration untuk menambah kolom:

1. Buka browser dan akses: `https://yourdomain.infinityfreeapp.com/migrate.php`
2. Jika berhasil, akan muncul pesan konfirmasi
3. Hapus file `migrate.php` setelah selesai untuk keamanan

## Langkah 5: Update Base Path (Jika Diperlukan)

Jika API tidak berjalan dengan benar, cek `index.php` baris 25:

```php
$basePath = '/simple_api'; // Adjust if needed
```

Ubah sesuai dengan struktur folder di InfinityFree. Jika file langsung di `htdocs`, biarkan kosong:
```php
$basePath = ''; 
```

## Langkah 6: Testing API

### Test Endpoint

Gunakan curl atau Postman untuk testing:

```bash
# GET all categories
curl -X GET https://yourdomain.infinityfreeapp.com/kategori

# POST create category
curl -X POST https://yourdomain.infinityfreeapp.com/kategori \
  -H "Content-Type: application/json" \
  -d '{"nama_kategori": "Elektronik"}'

# GET all products
curl -X GET https://yourdomain.infinityfreeapp.com/produk
```

## Troubleshooting

### Error 500 Internal Server Error

1. Cek error log di cPanel: **Error Logs**
2. Pastikan kredensial database sudah benar
3. Pastikan tabel database sudah dibuat

### CORS Error

CORS sudah di-enable di `index.php`, tapi jika masih ada masalah:
- Pastikan tidak ada plugin browser yang memblokir
- Cek header response dengan browser DevTools

### Database Connection Failed

1. Pastikan hostname database benar (bukan localhost)
2. Pastikan database user sudah ditambahkan ke database dengan permission yang benar
3. Cek jika password mengandung karakter khusus, mungkin perlu di-escape

## Security Tips

1. **Hapus file setup** setelah deployment:
   - `migrate.php`
   - `create_produk_table.php`

2. **Jangan commit kredensial** ke version control
   - Gunakan environment variables jika memungkinkan

3. **Backup database** secara berkala dari phpMyAdmin

## Struktur File Setelah Deployment

```
htdocs/
├── .htaccess
├── index.php
├── config/
│   └── Database.php
├── controllers/
│   ├── KategoriController.php
│   └── ProdukController.php
├── models/
│   ├── Kategori.php
│   └── Produk.php
└── frontend/
    └── index.html
```

## API Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/kategori` | List all categories |
| GET | `/kategori/{id}` | Get category by ID |
| POST | `/kategori` | Create new category |
| PUT | `/kategori/{id}` | Update category |
| DELETE | `/kategori/{id}` | Delete category |
| GET | `/kategori/{id}/produk` | Get products by category |
| GET | `/produk` | List all products |
| GET | `/produk/{id}` | Get product by ID |
| POST | `/produk` | Create new product |
| PUT | `/produk/{id}` | Update product |
| DELETE | `/produk/{id}` | Delete product |
