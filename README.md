# Simple REST API & Flutter Neo-Brutalism App

Proyek ini terdiri dari dua bagian utama:
1. **Backend (PHP Native):** Menyediakan REST API untuk autentikasi dan manajemen Kategori (CRUD).
2. **Frontend (Flutter):** Aplikasi *mobile/web* dengan desain bergaya *Neo-Brutalism* dan struktur arsitektur MVC .

---

## 🛠️ Persyaratan Sistem (Prerequisites)
Pastikan Anda sudah menginstal aplikasi berikut di komputer Anda:
- **XAMPP / Laragon** (Untuk MySQL Database dan PHP)
- **Flutter SDK** (Untuk menjalankan aplikasi frontend)
- **Git** (Opsional, untuk *version control*)

---

## 📥 Cara Mendapatkan Kode (Clone)
1. Buka Terminal / CMD di komputer Anda.
2. Arahkan ke folder tempat Anda ingin menyimpan proyek ini (misal: `cd Documents`).
3. Jalankan perintah berikut untuk mengunduh proyek:
   ```bash
   git clone https://github.com/anadriannugraha/tugas-flutter-kategori.git
   cd tugas-flutter-kategori
   ```

---

## 🚀 Cara Menjalankan Backend (PHP API)

1. **Siapkan Database MySQL:**
   - Buka XAMPP/Laragon dan jalankan **MySQL**.
   - Buka phpMyAdmin (biasanya di `http://localhost/phpmyadmin`).
   - Buat database baru (misalnya `simple_api` atau sesuai yang ada di file `config/Database.php`).
   - *Import* tabel yang dibutuhkan atau jalankan skrip SQL yang ada di folder `database/` (jika ada).

2. **Jalankan Server PHP:**
   - Buka Terminal / Command Prompt (CMD).
   - Arahkan ke folder utama proyek ini:
     ```bash
     cd path/ke/folder/proyek/ini
     ```
   - Jalankan perintah *built-in server* PHP di port 8000:
     ```bash
     php -S localhost:8000
     ```
   - **PENTING:** Biarkan terminal ini tetap terbuka! Backend API Anda sekarang berjalan di `http://localhost:8000`.

---

## 🌐 Cara Menjalankan Web Frontend (GudangZilla)

1. Buka File Manager Anda, lalu arahkan ke folder `frontend`.
2. Buka (Klik 2 kali) file `index.html` menggunakan browser (Google Chrome / Edge).
3. Anda akan melihat halaman Login dengan tema Neo-Brutalism.
4. Silakan gunakan akses berikut untuk login:
   - **Username:** `admin`
   - **Password:** `password123`

---

## 📱 Cara Menjalankan Frontend (Flutter)

1. **Buka Terminal Baru:**
   - Buka terminal / CMD baru (jangan tutup terminal PHP tadi).
   - Arahkan ke folder `mobile_app`:
     ```bash
     cd path/ke/folder/proyek/ini/mobile_app
     ```

2. **Instal Dependensi (Package):**
   - Jalankan perintah berikut untuk mengunduh semua package yang dibutuhkan (seperti `http`):
     ```bash
     flutter pub get
     ```

3. **Jalankan Aplikasi:**
   - Untuk menjalankan aplikasi di browser (Google Chrome), ketik:
     ```bash
     flutter run -d chrome
     ```
   - Tunggu proses *build* selesai. Aplikasi akan otomatis terbuka di browser Anda.
   
4. **Login:**
   - Email: `15230869@bsi.ac.id`
   - Password: `21-07-2004`

---

## 📂 Struktur Proyek Utama
```text
/
├── config/             # Konfigurasi Database PHP
├── controllers/        # Logika API PHP
├── database/           # Skrip backup/migrasi DB
├── models/             # Model API PHP
├── mobile_app/         # PROYEK FLUTTER
│   ├── lib/
│   │   ├── models/
│   │   ├── screens/
│   │   │   ├── dashboard/
│   │   │   │   ├── edit_profile.dart
│   │   │   │   └── view_profile.dart
│   │   │   ├── kategori/
│   │   │   │   ├── add_kategori.dart
│   │   │   │   ├── edit_kategori.dart
│   │   │   │   ├── kategori_screen.dart
│   │   │   │   └── list_kategori.dart
│   │   │   └── login_screen.dart
│   │   ├── services/
│   │   │   ├── api_autentikasi.dart
│   │   │   ├── api_berita.dart
│   │   │   ├── api_config.dart
│   │   │   ├── api_kategori.dart
│   │   │   └── api_notes.dart
│   │   └── main.dart
```

---

## 📸 Tampilan Aplikasi

| Screen Login | Screen Dashboard |
| :---: | :---: |
| <img src="mobile_app/assets/Login%20pages.png" width="250"> | <img src="mobile_app/assets/dashoard%20admin.png" width="250"> |

| Screen Kategori | Screen Add Kategori |
| :---: | :---: |
| <img src="mobile_app/assets/Kategori%20screen.png" width="250"> | <img src="mobile_app/assets/Tambah%20kategori.png" width="250"> |

*(Screenshot lainnya seperti Halaman Notes juga tersedia di folder `mobile_app/assets`)*
