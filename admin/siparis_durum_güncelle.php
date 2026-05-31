<?php

session_start();
include "includes/admin_kontrol.php";
include "../config/baglan.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $siparis_id = intval($_POST["siparis_id"]);

    $durum = $_POST["siparis_durumu"];

    $guncelle = $db->prepare("
        UPDATE siparisler
        SET siparis_durumu = ?
        WHERE siparis_id = ?
    ");

    $guncelle->execute([
        $durum,
        $siparis_id
    ]);
}

header("Location: siparisler.php");
exit;
