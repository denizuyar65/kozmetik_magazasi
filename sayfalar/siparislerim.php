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
    FROM siparisler
    WHERE kullanici_id = ?
    ORDER BY siparis_id DESC
");

$sorgu->execute([$kullanici_id]);

$siparisler = $sorgu->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="container mt-5">

    <h2 class="fw-bold mb-4">
        📦 Siparişlerim
    </h2>

    <?php if(count($siparisler) > 0){ ?>

        <div class="card shadow border-0">

            <div class="card-body">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th>#</th>
                            <th>Tarih</th>
                            <th>Tutar</th>
                            <th>Durum</th>
                            <th>İşlem</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php foreach($siparisler as $siparis){ ?>

                        <tr>

                            <td>

                                #<?= $siparis["siparis_id"] ?>

                            </td>

                            <td>

                                <?= date(
                                    "d.m.Y H:i",
                                    strtotime(
                                        $siparis["olusturma_tarihi"]
                                    )
                                ) ?>

                            </td>

                            <td>

                                ₺<?= number_format(
                                    $siparis["toplam_tutar"],
                                    2,
                                    ",",
                                    "."
                                ) ?>

                            </td>

                            <td>

                                <?php

                                if(
                                    $siparis["siparis_durumu"]
                                    ==
                                    "hazirlaniyor"
                                ){

                                    echo '
                                    <span class="badge bg-warning text-dark">
                                        Hazırlanıyor
                                    </span>';

                                }elseif(
                                    $siparis["siparis_durumu"]
                                    ==
                                    "kargoya verildi"
                                ){

                                    echo '
                                    <span class="badge bg-primary">
                                        Kargoya Verildi
                                    </span>';

                                }else{

                                    echo '
                                    <span class="badge bg-success">
                                        Teslim Edildi
                                    </span>';

                                }

                                ?>

                            </td>

                            <td>

                                <a
                                    href="siparis_detay.php?id=<?= $siparis["siparis_id"] ?>"
                                    class="btn btn-dark btn-sm"
                                >

                                    Detay

                                </a>

                            </td>

                        </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    <?php }else{ ?>

        <div class="alert alert-info">

            Henüz siparişiniz bulunmuyor.

        </div>

    <?php } ?>

</div>

<?php include "../includes/footer.php"; ?>