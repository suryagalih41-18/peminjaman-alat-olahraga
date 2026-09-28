<?php

$active = 'alat';
$pageTitle = 'Edit Alat';

require_once __DIR__ . '/header.php';

?>

<div class="form-card">

    <h2>Edit Alat</h2>

    <p style="margin-bottom:25px;">
        Ubah data alat olahraga.
    </p>


    <form
        method="POST"
        action="index.php?url=proses-edit-alat"
    >

        <input
            type="hidden"
            name="id"
            value="<?= htmlspecialchars($alat['id']) ?>"
        >


        <div class="form-group">

            <label>Nama Alat</label>

            <input
                type="text"
                name="nama_alat"
                value="<?= htmlspecialchars($alat['nama_alat']) ?>"
                required
            >

        </div>


        <div class="form-group">

            <label>Kategori</label>

            <select name="kategori_id" required>

                <?php foreach ($kategori as $k): ?>

                <option
                    value="<?= $k['id'] ?>"
                    <?= $alat['kategori_id'] == $k['id'] ? 'selected' : '' ?>
                >
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
                value="<?= htmlspecialchars($alat['stok']) ?>"
                required
            >

        </div>


        <div class="form-group">

            <label>Kondisi</label>

            <select name="kondisi" required>

                <option
                    value="Baik"
                    <?= $alat['kondisi'] === 'Baik' ? 'selected' : '' ?>>
                    Baik
                </option>

                <option
                    value="Rusak Ringan"
                    <?= $alat['kondisi'] === 'Rusak Ringan' ? 'selected' : '' ?>>
                    Rusak Ringan
                </option>

                <option
                    value="Rusak Berat"
                    <?= $alat['kondisi'] === 'Rusak Berat' ? 'selected' : '' ?>>
                    Rusak Berat
                </option>

            </select>

        </div>


        <div class="form-actions">

            <button type="submit" class="btn">
                Simpan Perubahan
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