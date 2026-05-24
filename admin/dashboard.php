<?php

session_start();
include "includes/admin_kontrol.php";
include "../config/baglan.php";

include "includes/header.php";
include "includes/sidebar.php";

// Toplam ürün

$urunSayisi = $db->query("
    SELECT COUNT(*) as toplam
    FROM urunler
")->fetch(PDO::FETCH_ASSOC);

// Toplam kullanıcı

$kullaniciSayisi = $db->query("
    SELECT COUNT(*) as toplam
    FROM kullanicilar
")->fetch(PDO::FETCH_ASSOC);

// Toplam sipariş

$siparisSayisi = $db->query("
    SELECT COUNT(*) as toplam
    FROM siparisler
")->fetch(PDO::FETCH_ASSOC);

// Toplam kazanç

$kazanc = $db->query("
    SELECT SUM(toplam_tutar) as toplam
    FROM siparisler
")->fetch(PDO::FETCH_ASSOC);
// Toplam mesaj

$mesajSayisi = $db->query("
    SELECT COUNT(*) as toplam
    FROM iletisim_mesajlari
")->fetch(PDO::FETCH_ASSOC);

// Son siparişler

$sonSiparisler = $db->query("
    SELECT
        s.*,
        k.ad,
        k.soyad

    FROM siparisler s

    LEFT JOIN kullanicilar k
    ON s.kullanici_id = k.kullanici_id

    ORDER BY s.siparis_id DESC

    LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);

// Düşük stok

$stoklar = $db->query("
    SELECT *
    FROM urunler
    WHERE stok <= 5
")->fetchAll(PDO::FETCH_ASSOC);
$enCokSatanlar = $db->query("
    SELECT
        u.urun_adi,
        SUM(sd.adet) as toplam_satis
    FROM siparis_detaylari sd
    INNER JOIN urunler u
        ON sd.urun_id = u.urun_id
    GROUP BY sd.urun_id
    ORDER BY toplam_satis DESC
    LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);
// Son mesajlar

$sonMesajlar = $db->query("
    SELECT *
    FROM iletisim_mesajlari
    ORDER BY mesaj_id DESC
    LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);
$yorumSayisi = $db->query("
SELECT COUNT(*) 
FROM yorumlar
")->fetchColumn();
$hazirlaniyor = $db->query("
    SELECT COUNT(*)
    FROM siparisler
    WHERE siparis_durumu='hazirlaniyor'
")->fetchColumn();

$kargoda = $db->query("
    SELECT COUNT(*)
    FROM siparisler
    WHERE siparis_durumu='kargoya verildi'
")->fetchColumn();

$teslim = $db->query("
    SELECT COUNT(*)
    FROM siparisler
    WHERE siparis_durumu='teslim edildi'
")->fetchColumn();
?>

<div class="admin-content">
    
    <h2 class="fw-bold mb-4">

        Dashboard

    </h2>

    <div class="alert alert-primary border-0 shadow-sm mb-4">

    Hoş geldin
    <strong>
        <?= $_SESSION["admin_ad"] ?>
    </strong>

    👋 Yönetim paneline başarıyla giriş yaptınız.

</div>

    <!-- İstatistik Kartları -->

<div class="row g-4 mb-5">

    <!-- Ürün -->

    <div class="col-md-4 col-lg">

    <div class="card dashboard-card bg-primary text-white">

        <div class="card-body text-center">

            <div class="dashboard-icon">
                📦
            </div>

            <div class="dashboard-number">
                <?= $urunSayisi["toplam"] ?>
            </div>

            <div class="dashboard-title">
                Toplam Ürün
            </div>

        </div>

    </div>

</div>

    <!-- Kullanıcı -->

    <div class="col-md-4 col-lg">

    <div class="card dashboard-card bg-purple text-white">

        <div class="card-body text-center">

            <div class="dashboard-icon">
                👤
            </div>

            <div class="dashboard-number">
                <?= $kullaniciSayisi["toplam"] ?>
            </div>

            <div class="dashboard-title">
                Kullanıcı
            </div>

        </div>

    </div>

</div>

    <!-- Sipariş -->

    <div class="col-md-4 col-lg">

    <div class="card dashboard-card bg-success text-white">

        <div class="card-body text-center">

            <div class="dashboard-icon">
                🛒
            </div>

            <div class="dashboard-number">
                <?= $siparisSayisi["toplam"] ?>
            </div>

            <div class="dashboard-title">
                Sipariş
            </div>

        </div>

    </div>

</div>
    
<div class="col-md-4 col-lg">

    <div class="card dashboard-card bg-warning text-dark">

        <div class="card-body text-center">

            <div class="dashboard-icon">
                💬
            </div>

            <div class="dashboard-number">
                <?= $yorumSayisi ?>
            </div>

            <div class="dashboard-title">
                Yorum
            </div>

        </div>

    </div>

</div>

    <!-- Mesaj -->

    <div class="col-md-4 col-lg">

    <div class="card dashboard-card bg-info text-white">

        <div class="card-body text-center">

            <div class="dashboard-icon">
                ✉️
            </div>

            <div class="dashboard-number">
                <?= $mesajSayisi["toplam"] ?>
            </div>

            <div class="dashboard-title">
                Mesaj
            </div>

        </div>

    </div>

</div>

</div>
       <div class="col-md-4 col-lg-2">

    <div class="card dashboard-card bg-danger text-white">

        <div class="card-body text-center">

            <div class="dashboard-icon">
                💰
            </div>

            <div class="dashboard-number">
                ₺<?= number_format($kazanc["toplam"] ?? 0,0,",",".") ?>
            </div>

            <div class="dashboard-title">
                Kazanç
            </div>

        </div>

    </div>

</div>


<div class="card shadow mt-4 mb-4">

    <div class="card-body">

        <h5 class="mb-4">

            Sipariş Durum Dağılımı

        </h5>

        <div
            style="
                max-width:450px;
                margin:auto;
            "
        >

            <canvas id="durumGrafik"></canvas>

        </div>

    </div>

</div>

    <!-- Alt Kısım -->
<div class="card shadow mt-4 mb-4">

    <div class="card-body">

        <h5 class="mb-4 fw-bold">
    📩 Son Gelen Mesajlar
</h5>

        <?php if(count($sonMesajlar) > 0){ ?>

            <?php foreach($sonMesajlar as $mesaj){ ?>

                <div
    class="
     message-item
        d-flex
        justify-content-between
        align-items-center
        p-3
        mb-3
        bg-light
        rounded-4
    "
>

    <div>

        <div class="fw-bold">

            👤
            <?= htmlspecialchars($mesaj["ad_soyad"]) ?>

        </div>

        <div class="text-muted small mt-1">

            <?= substr(
                htmlspecialchars($mesaj["mesaj"]),
                0,
                70
            ) ?>

            ...

        </div>

    </div>

    <a
        href="mesaj_detay.php?id=<?= $mesaj["mesaj_id"] ?>"
        class="btn btn-primary btn-sm"
    >

        Aç

    </a>

</div>

                   
    

            <?php } ?>

        <?php }else{ ?>

            <div class="alert alert-info mb-0">

                Henüz mesaj bulunmuyor.

            </div>

        <?php } ?>

    </div>

</div>
    <div class="row g-">

        <!-- Son Siparişler -->

        <div class="col-md-8">

            <div class="card shadow">

                <div class="card-body">

                    <h5 class="mb-4 fw-bold">
    🛒 Son Siparişler
</h5>
                    <table class="table align-middle">

                        <thead>

                            <tr>

                                <th>#</th>
                                <th>Müşteri</th>
                                <th>Tutar</th>
                                <th>Durum</th>
                                <th>İşlem</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach($sonSiparisler as $siparis){ ?>

                                <tr>

                                    <td>

                                       <span class="fw-bold text-primary">
    #<?= $siparis["siparis_id"] ?>
</span>
                                    </td>

                                    <td>

                                        <?= $siparis["ad"] ?>

                                        <?= $siparis["soyad"] ?>

                                    </td>

                                    <td>

                                        ₺<?= $siparis["toplam_tutar"] ?>

                                    </td>

                                    <td>

<?php if($siparis["siparis_durumu"] == "hazirlaniyor"){ ?>

    <span class="badge bg-warning text-dark">
        Hazırlanıyor
    </span>

<?php }elseif($siparis["siparis_durumu"] == "kargoya verildi"){ ?>

    <span class="badge bg-primary">
        Kargoya Verildi
    </span>

<?php }elseif($siparis["siparis_durumu"] == "teslim edildi"){ ?>

    <span class="badge bg-success">
        Teslim Edildi
    </span>

<?php }else{ ?>

    <span class="badge bg-secondary">
        Belirsiz
    </span>

<?php } ?>
<td>

    <a
        href="siparis_detaylari.php?id=<?= $siparis["siparis_id"] ?>"
        class="btn btn-sm btn-dark"
    >
        Detay
    </a>

</td>

</td>
                                </tr>

                            <?php } ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        <!-- Düşük Stok -->

        <div class="col-md-4">

            <div class="card shadow">

                <div class="card-body">

                    <h5 class="mb-4 text-danger">

                        Düşük Stok

                    </h5>

                    <?php if(count($stoklar) > 0){ ?>

                        <?php foreach($stoklar as $urun){ ?>

                            <div
                                class="d-flex justify-content-between border-bottom py-2"
                            >

                                <span>

                                    <?= $urun["urun_adi"] ?>

                                </span>

                                <span class="text-danger fw-bold">

                                    <?= $urun["stok"] ?>

                                </span>

                            </div>

                        <?php } ?>

                    <?php }else{ ?>

                        <div class="alert alert-success mb-0">

                            Kritik stok yok.

                        </div>

                    <?php } ?>

                </div>

            </div>

        </div>
        <div class="card shadow mt-4">

    <div class="card-body">

       <h5 class="mb-4 text-warning fw-bold">
    🏆 En Çok Satan Ürünler
</h5>

        <?php if(count($enCokSatanlar) > 0){ ?>

            <?php foreach($enCokSatanlar as $urun){ ?>

                <div
                    class="d-flex justify-content-between border-bottom py-2"
                >

                    <span>

                        <?= htmlspecialchars($urun["urun_adi"]) ?>

                    </span>

                    <span class="fw-bold text-success">

                        <?= $urun["toplam_satis"] ?>

                        adet

                    </span>

                </div>

            <?php } ?>

        <?php }else{ ?>

            <div class="alert alert-info mb-0">

                Henüz satış bulunmuyor.

            </div>

        <?php } ?>

    </div>

</div>

    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const durumCtx =
document.getElementById(
    'durumGrafik'
);

new Chart(durumCtx, {

    type: 'doughnut',

    data: {

        labels: [

            'Hazırlanıyor',
            'Kargoya Verildi',
            'Teslim Edildi'

        ],

        datasets: [{

            data: [

                <?= $hazirlaniyor ?>,
                <?= $kargoda ?>,
                <?= $teslim ?>

            ],

            backgroundColor: [

                '#ffc107',
                '#0d6efd',
                '#198754'

            ],

            borderWidth:0

        }]

    },

    options: {

        responsive:true,

        plugins: {

            legend: {

                position:'bottom'

            }

        }

    }

});

</script>

<?php include "includes/footer.php"; ?>