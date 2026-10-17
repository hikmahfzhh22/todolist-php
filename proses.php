<?php
// Memproses aksi tambah, edit, ubah status, dan hapus ke database
require 'data.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['csrf'], (string) ($_POST['csrf'] ?? ''))) {
        http_response_code(403);
        exit('Token tidak valid. Kembali ke halaman utama lalu muat ulang.');
    }

    $aksi  = $_POST['aksi'] ?? '';
    $id    = (int) ($_POST['id'] ?? 0);
    $judul = trim($_POST['judul'] ?? '');
    $valid = $judul !== '' && mb_strlen($judul) <= 200;

    if ($aksi === 'tambah' && $valid) {
        $pdo->prepare('INSERT INTO tugas (judul, selesai) VALUES (?, 0)')
            ->execute([$judul]);
    } elseif ($aksi === 'edit' && $valid) {
        $pdo->prepare('UPDATE tugas SET judul = ? WHERE id = ?')
            ->execute([$judul, $id]);
    } elseif ($aksi === 'status') {
        $pdo->prepare('UPDATE tugas SET selesai = ? WHERE id = ?')
            ->execute([isset($_POST['selesai']) ? 1 : 0, $id]);
    } elseif ($aksi === 'hapus') {
        $pdo->prepare('DELETE FROM tugas WHERE id = ?')
            ->execute([$id]);
    }
}

// Kembali ke halaman utama (mencegah form terkirim ulang saat refresh)
header('Location: index.php');
exit;