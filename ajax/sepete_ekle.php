<?php

include "../config/baglan.php";
include "../includes/session.php";

// Giriş kontrolü
if(!isset($_SESSION["kullanici_id"])){

    header("Location: ../sayfalar/giris.php");
    exit;

}

$kullanici_id = $_SESSION["kullanici_id"];

$urun_id = $_GET["urun_id"];

// Kullanıcının sepeti var mı?
$sepetSorgu = $db->prepare("
    SELECT * FROM sepet
    WHERE kullanici_id = ?
");

$sepetSorgu->execute([$kullanici_id]);

$sepet = $sepetSorgu->fetch(PDO::FETCH_ASSOC);

// Sepet yoksa oluştur
if(!$sepet){

    $olustur = $db->prepare("
        INSERT INTO sepet(kullanici_id)
        VALUES(?)
    ");

    $olustur->execute([$kullanici_id]);

    $sepet_id = $db->lastInsertId();

}else{

    $sepet_id = $sepet["sepet_id"];

}

// Ürün sepette var mı?
$kontrol = $db->prepare("
    SELECT * FROM sepet_detaylari
    WHERE sepet_id = ?
    AND urun_id = ?
");

$kontrol->execute([
    $sepet_id,
    $urun_id
]);

$urun = $kontrol->fetch(PDO::FETCH_ASSOC);

// Varsa adet artır
if($urun){

    $guncelle = $db->prepare("
        UPDATE sepet_detaylari
        SET adet = adet + 1
        WHERE sepet_detay_id = ?
    ");

    $guncelle->execute([
        $urun["sepet_detay_id"]
    ]);

}else{

    // Yoksa ekle
    $ekle = $db->prepare("
        INSERT INTO sepet_detaylari
        (
            sepet_id,
            urun_id,
            adet
        )
        VALUES
        (?, ?, 1)
    ");

    $ekle->execute([
        $sepet_id,
        $urun_id
    ]);

}

$_SESSION["basarili"] = "Ürün sepete eklendi.";

header("Location: " . $_SERVER["HTTP_REFERER"]);
exit;