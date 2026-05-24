<?php

session_start();
include "includes/admin_kontrol.php";
include "../config/baglan.php";

include "includes/header.php";
include "includes/sidebar.php";

$mesajlar = $db->query("
    SELECT *
    FROM iletisim_mesajlari
    ORDER BY mesaj_id DESC
")->fetchAll(PDO::FETCH_ASSOC);

?>
<div class="admin-content">
<h1 class="page-title">

    Gelen Mesajlar

</h1>
<div class="card shadow-sm">

    <div class="card-body">

        <table class="table table-hover align-middle">

            <thead>

                <tr>
                    
                    <th>ID</th>
                    <th>Ad Soyad</th>
                    <th>E-Posta</th>
                    <th>Mesaj</th>
                    <th>Tarih</th>
                    <th>İşlem</th>
                </tr>

            </thead>

            <tbody>

                <?php foreach($mesajlar as $mesaj){ ?>

                <tr>

                    <td><?= $mesaj["mesaj_id"] ?></td>

                    <td><?= htmlspecialchars($mesaj["ad_soyad"]) ?></td>

                    <td><?= htmlspecialchars($mesaj["email"]) ?></td>

                    <td style="max-width:300px;">

                        <?= htmlspecialchars($mesaj["mesaj"]) ?>

                    </td>

                    <td><?= $mesaj["tarih"] ?></td>
                    <td>

                     <a
                        href="mesaj_detay.php?id=<?= $mesaj["mesaj_id"] ?>"
                      class="btn btn-sm btn-primary"
                     >

                    Detay

                    </a>
                    <a
        href="mesaj_sil.php?id=<?= $mesaj["mesaj_id"] ?>"
        class="btn btn-sm btn-danger"
        onclick="return confirm('Mesaj silinsin mi?')"
    >

        Sil

    </a>

</td>

                </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>

</div>
<?php include "includes/footer.php"; ?>