<?php

session_start();

include "../config/baglan.php";

$id = intval($_GET["id"]);

$sorgu = $db->prepare("
    SELECT *
    FROM yorumlar
    WHERE yorum_id = ?
");

$sorgu->execute([$id]);

$yorum = $sorgu->fetch(PDO::FETCH_ASSOC);

if (
    $yorum
    &&
    $yorum["kullanici_id"]
    ==
    $_SESSION["kullanici_id"]
) {

    $sil = $db->prepare("
        DELETE FROM yorumlar
        WHERE yorum_id = ?
    ");

    $sil->execute([$id]);
}

header(
    "Location: urun_detay.php?id="
        . $yorum["urun_id"]
);

exit;
