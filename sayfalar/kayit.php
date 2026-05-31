<?php
session_start();
include "../config/baglan.php";
include "../includes/header.php";


$mesaj = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $ad = trim($_POST["ad"]);
    $soyad = trim($_POST["soyad"]);
    $email = trim($_POST["email"]);
    $telefon = trim($_POST["telefon"]);
    $sifre = trim($_POST["sifre"]);

    // Boş kontrolü
    if (
        empty($ad) ||
        empty($soyad) ||
        empty($email) ||
        empty($sifre)
    ) {

        $mesaj = "Lütfen tüm alanları doldurun.";
    } else {

        // Email kontrolü
        $kontrol = $db->prepare(
            "SELECT * FROM kullanicilar WHERE email = ?"
        );

        $kontrol->execute([$email]);

        if ($kontrol->rowCount() > 0) {

            $mesaj = "Bu email zaten kayıtlı.";
        } else {

            // Şifre hashleme
            $hashliSifre = password_hash(
                $sifre,
                PASSWORD_DEFAULT
            );

            $ekle = $db->prepare("
                INSERT INTO kullanicilar
                (
                    ad,
                    soyad,
                    email,
                    telefon,
                    sifre
                )
                VALUES
                (?, ?, ?, ?, ?)
            ");

            $ekle->execute([
                $ad,
                $soyad,
                $email,
                $telefon,
                $hashliSifre
            ]);
            $mesaj = "Kayıt başarılı.";
            $kullanici_id = $db->lastInsertId();

            $_SESSION["kullanici_id"] = $kullanici_id;
            $_SESSION["ad"] = $ad;
            $_SESSION["soyad"] = $soyad;

            header("Location: ../index.php");
            exit;
        }
    }
}

?>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow border-0">

                <div class="card-body p-5">

                    <h2 class="text-center mb-4">
                        Kayıt Ol
                    </h2>

                    <?php if ($mesaj != "") { ?>

                        <div class="alert alert-info">
                            <?= $mesaj ?>
                        </div>

                    <?php } ?>
                    <div
                        class="card border-0 shadow-lg mb-4"
                        style="
        background:linear-gradient(135deg,#ff6b6b,#ffb347);
        color:white;
        border-radius:20px;
    ">

                        <div class="card-body text-center p-4">

                            <h2 class="fw-bold">
                                🎁 HOŞ GELDİN İNDİRİMİ
                            </h2>

                            <h4>
                                Üyelere Özel %30 İndirim
                            </h4>

                            <p class="mb-0">
                                Şimdi kayıt ol, ilk siparişinde avantajlı alışveriş yap.
                            </p>

                        </div>

                    </div>
                    <form method="POST">

                        <input
                            type="text"
                            name="ad"
                            class="form-control mb-3"
                            placeholder="Ad">

                        <input
                            type="text"
                            name="soyad"
                            class="form-control mb-3"
                            placeholder="Soyad">

                        <input
                            type="email"
                            name="email"
                            class="form-control mb-3"
                            placeholder="Email">

                        <input
                            type="text"
                            name="telefon"
                            class="form-control mb-3"
                            placeholder="Telefon">

                        <input
                            type="password"
                            name="sifre"
                            class="form-control mb-3"
                            placeholder="Şifre">

                        <button class="btn btn-dark w-100">
                            Kayıt Ol
                        </button>

                    </form>

                    <div class="text-center mt-3">

                        <a href="giris.php">
                            Zaten hesabın var mı?
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include "../includes/footer.php"; ?>