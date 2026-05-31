<?php
session_start();

include "includes/admin_kontrol.php";
include "../config/baglan.php";

$id = intval($_GET["id"]);

$sorgu = $db->prepare("
DELETE FROM yorumlar
WHERE yorum_id=?
");

$sorgu->execute([$id]);

header("Location: yorumlar.php");
exit;
