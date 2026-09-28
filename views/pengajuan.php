<?php

$active = 'pengajuan';
$pageTitle = 'Ajukan Peminjaman';

require_once __DIR__ . '/header.php';

$status = $_GET['status'] ?? '';

?>

<?php if ($status === 'gagal'): ?>

<div class="alert alert-danger">
    Peminjaman gagal. Periksa stok dan data yang dimasukkan.
</div>

<?php endif; ?>


<div class="form-card">

    <h2>Ajukan Peminjaman</h2>

    <p style="margin-bottom:25px;">
        Isi data peminjaman alat olahraga.
    </p>


    <form
        method="POST"
        action="index.php?url=proses-pengajuan"
    >


        <div class="form-group">

            <label>Alat Olahraga</label>

            <select name="alat_id" required>

                <option value="">
                    -- Pilih Alat --
                </option>

                <?php foreach ($alat as $row): ?>

                    <?php if ($row['stok'] > 0): ?>

                    <option value="<?= $row['id'] ?>">

                        <?= htmlspecialchars($row['nama_alat']) ?>

                        - Stok:
                        <?= htmlspecialchars($row['stok']) ?>

                    </option>

                    <?php endif; ?>

                <?php endforeach; ?>

            </select>

        </div>


        <div class="form-group">

            <label>Jumlah</label>

            <input
                type="number"
                name="jumlah"
                min="1"
                required
            >

        </div>


        <div class="form-group">

            <label>Tanggal Pinjam</label>

            <input
                type="date"
                name="tanggal_pinjam"
                value="<?= date('Y-m-d') ?>"
                required
            >

        </div>


        <div class="form-group">

            <label>Rencana Tanggal Kembali</label>

            <input
                type="date"
                name="tanggal_rencana_kembali"
                required
            >

        </div>


        <div class="form-actions">

            <button type="submit" class="btn">
                Ajukan Peminjaman
            </button>

            <a
                href="index.php?url=dashboard"
                class="btn btn-secondary">
                Batal
            </a>

        </div>


    </form>

</div>


<?php require_once __DIR__ . '/footer.php'; ?>