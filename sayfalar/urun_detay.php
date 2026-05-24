<?php

session_start();

include "../config/baglan.php";

include "../includes/header.php";

include "../includes/menu.php";

// ID kontrolü

if(!isset($_GET["id"])){

    die("Ürün bulunamadı.");

}

$id = intval($_GET["id"]);

// Ürünü çek

$sorgu = $db->prepare("
    SELECT *
    FROM urunler
    WHERE urun_id = ?
");

$sorgu->execute([$id]);

$urun = $sorgu->fetch(PDO::FETCH_ASSOC);

// Ürün yoksa

if(!$urun){

    die("Ürün bulunamadı.");

}
// Ürün yorumları

$yorumSorgu = $db->prepare("
    SELECT
        y.*,
        k.ad,
        k.soyad
    FROM yorumlar y
    INNER JOIN kullanicilar k
    ON y.kullanici_id = k.kullanici_id
    WHERE y.urun_id = ?
    ORDER BY y.yorum_id DESC
");

$yorumSorgu->execute([$id]);

$yorumlar = $yorumSorgu->fetchAll(PDO::FETCH_ASSOC);
// Ortalama puan

$puanSorgu = $db->prepare("
    SELECT
        AVG(puan) as ortalama,
        COUNT(*) as toplam
    FROM yorumlar
    WHERE urun_id = ?
");

$puanSorgu->execute([$id]);

$puanBilgi = $puanSorgu->fetch(PDO::FETCH_ASSOC);
// Favori kontrol

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

<section class="container my-5">

    <div class="row g-5">

        <!-- Resim -->

        <div class="col-md-6">

            <div class="card border-0 shadow-sm">

                <img
                    src="../<?= $urun["resim_url"] ?>"
                    class="img-fluid rounded"
                    style="
                        height:550px;
                        object-fit:cover;
                    "
                >

            </div>

        </div>

        <!-- Bilgiler -->

        <div class="col-md-6">

            <h1 class="fw-bold mb-3">

                <?= htmlspecialchars($urun["urun_adi"]) ?>

            </h1>
            <?php if($puanBilgi["toplam"] > 0){ ?>

<div class="mb-3">

    <span class="text-warning fs-5">

        <?= str_repeat(
            "★",
            round($puanBilgi["ortalama"])
        ) ?>

    </span>

    <span class="text-muted">

        (<?= number_format(
            $puanBilgi["ortalama"],
            1
        ) ?> / 5)

        •

        <?= $puanBilgi["toplam"] ?>

        değerlendirme

    </span>

</div>

<?php } ?>

            <p class="text-muted mb-4">

                <?= htmlspecialchars($urun["aciklama"]) ?>

            </p>

            <h2 class="fw-bold mb-4">

                ₺<?= $urun["fiyat"] ?>

            </h2>

            <!-- Stok -->

            <?php if($urun["stok"] > 0){ ?>

                <div class="alert alert-success">

                    Stokta mevcut

                </div>

            <?php }else{ ?>

                <div class="alert alert-danger">

                    Stok tükendi

                </div>

            <?php } ?>

            <!-- Butonlar -->

            <div class="d-flex gap-3 mt-4">

                <!-- Sepete Ekle -->

                <a
                    href="../ajax/sepete_ekle.php?urun_id=<?= $urun["urun_id"] ?>"
                    class="btn btn-dark btn-lg"
                >

                    Sepete Ekle

                </a>

                <!-- Favori -->

                <?php if($favoriKontrol){ ?>

                    <a
                        href="../ajax/favori_sil.php?urun_id=<?= $urun["urun_id"] ?>"
                        class="btn btn-danger btn-lg"
                    >

                        <i class="bi bi-heart-fill"></i>

                    </a>

                <?php }else{ ?>

                    <a
                        href="../ajax/favori_ekle.php?urun_id=<?= $urun["urun_id"] ?>"
                        class="btn btn-outline-danger btn-lg"
                    >

                        <i class="bi bi-heart"></i>

                    </a>

                <?php } ?>

            </div>

        </div>

    </div>

</section>
<section class="container mb-5">

    <h3 class="fw-bold mb-4">

        Ürün Yorumları

    </h3>

    <?php if(isset($_SESSION["kullanici_id"])){ ?>

        <div class="card shadow-sm mb-4">

            <div class="card-body">

                <form
                    action="yorum_ekle.php"
                    method="POST"
                >

                    <input
                        type="hidden"
                        name="urun_id"
                        value="<?= $urun["urun_id"] ?>"
                    >

                    <div class="mb-3">

                        <label class="form-label">

                            Puan

                        </label>

                        <select
                            name="puan"
                            class="form-select"
                        >

                            <option value="5">★★★★★</option>
                            <option value="4">★★★★☆</option>
                            <option value="3">★★★☆☆</option>
                            <option value="2">★★☆☆☆</option>
                            <option value="1">★☆☆☆☆</option>

                        </select>

                    </div>

                    <div class="mb-3">

                        <textarea
                            name="yorum"
                            class="form-control"
                            rows="4"
                            placeholder="Yorumunuzu yazın..."
                            required
                        ></textarea>

                    </div>

                    <button
                        class="btn btn-dark"
                    >

                        Yorumu Gönder

                    </button>

                </form>

            </div>

        </div>

    <?php } ?>

    <?php foreach($yorumlar as $yorum){ ?>

        <div class="card shadow-sm mb-3">

            <div class="card-body">

                <h6 class="fw-bold">

                    <?= htmlspecialchars($yorum["ad"]) ?>

                    <?= htmlspecialchars($yorum["soyad"]) ?>

                </h6>

                <div class="text-warning mb-2">

                    <?= str_repeat("★", $yorum["puan"]) ?>

                </div>

                <p class="mb-0">
                    <?php

if(
    isset($_SESSION["kullanici_id"])
    &&
    $_SESSION["kullanici_id"]
    ==
    $yorum["kullanici_id"]
){

?>

<a
    href="yorum_sil.php?id=<?= $yorum["yorum_id"] ?>"
    class="btn btn-sm btn-outline-danger mt-3"
>

    Yorumu Sil

</a>

<?php } ?>

                    <?= nl2br(
                        htmlspecialchars(
                            $yorum["yorum"]
                        )
                    ) ?>

                </p>

            </div>

        </div>

    <?php } ?>

</section>
<?php include "../includes/footer.php"; ?>