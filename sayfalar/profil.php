<?php
include "../config/baglan.php";
include "../includes/header.php";
include "../includes/menu.php";


if (!isset($_SESSION["kullanici_id"])) {

    header("Location: giris.php");
    exit;
}
$kullanici_id = $_SESSION["kullanici_id"];

/* Son 5 sipariş */
$sorgu = $db->prepare("
SELECT
    s.*,
    sd.adet,
    sd.birim_fiyat,
    u.urun_adi,
    u.resim_url

FROM siparisler s

LEFT JOIN siparis_detaylari sd
ON s.siparis_id = sd.siparis_id

LEFT JOIN urunler u
ON sd.urun_id = u.urun_id

WHERE s.kullanici_id = ?

ORDER BY s.siparis_id DESC

LIMIT 5
");

$sorgu->execute([$kullanici_id]);

$sonSiparisler =
    $sorgu->fetchAll(PDO::FETCH_ASSOC);

/* Son adres */

$adresSorgu = $db->prepare("
    SELECT *
    FROM adresler
    WHERE kullanici_id = ?
    ORDER BY adres_id DESC
    LIMIT 1
");

$adresSorgu->execute([$kullanici_id]);

$adres =
    $adresSorgu->fetch(PDO::FETCH_ASSOC);


?>

<div class="container mt-5">

    <div class="card shadow border-0 mb-4">

        <div class="card-body p-5">

            <h2 class="fw-bold">

                👋 Merhaba
                <?= $_SESSION["ad"] ?>

            </h2>

            <p class="text-muted mb-0">

                Siparişlerini ve adres bilgilerini buradan takip edebilirsin.

            </p>

        </div>

    </div>

    <div class="row g-4">

        <!-- Siparişler -->

        <div class="col-lg-8">

            <div class="card shadow border-0">

                <div class="card-body">

                    <h4 class="fw-bold mb-4">

                        📦 Son Siparişlerin

                    </h4>

                    <?php if (count($sonSiparisler) > 0) { ?>

                        <?php foreach ($sonSiparisler as $siparis) { ?>
                            <div class="card mb-3 border-0 shadow-sm">

                                <div class="card-body">

                                    <div class="row align-items-center">

                                        <div class="col-md-2">

                                            <img
                                                src="../<?= $siparis["resim_url"] ?>"
                                                class="img-fluid rounded"
                                                style="
                        width:90px;
                        height:90px;
                        object-fit:cover;
                    ">

                                        </div>

                                        <div class="col-md-5">

                                            <h6 class="fw-bold mb-2">

                                                <?= htmlspecialchars($siparis["urun_adi"]) ?>

                                            </h6>

                                            <small class="text-muted">

                                                <?= date(
                                                    "d.m.Y",
                                                    strtotime(
                                                        $siparis["olusturma_tarihi"]
                                                    )
                                                ) ?>

                                            </small>

                                            <br>

                                            <small>

                                                Adet:
                                                <?= $siparis["adet"] ?>

                                            </small>

                                        </div>

                                        <div class="col-md-2 text-center">

                                            <strong>

                                                ₺<?= number_format(
                                                        $siparis["birim_fiyat"] * $siparis["adet"],
                                                        2,
                                                        ",",
                                                        "."
                                                    ) ?>

                                            </strong>

                                        </div>

                                        <div class="col-md-3 text-end">

                                            <?php

                                            if (
                                                $siparis["siparis_durumu"]
                                                == "teslim edildi"
                                            ) {

                                                echo '
                    <span class="badge bg-success">
                        Teslim Edildi
                    </span>';
                                            } elseif (
                                                $siparis["siparis_durumu"]
                                                == "kargoya verildi"
                                            ) {

                                                echo '
                    <span class="badge bg-primary">
                        Kargoda
                    </span>';
                                            } else {

                                                echo '
                    <span class="badge bg-warning text-dark">
                        Hazırlanıyor
                    </span>';
                                            }

                                            ?>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        <?php } ?>

                    <?php } else { ?>

                        <div class="alert alert-info">

                            Henüz sipariş bulunmuyor.

                        </div>

                    <?php } ?>

                </div>

            </div>

        </div>

        <!-- Adres -->

        <div class="col-lg-4">

            <div class="card shadow border-0">

                <div class="card-body">

                    <h4 class="fw-bold mb-4">

                        📍 Kayıtlı Adres

                    </h4>

                    <?php if ($adres) { ?>

                        <div class="mb-2">

                            <strong>

                                <?= htmlspecialchars($adres["sehir"]) ?>

                                /

                                <?= htmlspecialchars($adres["ilce"]) ?>

                            </strong>

                        </div>

                        <div class="text-muted">

                            <?= nl2br(
                                htmlspecialchars(
                                    $adres["acik_adres"]
                                )
                            ) ?>

                        </div>

                    <?php } else { ?>

                        <div class="alert alert-warning">

                            Henüz adres eklenmemiş.

                        </div>

                    <?php } ?>

                    <a
                        href="adreslerim.php"
                        class="btn btn-outline-dark mt-3">

                        Adresleri Yönet

                    </a>

                </div>

            </div>

            <div class="mt-3">

                <a
                    href="cikis.php"
                    class="btn btn-danger w-100">

                    🚪 Çıkış Yap

                </a>

            </div>

        </div>

    </div>

</div>

<?php include "../includes/footer.php"; ?>