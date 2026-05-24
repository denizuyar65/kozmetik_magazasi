<?php

include "../config/baglan.php";
include "../includes/header.php";
include "../includes/menu.php";

$arama = "";

$urunler = [];

if(isset($_GET["kelime"])){

    $arama = trim($_GET["kelime"]);

    $sorgu = $db->prepare("
        SELECT * FROM urunler
        WHERE urun_adi LIKE ?
        OR aciklama LIKE ?
    ");

    $sorgu->execute([
        "%$arama%",
        "%$arama%"
    ]);

    $urunler = $sorgu->fetchAll(PDO::FETCH_ASSOC);

}

?>

<div class="container mt-5">

    <h2 class="mb-4">

        Arama Sonuçları:
        "<?= htmlspecialchars($arama) ?>"

    </h2>

    <div class="row g-4">

        <?php if(count($urunler) > 0){ ?>

            <?php foreach($urunler as $urun){ ?>

                <div class="col-md-3">

                    <div class="card h-100 border-0 shadow-sm">

                        <img
                            src="../<?= $urun["resim_url"] ?>"
                            class="card-img-top"
                            style="
                                height:250px;
                                object-fit:cover;
                            "
                        >

                        <div class="card-body text-center">

    <!-- Ürün Adı -->

    <h5 class="fw-bold">

        <?= $urun["urun_adi"] ?>

    </h5>

    <!-- Fiyat -->

    <p class="text-dark fw-bold">

        ₺<?= $urun["fiyat"] ?>

    </p>

    <!-- Butonlar -->

    <div class="d-flex justify-content-center gap-2">

        <!-- Sepete Ekle -->

        <a
            href="../ajax/sepete_ekle.php?id=<?= $urun["urun_id"] ?>"
            class="btn btn-dark"
        >

            Sepete Ekle

        </a>

        <!-- Favori -->

        <a
            href="../ajax/favori_ekle.php?id=<?= $urun["urun_id"] ?>"
            class="btn btn-outline-danger"
        >

            <i class="bi bi-heart"></i>

        </a>

    </div>

</div>

                        <div class="card-footer bg-white border-0">

                            <a href="urun_detay.php?id=<?= $urun["urun_id"] ?>"
                               class="btn btn-dark w-100">

                                Ürünü İncele

                            </a>

                        </div>

                    </div>

                </div>

            <?php } ?>

        <?php }else{ ?>

            <div class="alert alert-danger">

                Ürün bulunamadı.

            </div>

        <?php } ?>

    </div>

</div>

<?php include "../includes/footer.php"; ?>