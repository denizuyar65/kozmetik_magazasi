<?php

session_start();
include "includes/admin_kontrol.php";
include "../config/baglan.php";

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

// Resmi sil

if(
    !empty($urun["resim_url"])
){

    $dosya =
        "../" .
        $urun["resim_url"];

    if(file_exists($dosya)){

        unlink($dosya);

    }

}

// Veritabanından sil

$sil = $db->prepare("
    DELETE FROM urunler
    WHERE urun_id = ?
");

$sil->execute([$id]);

// Geri dön

header("Location: urunler.php");

exit;