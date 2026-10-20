
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$active = 'alat';
$pageTitle = 'Tambah Alat';
$status = $_GET['status'] ?? '';

require __DIR__ . '/header.php';
?>

<div class="form-container">
    <h2>Tambah Alat Olahraga</h2>
    <p>Silakan isi data alat olahraga berikut.</p>

    <?php if ($status === 'duplikat'): ?>
        <div class="alert alert-warning">
            <strong>Nama alat sudah terdaftar!</strong>
            <p>Gunakan nama alat yang berbeda agar tidak terjadi duplikasi.</p>
        </div>
    <?php elseif ($status === 'gagal'): ?>
        <div class="alert alert-danger">
            <strong>Gagal menambahkan alat!</strong>
            <p>Periksa kembali data yang kamu masukkan.</p>
        </div>
    <?php endif; ?>

    <form action="index.php?url=proses-tambah-alat" method="POST">
        <div class="form-group">
            <label for="nama_alat">Nama Alat</label>
            <input type="text" id="nama_alat" name="nama_alat" required>
        </div>

        <div class="form-group">
            <label for="kategori_id">Kategori</label>
            <select id="kategori_id" name="kategori_id" required>
                <option value="">-- Pilih Kategori --</option>
                <?php foreach (($dataKategori ?? []) as $kategori): ?>
                    <option value="<?= (int) $kategori['id'] ?>">
                        <?= htmlspecialchars($kategori['nama_kategori'] ?? '') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="stok">Stok</label>
            <input type="number" id="stok" name="stok" min="0" required>
        </div>

        <div class="form-group">
            <label for="kondisi">Kondisi</label>
            <select id="kondisi" name="kondisi" required>
                <option value="">-- Pilih Kondisi --</option>
                <option value="Baik">Baik</option>
                <option value="Rusak Ringan">Rusak Ringan</option>
                <option value="Rusak Berat">Rusak Berat</option>
            </select>
        </div>

        <button type="submit">Simpan Alat</button>
        <a href="index.php?url=alat">Batal</a>
    </form>
</div>

<style>
.form-container {
    max-width: 650px;
    margin: 20px auto;
    padding: 25px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,.08);
}
.form-group {
    margin-bottom: 18px;
}
.form-group label {
    display: block;
    margin-bottom: 7px;
    font-weight: 600;
}
.form-group input,
.form-group select {
    box-sizing: border-box;
    width: 100%;
    padding: 11px;
    border: 1px solid #ccc;
    border-radius: 6px;
}
.form-container button {
    padding: 10px 18px;
    border: none;
    border-radius: 6px;
    background: #263B5A;
    color: #fff;
    cursor: pointer;
}
.form-container a {
    margin-left: 10px;
    color: #263B5A;
    text-decoration: none;
}
.alert {
    padding: 14px;
    margin: 15px 0;
    border-radius: 6px;
}
.alert p {
    margin-bottom: 0;
}
.alert-warning {
    background: #fff3cd;
    color: #856404;
    border: 1px solid #ffe69c;
}
.alert-danger {
    background: #f8d7da;
    color: #842029;
    border: 1px solid #f5c2c7;
}
</style>

<?php require __DIR__ . '/footer.php'; ?>
