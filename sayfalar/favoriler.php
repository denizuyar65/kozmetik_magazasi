<?php

session_start();

include "../config/baglan.php";

include "../includes/header.php";

include "../includes/menu.php";

// Giriş kontrol

if(!isset($_SESSION["kullanici_id"])){

    die("Lütfen giriş yapın.");

}

$kullanici_id =
    $_SESSION["kullanici_id"];

// Favorileri çek
$sorgu = $db->prepare("
    SELECT
        u.*

    FROM favoriler f

    INNER JOIN urunler u
    ON f.urun_id = u.urun_id

    WHERE f.kullanici_id = ?
");

$sorgu->execute([$kullanici_id]);

$urunler = $sorgu->fetchAll(PDO::FETCH_ASSOC);

?>

<section class="container my-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="fw-bold">

            Favorilerim

        </h2>

    </div>

    <?php if(count($urunler) > 0){ ?>

        <div class="row g-4">

            <?php foreach($urunler as $urun){ ?>

                <div class="col-md-3">

                    <div class="card border-0 shadow-sm h-100">

                        <!-- Resim -->

                        <a
                            href="urun_detay.php?id=<?= $urun["urun_id"] ?>"
                        >

                            <img
                                src="../<?= $urun["resim_url"] ?>"
                                class="card-img-top"
                                style="
                                    height:250px;
                                    object-fit:cover;
                                "
                            >

                        </a>

                        <!-- İçerik -->

                        <div class="card-body">

                            <h5 class="card-title">

                                <a
                                    href="urun_detay.php?id=<?= $urun["urun_id"] ?>"
                                    class="text-dark text-decoration-none"
                                >

                                    <?= htmlspecialchars($urun["urun_adi"]) ?>

                                </a>

                            </h5>

                            <p class="text-muted small">

                                <?= htmlspecialchars($urun["aciklama"]) ?>

                            </p>

                            <h4 class="fw-bold">

                                ₺<?= $urun["fiyat"] ?>

                            </h4>

                        </div>

                        <!-- Butonlar -->

                        <div class="card-footer bg-white border-0">

                            <div class="d-grid gap-2">

                                <!-- Sepete Ekle -->

                                <a
                                    href="../ajax/sepete_ekle.php?urun_id=<?= $urun["urun_id"] ?>"
                                    class="btn btn-dark"
                                >

                                    Sepete Ekle

                                </a>

                                <!-- Favoriden Çıkar -->

                                <a
                                    href="../ajax/favori_sil.php?urun_id=<?= $urun["urun_id"] ?>"
                                    class="btn btn-danger"
                                >

                                    <i class="bi bi-heart-fill"></i>

                                    Favoriden Kaldır

                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            <?php } ?>

        </div>

    <?php }else{ ?>

        <div class="alert alert-warning">

            Henüz favori ürününüz yok.

        </div>

    <?php } ?>

</section>

<?php include "../includes/footer.php"; ?>