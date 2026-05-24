<?php

session_start();
include "includes/admin_kontrol.php";
include "../config/baglan.php";

include "includes/header.php";
include "includes/sidebar.php";

// Siparişleri çek

$sorgu = $db->query("
    SELECT
        s.*,
        k.ad,
        k.soyad,
        a.sehir,
        a.ilce,
        a.acik_adres

    FROM siparisler s

    LEFT JOIN kullanicilar k
    ON s.kullanici_id = k.kullanici_id

    LEFT JOIN adresler a
    ON s.adres_id = a.adres_id

    ORDER BY s.siparis_id DESC
");

$siparisler = $sorgu->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="admin-content">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="fw-bold">

            Sipariş Yönetimi

        </h2>

    </div>

    <form
        action="toplu_siparis_guncelle.php"
        method="POST"
    >

        <div class="table-responsive">

            <table class="table align-middle bg-white">

                <thead>

                    <tr>

                        <th>

                            <input
                                type="checkbox"
                                id="tumunuSec"
                            >

                        </th>

                        <th>Sipariş No</th>
                        <th>Müşteri</th>
                        <th>Adres</th>
                        <th>Toplam Tutar</th>
                        <th>Durum</th>
                        <th>İşlem</th>

                    </tr>

                </thead>

                <tbody>

                    <?php foreach($siparisler as $siparis){ ?>

                        <?php

$durum = mb_strtolower(
    trim($siparis["siparis_durumu"]),
    "UTF-8"
);

$satirClass = "";

if($durum == "teslim edildi"){

    $satirClass = "table-success";

}elseif($durum == "kargoya verildi"){

    $satirClass = "table-primary";


}elseif($durum == "hazırlanıyor"){

    $satirClass = "table-warning";

}

?>

<tr class="<?= $satirClass ?>">

                            <td>

                                <input
                                    type="checkbox"
                                    name="siparisler[]"
                                    value="<?= $siparis["siparis_id"] ?>"
                                >

                            </td>

                            <!-- Sipariş No -->

                            <td>

                                #<?= $siparis["siparis_id"] ?>

                            </td>

                            <!-- Müşteri -->

                            <td>

                                <?= htmlspecialchars($siparis["ad"]) ?>

                                <?= htmlspecialchars($siparis["soyad"]) ?>

                            </td>

                            <!-- Adres -->

                            <td>

                                <strong>

                                    <?= htmlspecialchars($siparis["sehir"]) ?>

                                    /

                                    <?= htmlspecialchars($siparis["ilce"]) ?>

                                </strong>

                                <br>

                                <small class="text-muted">

                                    <?= htmlspecialchars($siparis["acik_adres"]) ?>

                                </small>

                            </td>

                            <!-- Toplam -->

                            <td>

                                ₺<?= $siparis["toplam_tutar"] ?>

                            </td>

                            <!-- Durum -->

                            <td>

<?php

$durum = mb_strtolower(
    trim($siparis["siparis_durumu"]),
    "UTF-8"
);

if($durum == "teslim edildi"){

    echo '<span class="badge bg-success">
            Teslim Edildi
          </span>';

}elseif($durum == "kargoya verildi"){

    echo '<span class="badge bg-primary">
            Kargoya Verildi
          </span>';



}else{

    echo '<span class="badge bg-warning text-dark">
            Hazırlanıyor
          </span>';

}

?>

</td>
                                

                            

                            <!-- İşlem -->

                            <td>

                                <a
                                    href="siparis_detaylari.php?id=<?= $siparis["siparis_id"] ?>"
                                    class="btn btn-dark btn-sm"
                                >

                                    Detay

                                </a>

                            </td>

                        

                    <?php } ?>

                </tbody>

            </table>

        </div>

        <!-- Toplu Güncelle -->

        <div class="d-flex gap-2 mt-3">

            <select
                name="yeni_durum"
                class="form-select"
                style="max-width:250px;"
            >

                <option value="Hazırlanıyor">

                    Hazırlanıyor

                </option>

                <option value="Kargoya Verildi">

                    Kargoya Verildi

                </option>

                <option value="Teslim Edildi">

                    Teslim Edildi

                </option>

             

            </select>

            <button
                type="submit"
                class="btn btn-success"
            >

                Seçilenleri Güncelle

            </button>

        </div>

    </form>

</div>

<script>

document
.getElementById("tumunuSec")
.addEventListener("change", function(){

    document
    .querySelectorAll(
        'input[name="siparisler[]"]'
    )
    .forEach(function(kutu){

        kutu.checked =
        document
        .getElementById("tumunuSec")
        .checked;

    });

});

</script>

<?php include "includes/footer.php"; ?>