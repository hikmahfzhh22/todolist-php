<?php
// Tampilkan pesan error asli saat development (hapus kedua baris ini di server publik)
ini_set('display_errors', '1');
error_reporting(E_ALL);

session_start();

$_SESSION['csrf'] ??= bin2hex(random_bytes(32));

// ===== Pengaturan database \sesuai MYSQL =====
$host = 'localhost';
$db   = 'todolist';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$db;charset=utf8mb4",
        $user,
        $pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $ex) {
    exit('Koneksi database gagal: ' . htmlspecialchars($ex->getMessage()));
}

// Mengamankan teks sebelum ditampilkan di HTML
function e($v): string
{
    return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
}

// Input token keamanan untuk setiap form
function csrf(): string
{
    return '<input type="hidden" name="csrf" value="' . e($_SESSION['csrf']) . '">';
}

// Mengambil semua tugas, hasilnya [id => ['judul' => ..., 'selesai' => ...]]
function ambilTugas(): array
{
    global $pdo;

    return $pdo
        ->query('SELECT id, judul, selesai FROM tugas ORDER BY id ASC')
        ->fetchAll(PDO::FETCH_UNIQUE | PDO::FETCH_ASSOC);
}