<?php

session_start();

include "../config/baglan.php";

if(!isset($_SESSION["kullanici_id"])){

    die("Giriş yapmalısınız.");

}

$urun_id = intval($_POST["urun_id"]);

$puan = intval($_POST["puan"]);

$yorum = trim($_POST["yorum"]);

$ekle = $db->prepare("
    INSERT INTO yorumlar
    (
        urun_id,
        kullanici_id,
        puan,
        yorum
    )
    VALUES
    (
        ?,
        ?,
        ?,
        ?
    )
");

$ekle->execute([

    $urun_id,

    $_SESSION["kullanici_id"],

    $puan,

    $yorum

]);

header("Location: urun_detay.php?id=".$urun_id);
exit;