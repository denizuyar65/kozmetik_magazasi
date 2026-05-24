<?php

session_start();

include "../config/baglan.php";

$hata = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $email =
        trim($_POST["email"]);

    $sifre =
        trim($_POST["sifre"]);

    $sorgu = $db->prepare("
        SELECT *
        FROM kullanicilar
        WHERE email = ?
    ");

    $sorgu->execute([$email]);

    $kullanici =
        $sorgu->fetch(PDO::FETCH_ASSOC);

    if(
        $kullanici
        &&
        password_verify(
            $sifre,
            $kullanici["sifre"]
        )
    ){

        if(
            $kullanici["rol"]
            ==
            "admin"
        ){

           $_SESSION["admin_id"] =
    $kullanici["kullanici_id"];

$_SESSION["admin_ad"] =
    $kullanici["ad"];

$_SESSION["admin_rol"] =
    $kullanici["rol"];

header("Location: dashboard.php");
exit;

        }else{

            $hata =
                'Bu hesap admin değil.';

        }

    }else{

        $hata =
            'Email veya şifre yanlış.';

    }

}

?>

<!DOCTYPE html>
<html lang="tr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        Admin Giriş
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body class="bg-light">

<div class="container">

    <div class="row vh-100 justify-content-center align-items-center">

        <div class="col-md-4">

            <div class="card shadow border-0">

                <div class="card-body p-4">

                    <h3 class="fw-bold text-center mb-4">

                        Admin Giriş

                    </h3>

                    <?php if($hata != ""){ ?>

                        <div class="alert alert-danger">

                            <?= $hata ?>

                        </div>

                    <?php } ?>

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
                            class="form-control mb-4"
                            placeholder="Şifre"
                            required
                        >

                        <button
                            class="btn btn-dark w-100"
                        >

                            Giriş Yap

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>