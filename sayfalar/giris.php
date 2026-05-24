<?php

session_start();

include "../config/baglan.php";
include "../includes/header.php";

$mesaj = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $email = trim($_POST["email"]);
    $sifre = trim($_POST["sifre"]);

    $sorgu = $db->prepare("
        SELECT *
        FROM kullanicilar
        WHERE email = ?
    ");

    $sorgu->execute([$email]);

    $kullanici = $sorgu->fetch(PDO::FETCH_ASSOC);

    if($kullanici){

        if(password_verify($sifre, $kullanici["sifre"])){

            $_SESSION["kullanici_id"] =
                $kullanici["kullanici_id"];

            $_SESSION["ad"] =
                $kullanici["ad"];

            $_SESSION["rol"] =
                $kullanici["rol"];

            header("Location: ../index.php");
            exit;

        }else{

            $mesaj = "Şifre yanlış.";

        }

    }else{

        $mesaj = "Kullanıcı bulunamadı.";

    }

}

?>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <div class="card shadow border-0">

                <div class="card-body p-5">

                    <h2 class="text-center mb-4">
                        Giriş Yap
                    </h2>

                    <?php if($mesaj != ""){ ?>

                        <div class="alert alert-danger">
                            <?= $mesaj ?>
                        </div>

                    <?php } ?>

                    <div
                        class="card border-0 shadow-lg mb-4"
                        style="
                            background:linear-gradient(135deg,#ff6b6b,#ffb347);
                            color:white;
                            border-radius:20px;
                        "
                    >

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
                            type="email"
                            name="email"
                            class="form-control mb-3"
                            placeholder="Email"
                            required
                        >

                        <input
                            type="password"
                            name="sifre"
                            class="form-control mb-3"
                            placeholder="Şifre"
                            required
                        >

                        <button class="btn btn-dark w-100">
                            Giriş Yap
                        </button>

                    </form>

                    <div class="text-center mt-3">

                        <a href="kayit.php">
                            Hesap oluştur
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include "../includes/footer.php"; ?>