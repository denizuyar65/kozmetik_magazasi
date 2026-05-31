<?php

session_start();

include "../config/baglan.php";
include "../includes/header.php";
include "../includes/menu.php";

// Alt kategori kontrolü

if (!isset($_GET["alt_kategori_id"])) {

    die("Kategori bulunamadı.");
}

$alt_kategori_id =
    intval($_GET["alt_kategori_id"]);

// Ürünleri çek

$sorgu = $db->prepare("
    SELECT *
    FROM urunler
    WHERE alt_kategori_id = ?
");

$sorgu->execute([
    $alt_kategori_id
]);

$urunler =
    $sorgu->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="container mt-5">

    <div class="row g-4">

        <?php if (count($urunler) > 0) { ?>

            <?php foreach ($urunler as $urun) { ?>

                <div class="col-md-3">

                    <div class="card border-0 shadow-sm h-100">

                        <!-- Ürün Resmi -->

                        <a
                            href="urun_detay.php?id=<?= $urun["urun_id"] ?>">

                            <img
                                src="../<?= $urun["resim_url"] ?>"
                                class="card-img-top"
                                style="
                                    height:250px;
                                    object-fit:cover;
                                ">

                        </a>

                        <!-- İçerik -->

                        <div class="card-body">

                            <h5 class="card-title">

                                <a
                                    href="urun_detay.php?id=<?= $urun["urun_id"] ?>"
                                    class="text-dark text-decoration-none">

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
                                    class="btn btn-dark">

                                    Sepete Ekle

                                </a>

                                <!-- Favori -->

                                <?php

                                $favoriKontrol = false;

                                if (isset($_SESSION["kullanici_id"])) {

                                    $favSorgu = $db->prepare("
                                        SELECT *
                                        FROM favoriler
                                        WHERE kullanici_id = ?
                                        AND urun_id = ?
                                    ");

                                    $favSorgu->execute([
                                        $_SESSION["kullanici_id"],
                                        $urun["urun_id"]
                                    ]);

                                    if ($favSorgu->rowCount() > 0) {

                                        $favoriKontrol = true;
                                    }
                                }

                                ?>

                                <?php if ($favoriKontrol) { ?>

                                    <a
                                        href="../ajax/favori_sil.php?urun_id=<?= $urun["urun_id"] ?>"
                                        class="btn btn-danger">

                                        <i class="bi bi-heart-fill"></i>

                                        Favoriden Kaldır

                                    </a>

                                <?php } else { ?>

                                    <a
                                        href="../ajax/favori_ekle.php?urun_id=<?= $urun["urun_id"] ?>"
                                        class="btn btn-outline-danger">

                                        <i class="bi bi-heart"></i>

                                        Favorilere Ekle

                                    </a>

                                <?php } ?>

                            </div>

                        </div>

                    </div>

                </div>

            <?php } ?>

        <?php } else { ?>

            <div class="alert alert-warning">

                Bu kategoride ürün bulunamadı.

            </div>

        <?php } ?>

    </div>

</div>

<?php include "../includes/footer.php"; ?>