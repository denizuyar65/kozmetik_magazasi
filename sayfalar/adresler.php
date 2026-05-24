<?php

session_start();

include "../config/baglan.php";

include "../includes/header.php";
include "../includes/menu.php";

// giriş kontrol

if(!isset($_SESSION["kullanici_id"])){

    header("Location: giris.php");

    exit;

}

$kullanici_id =
    $_SESSION["kullanici_id"];

// adresleri çek

$sorgu = $db->prepare("
    SELECT *
    FROM adresler
    WHERE kullanici_id = ?
");

$sorgu->execute([
    $kullanici_id
]);

$adresler =
    $sorgu->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="container mt-5 mb-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="fw-bold">

            Adreslerim

        </h2>

        <a
            href="adres_ekle.php"
            class="btn btn-dark"
        >

            Yeni Adres Ekle

        </a>

    </div>

    <?php if(count($adresler) > 0){ ?>

        <div class="row g-4">

            <?php foreach($adresler as $adres){ ?>

                <div class="col-md-6">

                    <div class="card shadow border-0 h-100">

                        <div class="card-body">

                            <h5 class="fw-bold">

                                <?= htmlspecialchars($adres["sehir"]) ?>

                                /

                                <?= htmlspecialchars($adres["ilce"]) ?>

                            </h5>

                            <p class="text-muted mb-0">

                                <?= htmlspecialchars($adres["acik_adres"]) ?>

                            </p>

                        </div>

                    </div>

                </div>

            <?php } ?>

        </div>

    <?php }else{ ?>

        <div class="alert alert-warning">

            Henüz kayıtlı adresiniz yok.

        </div>

    <?php } ?>

</div>

<?php include "../includes/footer.php"; ?>