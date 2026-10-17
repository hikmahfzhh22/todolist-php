# To-Do List PHP

## Deskripsi

Aplikasi To-Do List sederhana berbasis PHP dan MySQL untuk mencatat dan mengelola tugas harian. Aplikasi ini memiliki fitur CRUD (tambah, lihat, edit, dan hapus tugas) serta penanda tugas yang sudah selesai, dengan tampilan bernuansa biru gradasi menggunakan Bootstrap 5.

## Cara Penggunaan

### Menjalankan Aplikasi

1. Pasang XAMPP, lalu jalankan **Apache** dan **MySQL** lewat XAMPP Control Panel.
2. Salin folder proyek ke `htdocs` (contoh: `C:\xampp\htdocs\todolist`).
3. Buka `http://localhost/phpmyadmin`, lalu buat database bernama `todolist`.
4. Pada database tersebut, buka tab **SQL** dan jalankan:

   ```sql
   CREATE TABLE tugas (
       id INT AUTO_INCREMENT PRIMARY KEY,
       judul VARCHAR(200) NOT NULL,
       selesai TINYINT(1) NOT NULL DEFAULT 0
   );
   ```

5. Sesuaikan koneksi database di bagian atas `data.php` bila perlu (`$host`, `$db`, `$user`, `$pass`).
6. Buka `http://localhost/todolist/index.php` di browser.

### Menggunakan Aplikasi

- **Tambah tugas**: ketik nama tugas pada kolom input, lalu klik **Tambah**.
- **Tandai selesai**: centang kotak di sebelah kiri tugas. Klik lagi untuk membatalkan.
- **Edit tugas**: klik tombol pensil, ubah judul pada jendela yang muncul, lalu klik **Simpan**.
- **Hapus tugas**: klik tombol tempat sampah, lalu konfirmasi dengan **Ya, Hapus**.

## Struktur Folder

```
todolist/
├── index.php    # Tampilan halaman utama
├── proses.php   # Logika tambah, edit, ubah status, dan hapus
├── data.php     # Koneksi database dan fungsi bantu
├── style.css    # Styling tambahan
└── README.md    # Dokumentasi proyek
```
