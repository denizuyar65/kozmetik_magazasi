<?php

include "../config/baglan.php";
include "../includes/session.php";

if(!isset($_SESSION["kullanici_id"])){

    header("Location: ../sayfalar/giris.php");
    exit;

}

$kullanici_id = $_SESSION["kullanici_id"];

$urun_id = $_GET["urun_id"];

// Ürün zaten favoride mi?

$kontrol = $db->prepare("
    SELECT * FROM favoriler
    WHERE kullanici_id = ?
    AND urun_id = ?
");

$kontrol->execute([
    $kullanici_id,
    $urun_id
]);

// Eğer yoksa ekle

if($kontrol->rowCount() == 0){

    $ekle = $db->prepare("
        INSERT INTO favoriler
        (kullanici_id, urun_id)
        VALUES (?, ?)
    ");

    $ekle->execute([
        $kullanici_id,
        $urun_id
    ]);

}

// Geldiği sayfaya geri dön

header("Location: " . $_SERVER["HTTP_REFERER"]);
exit;