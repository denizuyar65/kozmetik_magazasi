<?php

include "../config/baglan.php";
include "../includes/header.php";
include "../includes/menu.php";

if(!isset($_SESSION["kullanici_id"])){
    header("Location: giris.php");
    exit;
}

$kullanici_id = $_SESSION["kullanici_id"];

// Sepeti çek
$sorgu = $db->prepare("
    SELECT 
        sd.adet,
        u.urun_id,
        u.urun_adi,
        u.fiyat,
        u.stok
    FROM sepet_detaylari sd
    INNER JOIN sepet s ON sd.sepet_id = s.sepet_id
    INNER JOIN urunler u ON sd.urun_id = u.urun_id
    WHERE s.kullanici_id = ?
");

$sorgu->execute([$kullanici_id]);
$urunler = $sorgu->fetchAll(PDO::FETCH_ASSOC);

if(count($urunler) == 0){
    echo "<div class='container mt-5'><div class='alert alert-info'>Sepet boş</div></div>";
    include "../includes/footer.php";
    exit;
}

$toplam = 0;

foreach($urunler as $u){
    $toplam += $u["fiyat"] * $u["adet"];
}

$mesaj = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $kart_isim = trim($_POST["kart_isim"]);
    $kart_no = trim($_POST["kart_no"]);
    $sk_t = trim($_POST["sk_t"]);
    $cvv = trim($_POST["cvv"]);

    if(empty($kart_isim) || empty($kart_no) || empty($sk_t) || empty($cvv)){
        $mesaj = "Tüm alanları doldurun.";
    }else{

        // 1. Sipariş oluştur
        $siparis = $db->prepare("
            INSERT INTO siparisler (kullanici_id, toplam_tutar)
            VALUES (?, ?)
        ");
        $siparis->execute([$kullanici_id, $toplam]);

        $siparis_id = $db->lastInsertId();

        // 2. Sipariş detaylarını ekle + stok düş
        foreach($urunler as $u){

            $detay = $db->prepare("
                INSERT INTO siparis_detaylari
                (siparis_id, urun_id, adet, birim_fiyat)
                VALUES (?, ?, ?, ?)
            ");

            $detay->execute([
                $siparis_id,
                $u["urun_id"],
                $u["adet"],
                $u["fiyat"]
            ]);

            // stok düş
            $stok = $db->prepare("
                UPDATE urunler
                SET stok = stok - ?
                WHERE urun_id = ?
            ");

            $stok->execute([
                $u["adet"],
                $u["urun_id"]
            ]);
        }

        // 3. Sepeti temizle
        $temizle = $db->prepare("
            DELETE sd FROM sepet_detaylari sd
            INNER JOIN sepet s ON sd.sepet_id = s.sepet_id
            WHERE s.kullanici_id = ?
        ");

        $temizle->execute([$kullanici_id]);

        header("Location: odeme_basarili.php");
        exit;
    }
}

?>

<div class="container mt-5">

    <h2>Ödeme</h2>

    <h4 class="mb-4">Toplam: ₺<?= $toplam ?></h4>

    <?php if($mesaj != ""): ?>
        <div class="alert alert-danger"><?= $mesaj ?></div>
    <?php endif; ?>

    <form method="POST">

        <input class="form-control mb-2" name="kart_isim" placeholder="Kart Üzerindeki İsim">

        <input class="form-control mb-2" name="kart_no" placeholder="Kart Numarası">

        <input class="form-control mb-2" name="sk_t" placeholder="SKT">

        <input class="form-control mb-2" name="cvv" placeholder="CVV">

        <button class="btn btn-dark w-100">
            Ödemeyi Tamamla
        </button>

    </form>

</div>

<?php include "../includes/footer.php"; ?>