<?php

session_start();
include "includes/admin_kontrol.php";
include "../config/baglan.php";

include "includes/header.php";
include "includes/sidebar.php";

// ID kontrolü

if (!isset($_GET["id"])) {

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

// Kategoriler

$kategoriler = $db->query("
    SELECT *
    FROM kategoriler
")->fetchAll(PDO::FETCH_ASSOC);

// Güncelleme

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $kategori_id =
        $_POST["kategori_id"];

    $urun_adi =
        trim($_POST["urun_adi"]);

    $fiyat =
        trim($_POST["fiyat"]);

    $stok =
        trim($_POST["stok"]);

    $aciklama =
        trim($_POST["aciklama"]);

    $resim_url =
        $urun["resim_url"];

    // Yeni resim seçildi mi?

    if (
        isset($_FILES["resim"])
        &&
        $_FILES["resim"]["name"] != ""
    ) {

        $resim =
            $_FILES["resim"];

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

        $resim_url =
            "uploads/" .
            $resimAdi;
    }

    // Güncelle

    $guncelle = $db->prepare("
        UPDATE urunler
        SET
            kategori_id = ?,
            urun_adi = ?,
            fiyat = ?,
            stok = ?,
            aciklama = ?,
            resim_url = ?
        WHERE urun_id = ?
    ");

    $guncelle->execute([
        $kategori_id,
        $urun_adi,
        $fiyat,
        $stok,
        $aciklama,
        $resim_url,
        $id
    ]);

    echo "
    <div class='alert alert-success'>

        Ürün güncellendi.

    </div>
    ";

    // Ürünü tekrar çek

    $sorgu->execute([$id]);

    $urun = $sorgu->fetch(PDO::FETCH_ASSOC);
}

?>
<div class="admin-content">
    <h2 class="fw-bold mb-4">

        Ürün Düzenle

    </h2>

    <div class="card border-0 shadow">

        <div class="card-body">

            <form
                method="POST"
                enctype="multipart/form-data">

                <!-- Kategori -->

                <div class="mb-3">

                    <label class="form-label">

                        Kategori

                    </label>

                    <select
                        name="kategori_id"
                        class="form-select"
                        required>

                        <?php foreach ($kategoriler as $kategori) { ?>

                            <option
                                value="<?= $kategori["kategori_id"] ?>"

                                <?= $urun["kategori_id"] == $kategori["kategori_id"] ? "selected" : "" ?>>

                                <?= $kategori["kategori_adi"] ?>

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
                        value="<?= $urun["urun_adi"] ?>"
                        required>

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
                        value="<?= $urun["fiyat"] ?>"
                        required>

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
                        value="<?= $urun["stok"] ?>"
                        required>

                </div>

                <!-- Açıklama -->

                <div class="mb-3">

                    <label class="form-label">

                        Açıklama

                    </label>

                    <textarea
                        name="aciklama"
                        class="form-control"
                        rows="5"><?= $urun["aciklama"] ?></textarea>

                </div>

                <!-- Mevcut Resim -->

                <div class="mb-3">

                    <label class="form-label">

                        Mevcut Resim

                    </label>

                    <br>

                    <img
                        src="../<?= $urun["resim_url"] ?>"
                        style="
                        width:120px;
                        height:120px;
                        object-fit:cover;
                    "
                        class="rounded shadow">

                </div>

                <!-- Yeni Resim -->

                <div class="mb-4">

                    <label class="form-label">

                        Yeni Resim Seç

                    </label>

                    <input
                        type="file"
                        name="resim"
                        class="form-control">

                </div>

                <!-- Buton -->

                <button
                    class="btn btn-dark">

                    Güncelle

                </button>

            </form>

        </div>

    </div>
</div>