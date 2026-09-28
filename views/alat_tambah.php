<?php

$active = 'alat';
$pageTitle = 'Tambah Alat';

require_once __DIR__ . '/header.php';

?>

<div class="form-card">

    <h2>Tambah Alat</h2>

    <p style="margin-bottom:25px;">
        Tambahkan alat olahraga baru.
    </p>


    <form
        method="POST"
        action="index.php?url=proses-tambah-alat"
    >

        <div class="form-group">

            <label>Nama Alat</label>

            <input
                type="text"
                name="nama_alat"
                placeholder="Masukkan nama alat"
                required
            >

        </div>


        <div class="form-group">

            <label>Kategori</label>

            <select name="kategori_id" required>

                <option value="">
                    -- Pilih Kategori --
                </option>

                <?php foreach ($kategori as $k): ?>

                <option value="<?= $k['id'] ?>">
                    <?= htmlspecialchars($k['nama_kategori']) ?>
                </option>

                <?php endforeach; ?>

            </select>

        </div>


        <div class="form-group">

            <label>Stok</label>

            <input
                type="number"
                name="stok"
                min="0"
                required
            >

        </div>


        <div class="form-group">

            <label>Kondisi</label>

            <select name="kondisi" required>

                <option value="">
                    -- Pilih Kondisi --
                </option>

                <option value="Baik">
                    Baik
                </option>

                <option value="Rusak Ringan">
                    Rusak Ringan
                </option>

                <option value="Rusak Berat">
                    Rusak Berat
                </option>

            </select>

        </div>


        <div class="form-actions">

            <button type="submit" class="btn">
                Simpan
            </button>

            <a
                href="index.php?url=alat"
                class="btn btn-secondary">
                Batal
            </a>

        </div>

    </form>

</div>


<?php require_once __DIR__ . '/footer.php'; ?>