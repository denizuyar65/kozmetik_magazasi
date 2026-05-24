<?php

session_start();

include "../config/baglan.php";
include "../includes/header.php";

if(!isset($_SESSION["kullanici_id"])){

    header("Location: giris.php");
    exit;
}

$kullanici_id = $_SESSION["kullanici_id"];

$sorgu = $db->prepare("
    SELECT *
    FROM adresler
    WHERE kullanici_id = ?
    ORDER BY adres_id DESC
");

$sorgu->execute([$kullanici_id]);

$adresler = $sorgu->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="fw-bold">
            📍 Adreslerim
        </h2>

        <a
            href="adres_ekle.php"
            class="btn btn-dark"
        >

            + Yeni Adres

        </a>

    </div>

    <div class="row g-4">

        <?php foreach($adresler as $adres){ ?>

        <div class="col-md-6">

            <div class="card shadow border-0 h-100">

                <div class="card-body">

                    <h5 class="fw-bold mb-3">

                        <?= htmlspecialchars(
                            $adres["il"]
                        ) ?>

                        /

                        <?= htmlspecialchars(
                            $adres["ilce"]
                        ) ?>

                    </h5>

                    <p class="text-muted">

                        <?= htmlspecialchars(
                            $adres["adres_detay"]
                        ) ?>

                    </p>

                    <div class="mt-3">

                        <a
                            href="adres_duzenle.php?id=<?= $adres["adres_id"] ?>"
                            class="btn btn-primary btn-sm"
                        >

                            Düzenle

                        </a>

                        <a
                            href="adres_sil.php?id=<?= $adres["adres_id"] ?>"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Adres silinsin mi?')"
                        >

                            Sil

                        </a>

                    </div>

                </div>

            </div>

        </div>

        <?php } ?>

    </div>

</div>

<?php include "../includes/footer.php"; ?>