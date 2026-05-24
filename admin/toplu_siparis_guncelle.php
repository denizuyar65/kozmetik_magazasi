<?php

session_start();
include "includes/admin_kontrol.php";
include "../config/baglan.php";

if(
    isset($_POST["siparisler"])
    &&
    count($_POST["siparisler"]) > 0
){

    $durum = $_POST["yeni_durum"];

    $guncelle = $db->prepare("
        UPDATE siparisler
        SET siparis_durumu = ?
        WHERE siparis_id = ?
    ");

    foreach($_POST["siparisler"] as $id){

        $guncelle->execute([
            $durum,
            $id
        ]);

    }

}

header("Location: siparisler.php");
exit;