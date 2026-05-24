<?php

session_start();

include "config/baglan.php";

include "includes/header.php";

include "includes/menu.php";

if(isset($_SESSION["basarili"])){

    echo '
    <div class="container mt-3">
        <div class="alert alert-success alert-dismissible fade show">
            '.$_SESSION["basarili"].'
            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>
        </div>
    </div>';

    unset($_SESSION["basarili"]);
}

// Ürünleri çek

$urunler = $db->query("
    SELECT *
    FROM urunler
    ORDER BY urun_id DESC
")->fetchAll(PDO::FETCH_ASSOC);
// Son yorumlar

$yorumlar = $db->query("
    SELECT
        y.*,
        k.ad,
        k.soyad
    FROM yorumlar y
    INNER JOIN kullanicilar k
    ON y.kullanici_id = k.kullanici_id
    ORDER BY y.yorum_id DESC
    LIMIT 6
")->fetchAll(PDO::FETCH_ASSOC);

$cokSatanlar = $db->query("
    SELECT
        u.*,
        SUM(sd.adet) AS toplam_satis

    FROM siparis_detaylari sd

    INNER JOIN urunler u
    ON sd.urun_id = u.urun_id

    GROUP BY sd.urun_id

    ORDER BY toplam_satis DESC

    LIMIT 4
")->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- HERO -->

<!-- SLIDER -->

<section class="container mt-4">

    <div
        id="anaSlider"
        class="carousel slide shadow rounded overflow-hidden"
        data-bs-ride="carousel"
    >

        <div class="carousel-inner">

            <!-- 1 -->

            <div class="carousel-item active">

                <img
                    src="https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9"
                    class="d-block w-100"
                    style="
                        height:450px;
                        object-fit:cover;
                    "
                >

                <div class="carousel-caption">

                    <h1 class="fw-bold">

                        Güzelliğin Yeni Adresi

                    </h1>

                    <p>

                        En kaliteli kozmetik ürünleri burada.

                    </p>

                </div>

            </div>

            <!-- 2 -->

            <div class="carousel-item">

                <img
                    src="https://images.unsplash.com/photo-1512496015851-a90fb38ba796"
                    class="d-block w-100"
                    style="
                        height:450px;
                        object-fit:cover;
                    "
                >

                <div class="carousel-caption">

                    <h1 class="fw-bold">

                        Yeni Sezon Ürünleri

                    </h1>

                    <p>

                        En yeni koleksiyonları keşfet.

                    </p>

                </div>

            </div>

            <!-- 3 -->

            <div class="carousel-item">

                <img
                    src="https://images.unsplash.com/photo-1596462502278-27bfdc403348"
                    class="d-block w-100"
                    style="
                        height:450px;
                        object-fit:cover;
                    "
                >

                <div class="carousel-caption">

                    <h1 class="fw-bold">

                        %40'a Varan İndirimler

                    </h1>

                    <p>

                        Kampanyaları kaçırma.

                    </p>

                </div>

            </div>

        </div>

        <button
            class="carousel-control-prev"
            type="button"
            data-bs-target="#anaSlider"
            data-bs-slide="prev"
        >

            <span class="carousel-control-prev-icon"></span>

        </button>

        <button
            class="carousel-control-next"
            type="button"
            data-bs-target="#anaSlider"
            data-bs-slide="next"
        >

            <span class="carousel-control-next-icon"></span>

        </button>

    </div>

</section>
<?php if(!isset($_SESSION["kullanici_id"])){ ?>

<section class="container mt-4">

    <div class="alert alert-warning text-center shadow-sm">

        <h5 class="mb-1">

            🎉 Üyelere Özel %30 İndirim

        </h5>

        <p class="mb-0">

            Hemen üye ol, ilk siparişinde %30 indirim kazan!

        </p>

    </div>

</section>

<?php } ?>

<!-- KATEGORİLER -->

<section class="container mt-5">

    <div class="row g-4">

        <!-- MAKYAJ -->

        <div class="col-md-3">

            <a
                href="/kozmetik_magazasi/sayfalar/kategori.php?alt_kategori_id=13"
                class="text-decoration-none"
            >

                <div
                    class="card border-0 shadow-sm d-flex justify-content-center align-items-center"
                    style="
                        background:#d4a017;
                        border-radius:20px;
                        height:80px;
                    "
                >

                    <h5
                        class="fw-bold text-center text-white m-0"
                    >

                        Makyaj

                    </h5>

                </div>

            </a>

        </div>

        <!-- CİLT BAKIM -->

        <div class="col-md-3">

            <a
                href="/kozmetik_magazasi/sayfalar/kategori.php?alt_kategori_id=17"
                class="text-decoration-none"
            >

                <div
                    class="card border-0 shadow-sm d-flex justify-content-center align-items-center"
                    style="
                        background:#d4a017;
                        border-radius:20px;
                        height:80px;
                    "
                >

                    <h5
                        class="fw-bold text-center text-white m-0"
                    >

                        Cilt Bakımı

                    </h5>

                </div>

            </a>

        </div>

        <!-- SAÇ BAKIM -->

        <div class="col-md-3">

            <a
                href="/kozmetik_magazasi/sayfalar/kategori.php?alt_kategori_id=20"
                class="text-decoration-none"
            >

                <div
                    class="card border-0 shadow-sm d-flex justify-content-center align-items-center"
                    style="
                        background:#d4a017;
                        border-radius:20px;
                        height:80px;
                    "
                >

                    <h5
                        class="fw-bold text-center text-white m-0"
                    >

                        Saç Bakımı

                    </h5>

                </div>

            </a>

        </div>

        <!-- PARFÜM -->

        <div class="col-md-3">

            <a
                href="/kozmetik_magazasi/sayfalar/kategori.php?alt_kategori_id=23"
                class="text-decoration-none"
            >

                <div
                    class="card border-0 shadow-sm d-flex justify-content-center align-items-center"
                    style="
                        background:#d4a017;
                        border-radius:20px;
                        height:80px;
                    "
                >

                    <h5
                        class="fw-bold text-center text-white m-0"
                    >

                        Parfüm

                    </h5>

                </div>

            </a>

        </div>

    </div>

</section>
<!-- KAMPANYALAR -->

<section class="container mt-5">

    <div class="row g-4">

        <div class="col-md-4">

            <div
                class="card border-0 shadow h-100 text-center p-4"
            >

                <h2>

                    🚚

                </h2>

                <h5 class="fw-bold">

                    Ücretsiz Kargo

                </h5>

                <p class="text-muted">

                    500 TL ve üzeri alışverişlerde ücretsiz kargo.

                </p>

            </div>

        </div>

        <div class="col-md-4">

            <div
                class="card border-0 shadow h-100 text-center p-4"
            >

                <h2>

                    🎁

                </h2>

                <h5 class="fw-bold">

                    Hediye Fırsatları

                </h5>

                <p class="text-muted">

                    Seçili ürünlerde özel kampanyalar.

                </p>

            </div>

        </div>

        <div class="col-md-4">

            <div
                class="card border-0 shadow h-100 text-center p-4"
            >

                <h2>

                    🔒

                </h2>

                <h5 class="fw-bold">

                    Güvenli Ödeme

                </h5>

                <p class="text-muted">

                    Tüm ödemeler güvenli altyapı ile korunur.

                </p>

            </div>

        </div>

    </div>

</section>
<section class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="fw-bold">
            🔥 Çok Satanlar
        </h2>

    </div>

    <div class="row g-4">

        <?php foreach($cokSatanlar as $urun){ ?>

        <div class="col-md-3">

            <a
                href="sayfalar/urun_detay.php?id=<?= $urun["urun_id"] ?>"
                class="text-decoration-none text-dark"
            >

                <div
                    class="card border-0 shadow-sm h-100 cok-satan-card"
                >

                    <img
                        src="<?= $urun["resim_url"] ?>"
                        class="card-img-top"
                        style="
                            height:220px;
                            object-fit:cover;
                        "
                    >

                    <div class="card-body text-center">

                        <span
                            class="badge bg-danger mb-2"
                        >
                            🔥 Çok Satan
                        </span>

                        <h6 class="fw-bold">

                            <?= htmlspecialchars(
                                $urun["urun_adi"]
                            ) ?>

                        </h6>

                        <div
                            class="text-success fw-bold fs-5"
                        >

                            ₺<?= number_format(
                                $urun["fiyat"],
                                2,
                                ",",
                                "."
                            ) ?>

                        </div>

                        <small
                            class="text-muted"
                        >

                            <?= $urun["toplam_satis"] ?>
                            adet satıldı

                        </small>

                    </div>

                </div>

            </a>

        </div>

        <?php } ?>

    </div>

</section>

<!-- ÜRÜNLER -->

<section
    class="container mt-5 mb-5"
    id="urunler"
>

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="fw-bold">

            Yeni Ürünler

        </h2>

    </div>

    <div class="row g-4">

        <?php foreach($urunler as $urun){ ?>

            <?php

            $favoriKontrol = false;

            if(isset($_SESSION["kullanici_id"])){

                $favSorgu = $db->prepare("
                    SELECT *
                    FROM favoriler
                    WHERE kullanici_id = ?
                    AND urun_id = ?
                ");

                $favSorgu->execute([
                    $_SESSION["kullanici_id"],
                    $urun["urun_id"]
                ]);

                if($favSorgu->rowCount() > 0){

                    $favoriKontrol = true;

                }

            }

            ?>

            <div class="col-md-3">

                <div class="card border-0 shadow-sm h-100 position-relative">

    <span
        class="badge bg-danger position-absolute m-2"
    >

        Yeni

    </span>

    

                    <!-- RESİM -->

                    <a
                        href="/kozmetik_magazasi/sayfalar/urun_detay.php?id=<?= $urun["urun_id"] ?>"
                    >

                        <img
                            src="<?= $urun["resim_url"] ?>"
                            class="card-img-top"
                            style="
                                height:250px;
                                object-fit:cover;
                            "
                        >

                    </a>

                    <!-- İÇERİK -->

                    <div class="card-body">

                        <h5 class="card-title">

                            <a
                                href="/kozmetik_magazasi/sayfalar/urun_detay.php?id=<?= $urun["urun_id"] ?>"
                                class="text-dark text-decoration-none"
                            >

                                <?= htmlspecialchars($urun["urun_adi"]) ?>

                            </a>

                        </h5>

                        <p class="text-muted small">

                            <?= htmlspecialchars($urun["aciklama"]) ?>

                        </p>
                        
<?php

$puanSorgu = $db->prepare("
    SELECT
        AVG(puan) as ortalama,
        COUNT(*) as toplam
    FROM yorumlar
    WHERE urun_id = ?
");

$puanSorgu->execute([
    $urun["urun_id"]
]);

$puan = $puanSorgu->fetch(PDO::FETCH_ASSOC);

?>

<div class="text-warning mb-2">

<?php

if($puan["toplam"] > 0){

    echo str_repeat(
        "★",
        round($puan["ortalama"])
    );

}else{

    echo "☆☆☆☆☆";

}

?>

<small class="text-muted">

    (<?= $puan["toplam"] ?>)

</small>

</div>
                        <h4 class="fw-bold">

                            ₺<?= $urun["fiyat"] ?>

                        </h4>

                    </div>

                    <!-- BUTONLAR -->

                    <div class="card-footer bg-white border-0">

                        <div class="d-grid gap-2">

                            <!-- SEPET -->
                             <a
                              href="/kozmetik_magazasi/sayfalar/urun_detay.php?id=<?= $urun["urun_id"] ?>"
                              class="btn btn-outline-dark"
                              >

                              İncele

                            </a>

                            <a
                                href="/kozmetik_magazasi/ajax/sepete_ekle.php?urun_id=<?= $urun["urun_id"] ?>"
                                class="btn btn-dark"
                            >

                                Sepete Ekle

                            </a>

                            <!-- FAVORİ -->

                            <?php if($favoriKontrol){ ?>

                                <a
                                    href="/kozmetik_magazasi/ajax/favori_sil.php?urun_id=<?= $urun["urun_id"] ?>"
                                    class="btn btn-danger"
                                >

                                    <i class="bi bi-heart-fill"></i>

                                    Favoriden Kaldır

                                </a>

                            <?php }else{ ?>

                                <a
                                    href="/kozmetik_magazasi/ajax/favori_ekle.php?urun_id=<?= $urun["urun_id"] ?>"
                                    class="btn btn-outline-danger"
                                >

                                    <i class="bi bi-heart"></i>

                                    Favorilere Ekle

                                </a>

                            <?php } ?>

                        </div>

                    </div>

                </div>

            </div>

        <?php } ?>

    </div>
<section class="container mt-5 mb-5">

    <div class="text-center mb-5">

        <h2 class="fw-bold">

            ⭐ Müşteri Yorumları

        </h2>

        <p class="text-muted">

            Müşterilerimizin deneyimleri

        </p>

    </div>

    <div class="row g-4">

        <?php foreach($yorumlar as $yorum){ ?>

            <div class="col-md-4">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body">

                        <div class="text-warning mb-3">

                            <?= str_repeat(
                                "★",
                                $yorum["puan"]
                            ) ?>

                        </div>

                        <p class="mb-3">

                            "
                            <?= htmlspecialchars(
                                $yorum["yorum"]
                            ) ?>
                            "

                        </p>

                        <hr>

                        <strong>

                            <?= htmlspecialchars(
                                $yorum["ad"]
                            ) ?>

                            <?= htmlspecialchars(
                                $yorum["soyad"]
                            ) ?>

                        </strong>

                    </div>

                </div>

            </div>

        <?php } ?>

    </div>

</section>
</section>
<section class="footer-main mt-5">

    <div class="container py-5">

        <div class="row align-items-center">

            <div class="col-lg-7">

                <h2 class="footer-logo">

                    VELOURA COSMETICS

                </h2>

                <p class="footer-text">

                    Kaliteli kozmetik ürünlerini güvenli alışveriş
                    deneyimiyle müşterilerimize ulaştırıyoruz.

                </p>

            </div>

            <div class="col-lg-5 text-lg-end">

                <p class="mb-3">

                    <i class="bi bi-envelope"></i>

                    info@veloura.com

                </p>

                <p class="mb-3">

                    <i class="bi bi-telephone"></i>

                    +90 555 555 55 55

                </p>

                <div class="footer-social">

                    <i class="bi bi-instagram me-3"></i>

                    <i class="bi bi-facebook me-3"></i>

                    <i class="bi bi-twitter-x"></i>

                </div>

            </div>

        </div>

    </div>
<div class="footer-bottom">

    © <?= date("Y") ?> VELOURA COSMETICS • Tüm Hakları Saklıdır.

</div>
</section>

<?php include "includes/footer.php"; ?>