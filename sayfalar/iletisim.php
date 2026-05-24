<?php

include "../config/baglan.php";

$mesajSonuc = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $ad_soyad = trim($_POST["ad_soyad"]);
    $email    = trim($_POST["email"]);
    $mesaj    = trim($_POST["mesaj"]);

    if(
        !empty($ad_soyad) &&
        !empty($email) &&
        !empty($mesaj)
    ){

        $ekle = $db->prepare("
            INSERT INTO iletisim_mesajlari
            (
                ad_soyad,
                email,
                mesaj
            )
            VALUES
            (?, ?, ?)
        ");

        $ekle->execute([
            $ad_soyad,
            $email,
            $mesaj
        ]);

        $mesajSonuc = "
            <div class='alert alert-success'>
                Mesajınız başarıyla gönderildi.
            </div>
        ";

    }else{

        $mesajSonuc = "
            <div class='alert alert-danger'>
                Lütfen tüm alanları doldurun.
            </div>
        ";

    }

}

include "../includes/header.php";
include "../includes/menu.php";

?>

<div class="container mt-5 mb-5">

    <div class="card shadow border-0">

        <div class="card-body p-5">

            <h1 class="fw-bold mb-4">

                İletişim

            </h1>

            <p class="mb-4">

                Sorularınız ve önerileriniz için bizimle
                iletişime geçebilirsiniz.

            </p>

            <div class="row">

                <div class="col-md-6">

                    <h5 class="fw-bold">

                        İletişim Bilgileri

                    </h5>

                    <p>

                        📧 veloura@gmail.com

                    </p>

                    <p>

                        📞 +90 555 555 55 55

                    </p>

                    <p>

                        📍 Van / Türkiye

                    </p>

                </div>

                <div class="col-md-6">
                    <?= $mesajSonuc ?>
                      <form method="POST">

                        <div class="mb-3">

                            <input
    type="text"
    name="ad_soyad"
    class="form-control"
    placeholder="Adınız Soyadınız"
>

                        </div>

                        <div class="mb-3">

                            <input
    type="email"
    name="email"
    class="form-control"
    placeholder="E-posta"
>
                        </div>

                        <div class="mb-3">

                            <textarea
    name="mesaj"
    class="form-control"
    rows="5"
    placeholder="Mesajınız"
></textarea>
                        </div>

                        <button
    class="btn btn-dark"
    type="submit"
>

                            Gönder

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include "../includes/footer.php"; ?>