<?php

include "../config/baglan.php";
include "../includes/session.php";

if (!isset($_SESSION["kullanici_id"])) {

    header("Location: ../sayfalar/giris.php");
    exit;
}

$kullanici_id = $_SESSION["kullanici_id"];

$urun_id = $_GET["urun_id"];

// Favoriden sil

$sil = $db->prepare("
    DELETE FROM favoriler
    WHERE kullanici_id = ?
    AND urun_id = ?
");

$sil->execute([
    $kullanici_id,
    $urun_id
]);

header("Location: " . $_SERVER["HTTP_REFERER"]);
exit;
