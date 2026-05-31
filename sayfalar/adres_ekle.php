<?php

include "../config/baglan.php";
include "../includes/session.php";
include "../includes/header.php";
include "../includes/menu.php";

if (!isset($_SESSION["kullanici_id"])) {

    header("Location: giris.php");
    exit;
}

$mesaj = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $kullanici_id = $_SESSION["kullanici_id"];

    $sehir = trim($_POST["sehir"]);
    $ilce = trim($_POST["ilce"]);
    $acik_adres = trim($_POST["acik_adres"]);

    if (
        empty($sehir) ||
        empty($ilce) ||
        empty($acik_adres)
    ) {

        $mesaj = "
            <div class='alert alert-danger'>
                Tüm alanları doldurun.
            </div>
        ";
    } else {

        $ekle = $db->prepare("
            INSERT INTO adresler
            (kullanici_id, sehir, ilce, acik_adres)
            VALUES (?, ?, ?, ?)
        ");

        $ekle->execute([
            $kullanici_id,
            $sehir,
            $ilce,
            $acik_adres
        ]);

        $mesaj = "
            <div class='alert alert-success'>
                Adres başarıyla eklendi.
            </div>
        ";
    }
}

?>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow border-0">

                <div class="card-body p-4">

                    <h2 class="mb-4 text-center">
                        Yeni Adres Ekle
                    </h2>

                    <?= $mesaj ?>

                    <form method="POST">

                        <input
                            type="text"
                            name="sehir"
                            class="form-control mb-3"
                            placeholder="Şehir">

                        <input
                            type="text"
                            name="ilce"
                            class="form-control mb-3"
                            placeholder="İlçe">

                        <textarea
                            name="acik_adres"
                            class="form-control mb-3"
                            rows="4"
                            placeholder="Açık Adres"></textarea>

                        <button
                            class="btn btn-dark w-100">

                            Adresi Kaydet

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include "../includes/footer.php"; ?>