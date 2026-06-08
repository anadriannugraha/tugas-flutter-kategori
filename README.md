# 🚀 Simple REST API & Flutter Neo-Brutalism App

Halo! Selamat datang di proyek **GudangZilla**! 🦖 
Proyek ini seru banget karena dibagi jadi dua bagian utama:
1. **Backend (PHP Native):** Si mesin di balik layar yang nyediain REST API buat urusan login dan atur data Kategori (CRUD).
2. **Frontend (Flutter):** Aplikasi *mobile/web* yang desainnya pakai gaya *Neo-Brutalism* yang lagi hype banget. Oh ya, strukturnya juga udah pakai MVC biar rapi!

---

## 🛠️ Persiapan (Prerequisites)
Sebelum mulai ngoding atau nyobain, pastiin kamu udah punya amunisi ini di laptopmu:
- **XAMPP / Laragon** (Biar bisa nyalain MySQL Database dan PHP)
- **Flutter SDK** (Buat nge-jalanin aplikasi frontend-nya)
- **Git** (Opsional sih, tapi bagus buat *version control*)

---

## 📥 Cara Dapetin Kodenya (Clone)
Pengen langsung nyobain? Gini cara *download* kodenya:
1. Buka Terminal / CMD di laptop kamu.
2. Pindah ke folder tempat kamu mau nyimpen proyek ini (contoh: `cd Documents`).
3. Ketik perintah ajaib ini buat nge-clone proyeknya:
   ```bash
   git clone https://github.com/anadriannugraha/tugas-flutter-kategori.git
   cd tugas-flutter-kategori
   ```

---

## 🚀 Cara Nyalain Backend (PHP API)

1. **Siapin Database MySQL-nya:**
   - Buka XAMPP/Laragon, terus *start* **MySQL**.
   - Buka phpMyAdmin di browser (biasanya `http://localhost/phpmyadmin`).
   - Bikin database baru (misal namanya `simple_api`, atau sesuaikan sama file `config/Database.php`).
   - *Import* tabelnya dari skrip SQL yang ada di folder `database/` (kalo ada).

2. **Jalanin Server PHP:**
   - Buka Terminal / CMD.
   - Masuk ke folder utama proyek ini:
     ```bash
     cd path/ke/folder/proyek/ini
     ```
   - Jalanin server lokal PHP di port 8000:
     ```bash
     php -S localhost:8000
     ```
   - **PENTING BANGET:** Jangan di-close ya terminalnya! Biarin aja kebuka biar API kamu tetap jalan di `http://localhost:8000`.

---

## 🌐 Cara Buka Web Frontend (GudangZilla)

Kalo kamu mau liat versi website-nya, gampang banget:
1. Buka File Manager, terus masuk ke folder `frontend`.
2. Buka (klik 2x) file `index.html` pakai browser andalanmu (Chrome / Edge).
3. Nanti bakal muncul halaman Login kartun bergaya Neo-Brutalism.
4. Buat masuk, pake akun ini aja:
   - **Username:** `admin`
   - **Password:** `password123`

---

## 📱 Cara Jalanin Frontend (Flutter)

1. **Buka Terminal Baru:**
   - Buka terminal / CMD baru (ingat, terminal PHP yang tadi jangan ditutup ya).
   - Masuk ke folder `mobile_app`:
     ```bash
     cd path/ke/folder/proyek/ini/mobile_app
     ```

2. **Download Package-nya:**
   - Biar Flutter-nya jalan lancar, kita *download* dulu semua kebutuhannya (kaya `http`):
     ```bash
     flutter pub get
     ```

3. **Gaskeun Aplikasinya:**
   - Kalo mau jalanin aplikasinya di browser (Google Chrome), tinggal ketik:
     ```bash
     flutter run -d chrome
     ```
   - Tunggu proses *build*-nya bentar. Nanti aplikasinya bakal otomatis kebuka di browser kamu.
   
4. **Login:**
   - Nah, buat login di aplikasi Flutter-nya, pake akun ini:
   - Email: `15230869@bsi.ac.id`
   - Password: `21-07-2004`

---

## 📂 Ngintip Struktur Proyeknya
Biar nggak bingung, ini dia isi jeroan proyek kita:
```text
/
├── config/             # Settingan Database PHP
├── controllers/        # Otak dari API PHP-nya
├── database/           # Buat naruh backup/migrasi DB
├── models/             # Kerangka data API PHP
├── mobile_app/         # INI PROYEK FLUTTER-NYA
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

## ☁️ Mau Deploy API ke Hosting Gratis? (InfinityFree / free.nf)

Kalo kamu pengen API-nya bisa diakses dari HP beneran (nggak cuma di laptop doang), kamu bisa *hosting* gratis di InfinityFree. Gini caranya:
1. Bikin akun dulu di [InfinityFree](https://infinityfree.com/).
2. Buat akun hosting baru (*Create Account*) dan pilih subdomain yang keren (misal: `api-gudangzilla.free.nf`).
3. Buka **Control Panel** -> **MySQL Databases**, terus bikin database baru.
4. *Import* file SQL kamu ke database itu lewat phpMyAdmin-nya InfinityFree.
5. Masuk ke **Online File Manager** (buka folder `htdocs`). Ada file `index2.html` bawaan? Hapus aja.
6. *Upload* semua file dan folder PHP (kaya `controllers`, `models`, `config`, dan `index.php`) ke dalam folder `htdocs` tadi.
7. **Penting:** Buka `config/Database.php` terus ganti isinya (Host, Username, Password, DB Name) sesuai sama info database InfinityFree kamu.
8. Voila! API kamu sekarang udah *live* di `http://api-gudangzilla.free.nf`.
*(Psst.. Jangan lupa ganti URL `baseUrl` di file `api_config.dart` pada aplikasi Flutter kamu pake URL yang baru ini ya!)*

---

## 🧪 Tes API Pake Postman

Kalo kamu mau ngetes apakah fitur CRUD-nya jalan atau nggak, kamu bisa main-main pakai **Postman**. Ini contekan URL dan Method-nya:

**Base URL Lokal:** `http://localhost:8000` *(Tinggal ganti aja pake URL hosting kamu kalo udah di-deploy)*

1. **[GET] Liat Semua Kategori**
   - URL: `http://localhost:8000/kategori`
   - Method: `GET`

2. **[POST] Nambah Kategori Baru**
   - URL: `http://localhost:8000/kategori`
   - Method: `POST`
   - Body (Pilih `raw` -> `JSON`):
     ```json
     {
       "nama_kategori": "Teknologi Informasi"
     }
     ```

3. **[PUT] Ngedit Kategori**
   - URL: `http://localhost:8000/kategori/{id}` *(Contoh: `/kategori/5`)*
   - Method: `PUT`
   - Body (Pilih `raw` -> `JSON`):
     ```json
     {
       "nama_kategori": "Teknologi Terkini"
     }
     ```

4. **[DELETE] Hapus Kategori**
   - URL: `http://localhost:8000/kategori/{id}` *(Contoh: `/kategori/5`)*
   - Method: `DELETE`

---

## 📸 Kayak Gini Nih Penampakannya

| Login Dulu Yuk | Dashboard Admin |
| :---: | :---: |
| <img src="mobile_app/assets/Login%20pages.png" width="250"> | <img src="mobile_app/assets/dashoard%20admin.png" width="250"> |

| Daftar Kategori | Tambah Kategori Baru |
| :---: | :---: |
| <img src="mobile_app/assets/Kategori%20screen.png" width="250"> | <img src="mobile_app/assets/Tambah%20kategori.png" width="250"> |

*(Mau liat screenshot lain kayak Halaman Notes? Cek aja di folder `mobile_app/assets`)*
