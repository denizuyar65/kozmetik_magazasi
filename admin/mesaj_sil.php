<?php

session_start();
include "includes/admin_kontrol.php";
include "../config/baglan.php";

$id = intval($_GET["id"]);

$sil = $db->prepare("
    DELETE FROM iletisim_mesajlari
    WHERE mesaj_id = ?
");

$sil->execute([$id]);

header("Location: mesajlar.php");
exit;
