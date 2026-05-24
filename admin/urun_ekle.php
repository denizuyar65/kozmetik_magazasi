<?php

session_start();
include "includes/admin_kontrol.php";
include "../config/baglan.php";

include "includes/header.php";
include "includes/sidebar.php";

// Kategorileri çek

$kategoriler = $db->query("
    SELECT *
    FROM kategoriler
")->fetchAll(PDO::FETCH_ASSOC);

// Alt kategorileri çek

$altKategoriler = $db->query("
    SELECT *
    FROM alt_kategoriler
")->fetchAll(PDO::FETCH_ASSOC);

// Ürün ekleme

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $kategori_id =
        $_POST["kategori_id"];

    $alt_kategori_id =
        $_POST["alt_kategori_id"];

    $urun_adi =
        trim($_POST["urun_adi"]);

    $fiyat =
        trim($_POST["fiyat"]);

    $stok =
        trim($_POST["stok"]);

    $aciklama =
        trim($_POST["aciklama"]);

    // Resim yükleme

    $resim = $_FILES["resim"];

    $resimAdi =
        time() .
        "_" .
        $resim["name"];

    $hedef =
        "../uploads/" .
        $resimAdi;

    move_uploaded_file(
        $resim["tmp_name"],
        $hedef
    );

    // Veritabanına kayıt

    $ekle = $db->prepare("
        INSERT INTO urunler
        (
            kategori_id,
            alt_kategori_id,
            urun_adi,
            fiyat,
            stok,
            aciklama,
            resim_url
        )
        VALUES
        (?, ?, ?, ?, ?, ?, ?)
    ");

    $ekle->execute([
        $kategori_id,
        $alt_kategori_id,
        $urun_adi,
        $fiyat,
        $stok,
        $aciklama,
        "uploads/" . $resimAdi
    ]);

    echo "

    <div class='admin-content'>

        <div class='alert alert-success'>

            Ürün başarıyla eklendi.

        </div>

    </div>

    ";

}

?>

<div class="admin-content">

    <h2 class="fw-bold mb-4">

        Yeni Ürün Ekle

    </h2>

    <div class="card shadow">

        <div class="card-body">

            <form
                method="POST"
                enctype="multipart/form-data"
            >

                <!-- Kategori -->

                <div class="mb-3">

                    <label class="form-label">

                        Kategori

                    </label>

                    <select
                        name="kategori_id"
                        class="form-select"
                        required
                    >

                        <option value="">

                            Seçiniz

                        </option>

                        <?php foreach($kategoriler as $kategori){ ?>

                            <option
                                value="<?= $kategori["kategori_id"] ?>"
                            >

                                <?= $kategori["kategori_adi"] ?>

                            </option>

                        <?php } ?>

                    </select>

                </div>

                <!-- Alt Kategori -->

                <div class="mb-3">

                    <label class="form-label">

                        Alt Kategori

                    </label>

                    <select
                        name="alt_kategori_id"
                        class="form-select"
                        required
                    >

                        <option value="">

                            Alt kategori seç

                        </option>

                        <?php foreach($altKategoriler as $altKategori){ ?>

                            <option
                                value="<?= $altKategori["alt_kategori_id"] ?>"
                            >

                                <?= $altKategori["alt_kategori_adi"] ?>

                            </option>

                        <?php } ?>

                    </select>

                </div>

                <!-- Ürün Adı -->

                <div class="mb-3">

                    <label class="form-label">

                        Ürün Adı

                    </label>

                    <input
                        type="text"
                        name="urun_adi"
                        class="form-control"
                        required
                    >

                </div>

                <!-- Fiyat -->

                <div class="mb-3">

                    <label class="form-label">

                        Fiyat

                    </label>

                    <input
                        type="number"
                        name="fiyat"
                        class="form-control"
                        required
                    >

                </div>

                <!-- Stok -->

                <div class="mb-3">

                    <label class="form-label">

                        Stok

                    </label>

                    <input
                        type="number"
                        name="stok"
                        class="form-control"
                        required
                    >

                </div>

                <!-- Açıklama -->

                <div class="mb-3">

                    <label class="form-label">

                        Açıklama

                    </label>

                    <textarea
                        name="aciklama"
                        class="form-control"
                        rows="5"
                    ></textarea>

                </div>

                <!-- Resim -->

                <div class="mb-4">

                    <label class="form-label">

                        Ürün Resmi

                    </label>

                    <input
                        type="file"
                        name="resim"
                        class="form-control"
                        required
                    >

                </div>

                <!-- Buton -->

                <button
                    class="btn btn-dark"
                >

                    Ürünü Kaydet

                </button>

            </form>

        </div>

    </div>

</div>

<?php include "includes/footer.php"; ?>