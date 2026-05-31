<?php

session_start();

include "../config/baglan.php";

if (isset($_GET["id"])) {

    $id = intval($_GET["id"]);

    $sil = $db->prepare("
        DELETE FROM sepet_detaylari
        WHERE sepet_detay_id = ?
    ");

    $sil->execute([$id]);
}

header("Location: /kozmetik_magazasi/sayfalar/sepet.php");

exit;
