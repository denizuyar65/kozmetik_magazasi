<?php

session_start();

include "../config/baglan.php";

include "../includes/header.php";

include "../includes/menu.php";

// Kullanıcı kontrolü

if (!isset($_SESSION["kullanici_id"])) {

    die("Lütfen giriş yapın.");
}

$kullanici_id =
    $_SESSION["kullanici_id"];

// Sepet ürünleri
$sorgu = $db->prepare("
    SELECT
        s.*,
        u.urun_adi,
        u.fiyat,
        u.resim_url,
        u.stok

    FROM sepet_detaylari s

    LEFT JOIN urunler u
    ON s.urun_id = u.urun_id

    LEFT JOIN sepet sp
    ON s.sepet_id = sp.sepet_id

    WHERE sp.kullanici_id = ?
");

$sorgu->execute([$kullanici_id]);

$urunler = $sorgu->fetchAll(PDO::FETCH_ASSOC);

// Toplam tutar

$toplam = 0;

foreach ($urunler as $urun) {

    $toplam +=
        $urun["fiyat"]
        *
        $urun["adet"];
}

?>

<section class="container my-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="fw-bold">

            Sepetim

        </h2>

    </div>

    <?php if (count($urunler) > 0) { ?>

        <div class="row g-4">

            <!-- Ürünler -->

            <div class="col-md-8">

                <?php foreach ($urunler as $urun) { ?>

                    <div class="card border-0 shadow-sm mb-4">

                        <div class="row g-0 align-items-center">

                            <!-- Resim -->

                            <div class="col-md-3">

                                <img
                                    src="../<?= $urun["resim_url"] ?>"
                                    class="img-fluid rounded-start"
                                    style="
                                        height:200px;
                                        width:100%;
                                        object-fit:cover;
                                    ">

                            </div>

                            <!-- Bilgiler -->

                            <div class="col-md-6">

                                <div class="card-body">

                                    <h5 class="fw-bold">

                                        <?= htmlspecialchars($urun["urun_adi"]) ?>

                                    </h5>

                                    <p class="text-muted">

                                        Adet:
                                        <?= $urun["adet"] ?>

                                    </p>

                                    <h4 class="fw-bold">

                                        ₺<?= $urun["fiyat"] ?>

                                    </h4>

                                </div>

                            </div>

                            <!-- İşlem -->

                            <div class="col-md-3 text-center">

                                <a
                                    href="/kozmetik_magazasi/ajax/sepet_sil.php?id=<?= $urun["sepet_detay_id"] ?>"
                                    class="btn btn-danger">

                                    Sil

                                </a>
                            </div>

                        </div>

                    </div>

                <?php } ?>

            </div>

            <!-- Sipariş Özeti -->

            <div class="col-md-4">

                <div class="card border-0 shadow-sm">

                    <div class="card-body">

                        <h4 class="fw-bold mb-4">

                            Sipariş Özeti

                        </h4>

                        <div
                            class="d-flex justify-content-between mb-3">

                            <span>

                                Toplam

                            </span>

                            <strong>

                                ₺<?= $toplam ?>

                            </strong>

                        </div>

                        <hr>

                        <a
                            href="odeme.php"
                            class="btn btn-dark w-100">

                            Ödemeye Geç

                        </a>

                    </div>

                </div>

            </div>

        </div>

    <?php } else { ?>

        <div class="alert alert-warning">

            Sepetiniz boş.

        </div>

    <?php } ?>

</section>

<?php include "../includes/footer.php"; ?>