<?php
session_start();

include "includes/admin_kontrol.php";
include "../config/baglan.php";
include "includes/header.php";
include "includes/sidebar.php";

$yorumlar = $db->query("
SELECT
y.yorum_id,
y.yorum,
y.puan,
y.tarih,

k.ad,
k.soyad,

u.urun_adi

FROM yorumlar y

INNER JOIN kullanicilar k
ON y.kullanici_id=k.kullanici_id

INNER JOIN urunler u
ON y.urun_id=u.urun_id

ORDER BY y.yorum_id DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="admin-content">

    <h2 class="fw-bold mb-4">
        Ürün Yorumları
    </h2>


    <div class="card shadow border-0 rounded-4">

        <div class="card-body">

            <table class="table align-middle">

                <thead>

                    <tr>
                        <th>#</th>
                        <th>Kullanıcı</th>
                        <th>Ürün</th>
                        <th>Puan</th>
                        <th>Yorum</th>
                        <th>Tarih</th>
                        <th>İşlem</th>
                    </tr>

                </thead>

                <tbody>

                    <?php foreach ($yorumlar as $yorum) { ?>

                        <tr>

                            <td>
                                <?= $yorum["yorum_id"] ?>
                            </td>

                            <td>
                                <?= $yorum["ad"] ?>
                                <?= $yorum["soyad"] ?>
                            </td>

                            <td>
                                <?= $yorum["urun_adi"] ?>
                            </td>

                            <td>

                                <?php
                                for ($i = 1; $i <= $yorum["puan"]; $i++) {
                                    echo "⭐";
                                }
                                ?>

                            </td>

                            <td width="400">
                                <?= htmlspecialchars($yorum["yorum"]) ?>
                            </td>

                            <td>
                                <?= date("d.m.Y H:i", strtotime($yorum["tarih"])) ?>
                            </td>

                            <td>

                                <a href="yorum_sil.php?id=<?= $yorum["yorum_id"] ?>"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('Yorumu silmek istiyor musunuz?')">

                                    Sil

                                </a>

                            </td>

                        </tr>

                    <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>