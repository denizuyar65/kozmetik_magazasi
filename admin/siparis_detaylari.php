<?php

session_start();
include "includes/admin_kontrol.php";
include "../config/baglan.php";

include "includes/header.php";
include "includes/sidebar.php";

// ID kontrolü

if (!isset($_GET["id"])) {

    die("Sipariş bulunamadı.");
}

$id = intval($_GET["id"]);

// Sipariş bilgisi

$siparisSorgu = $db->prepare("
    SELECT
        s.*,
        k.ad,
        k.soyad,
        k.email,
        a.sehir,
        a.ilce,
        a.acik_adres

    FROM siparisler s

    LEFT JOIN kullanicilar k
    ON s.kullanici_id = k.kullanici_id

    LEFT JOIN adresler a
    ON s.adres_id = a.adres_id

    WHERE s.siparis_id = ?
");

$siparisSorgu->execute([$id]);

$siparis = $siparisSorgu->fetch(PDO::FETCH_ASSOC);

// Sipariş yoksa

if (!$siparis) {

    die("Sipariş bulunamadı.");
}

// Sipariş ürünleri

$urunlerSorgu = $db->prepare("
    SELECT
        sd.*,
        u.urun_adi,
        u.resim_url

    FROM siparis_detaylari sd

    LEFT JOIN urunler u
    ON sd.urun_id = u.urun_id

    WHERE sd.siparis_id = ?
");

$urunlerSorgu->execute([$id]);

$urunler = $urunlerSorgu->fetchAll(PDO::FETCH_ASSOC);

// Sipariş durumu güncelle

if (isset($_POST["guncelle"])) {

    $siparis_durumu =
        trim($_POST["siparis_durumu"]);

    $guncelle = $db->prepare("
        UPDATE siparisler
        SET siparis_durumu = ?
        WHERE siparis_id = ?
    ");

    $guncelle->execute([
        $siparis_durumu,
        $id
    ]);

    echo "
    <script>
        window.location.href =
        'siparis_detaylari.php?id=$id';
    </script>
    ";

    exit;
}

?>

<div class="admin-content">

    <h2 class="fw-bold mb-4">

        📦 Sipariş
        <span class="text-primary">
            #<?= $siparis["siparis_id"] ?>
        </span>

    </h2>

    <div class="row g-4">

        <!-- Müşteri -->

        <div class="col-md-6">

            <div class="card shadow h-100">

                <div class="card-body">

                    <h4>
                        👤 Müşteri Bilgileri
                    </h4>

                    <p>

                        <strong>Ad Soyad:</strong>

                        <?= htmlspecialchars($siparis["ad"]) ?>

                        <?= htmlspecialchars($siparis["soyad"]) ?>

                    </p>

                    <p>

                        <strong>Email:</strong>

                        <?= htmlspecialchars($siparis["email"]) ?>

                    </p>

                </div>

            </div>

        </div>

        <!-- Adres -->

        <div class="col-md-6">

            <div class="card shadow h-100">

                <div class="card-body">

                    <h4>
                        📍 Teslimat Adresi
                    </h4>

                    <p>

                        <?= htmlspecialchars($siparis["sehir"]) ?>

                        /

                        <?= htmlspecialchars($siparis["ilce"]) ?>

                    </p>

                    <p class="text-muted">

                        <?= htmlspecialchars($siparis["acik_adres"]) ?>

                    </p>

                </div>

            </div>

        </div>

    </div>

    <!-- Sipariş Ürünleri -->

    <div class="card shadow mt-4">

        <div class="card-body">

            <h4>
                🛒 Sipariş Ürünleri
            </h4>
            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>
                            <th>Resim</th>
                            <th>Ürün</th>
                            <th>Adet</th>
                            <th>Toplam Tutar</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php foreach ($urunler as $urun) { ?>

                            <tr>

                                <td width="100">

                                    <img
                                        src="../<?= $urun["resim_url"] ?>"
                                        class="siparis-resim shadow-sm">

                                </td>

                                <td>

                                    <strong>

                                        <?= htmlspecialchars($urun["urun_adi"]) ?>

                                    </strong>

                                </td>

                                <td>

                                    <?= $urun["adet"] ?>

                                </td>

                                <td>

                                    <strong class="text-success">

                                        ₺<?= number_format(
                                                $urun["birim_fiyat"] * $urun["adet"],
                                                2,
                                                ",",
                                                "."
                                            ) ?>

                                    </strong>

                                </td>

                            </tr>

                        <?php } ?>

                    </tbody>

                </table>
                <div class="text-end mt-4">

                    <h4 class="fw-bold text-success">

                        Toplam:
                        ₺<?= number_format($siparis["toplam_tutar"], 2, ",", ".") ?>

                    </h4>

                </div>

            </div>

        </div>

    </div>

    <!-- Durum Güncelle -->

    <div class="card shadow mt-4">

        <div class="card-body">

            <h4>
                🚚 Sipariş Durumu
            </h4>

            <form method="POST">

                <select
                    name="siparis_durumu"
                    class="form-select form-select-lg">

                    <option
                        value="hazırlanıyor"

                        <?= strtolower($siparis["siparis_durumu"]) == "hazırlanıyor" ? "selected" : "" ?>>

                        Hazırlanıyor

                    </option>

                    <option
                        value="kargoya verildi"

                        <?= strtolower($siparis["siparis_durumu"]) == "kargoya verildi" ? "selected" : "" ?>>

                        Kargoya Verildi

                    </option>

                    <option
                        value="teslim edildi"

                        <?= strtolower($siparis["siparis_durumu"]) == "teslim edildi" ? "selected" : "" ?>>

                        Teslim Edildi

                    </option>

                </select>

                <button
                    type="submit"
                    name="guncelle"
                    class="btn btn-success px-4">

                    Güncelle

                </button>

            </form>

        </div>

    </div>

</div>