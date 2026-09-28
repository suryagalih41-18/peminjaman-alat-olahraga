<?php

$active = 'peminjam';

$pageTitle = 'Data Peminjam';

require "header.php";

?>

<div class="welcome">

    <h2>
        👤 Data Peminjam
    </h2>

    <p>
        Daftar pengguna yang terdaftar sebagai peminjam.
    </p>

</div>


<div class="card">

    <h2>
        Daftar Peminjam
    </h2>


    <div style="overflow-x:auto;">

        <table>

            <thead>

                <tr>

                    <th>
                        No
                    </th>

                    <th>
                        Nama Lengkap
                    </th>

                    <th>
                        Username
                    </th>

                    <th>
                        Role
                    </th>

                </tr>

            </thead>


            <tbody>

                <?php if (!empty($peminjam)): ?>

                    <?php $no = 1; ?>

                    <?php foreach ($peminjam as $p): ?>

                        <tr>

                            <td>
                                <?= $no++; ?>
                            </td>

                            <td>
                                <?= htmlspecialchars(
                                    $p['nama_lengkap']
                                ); ?>
                            </td>

                            <td>
                                <?= htmlspecialchars(
                                    $p['username']
                                ); ?>
                            </td>

                            <td>

                                <span class="badge">
                                    Peminjam
                                </span>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>

                        <td
                            colspan="4"
                            style="
                                text-align:center;
                                padding:30px;
                            "
                        >
                            Belum ada data peminjam.
                        </td>

                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>


<style>

.badge {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 20px;
    background: #E9EEF5;
    color: #263B5A;
    font-size: 13px;
}

</style>


<?php

require "footer.php";

?>