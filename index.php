<?php
require 'data.php';

$tasks   = ambilTugas();
$total   = count($tasks);
$selesai = count(array_filter($tasks, fn($t) => !empty($t['selesai'])));
$persen  = $total ? round($selesai / $total * 100) : 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>To-Do List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
<div class="container py-5" style="max-width: 800px">

    <div class="hero text-white p-4 mb-4">
        <h2 class="fw-bold"><i class="bi bi-check2-square"></i> To-Do List</h2>
        <p class="opacity-75">Atur dan selesaikan tugasmu hari ini.</p>
        <div class="d-flex justify-content-between small mb-1">
            <span>Progres</span><span><?= $persen ?>%</span>
        </div>
        <div class="progress"><div class="progress-bar" style="width: <?= $persen ?>%"></div></div>
    </div>

    <div class="row g-3 mb-4 text-center">
        <?php foreach (['Total' => $total, 'Belum' => $total - $selesai, 'Selesai' => $selesai] as $label => $n): ?>
            <div class="col-4">
                <div class="card p-3">
                    <small class="text-secondary"><?= $label ?></small>
                    <h3 class="fw-bold text-primary mb-0"><?= $n ?></h3>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="card p-4 mb-4">
        <form method="POST" action="proses.php" class="input-group">
            <?= csrf() ?>
            <input type="hidden" name="aksi" value="tambah">
            <input name="judul" class="form-control" placeholder="Masukkan nama tugas..." maxlength="200" required>
            <button class="btn btn-grad"><i class="bi bi-plus-lg"></i> Tambah</button>
        </form>
    </div>

    <div class="card p-4">
        <h5 class="fw-bold mb-3">Daftar Tugas <span class="badge btn-grad"><?= $total ?></span></h5>

        <?php if (!$tasks): ?>
            <p class="text-center text-secondary mb-0">Belum ada tugas.</p>
        <?php endif; ?>

        <?php foreach ($tasks as $id => $t): ?>
            <div class="task d-flex align-items-center gap-3 border p-3 mb-2">
                <form method="POST" action="proses.php">
                    <?= csrf() ?>
                    <input type="hidden" name="aksi" value="status">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <input type="checkbox" name="selesai" class="form-check-input"
                           onchange="this.form.submit()" <?= !empty($t['selesai']) ? 'checked' : '' ?>>
                </form>

                <span class="flex-fill fw-semibold <?= !empty($t['selesai']) ? 'text-decoration-line-through text-secondary' : '' ?>">
                    <?= e($t['judul']) ?>
                </span>

                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#edit"
                        data-id="<?= $id ?>" data-judul="<?= e($t['judul']) ?>">
                    <i class="bi bi-pencil-square"></i>
                </button>

                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#hapus"
                        data-id="<?= $id ?>" data-judul="<?= e($t['judul']) ?>">
                    <i class="bi bi-trash3"></i>
                </button>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="modal fade" id="hapus" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <form method="POST" action="proses.php" class="modal-content border-0 rounded-4 text-center p-4">
            <?= csrf() ?>
            <input type="hidden" name="aksi" value="hapus">
            <input type="hidden" name="id" id="hapusId">
            <h5 class="fw-bold">Hapus Tugas?</h5>
            <p class="text-secondary small">"<span id="hapusJudul"></span>" akan dihapus permanen.</p>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-light flex-fill" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-danger flex-fill">Ya, Hapus</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="edit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="proses.php" class="modal-content border-0 rounded-4 p-4">
            <?= csrf() ?>
            <input type="hidden" name="aksi" value="edit">
            <input type="hidden" name="id" id="editId">
            <h5 class="fw-bold mb-3">Edit Tugas</h5>
            <input name="judul" id="editJudul" class="form-control mb-3" maxlength="200" required>
            <div class="d-flex gap-2 justify-content-end">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-grad">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('hapus').addEventListener('show.bs.modal', ev => {
        hapusId.value = ev.relatedTarget.dataset.id;
        hapusJudul.textContent = ev.relatedTarget.dataset.judul;
    });

    document.getElementById('edit').addEventListener('show.bs.modal', ev => {
        editId.value = ev.relatedTarget.dataset.id;
        editJudul.value = ev.relatedTarget.dataset.judul;
    });
</script>
</body>
</html>