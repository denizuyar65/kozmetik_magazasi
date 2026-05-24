<?php
session_start();
include "includes/admin_kontrol.php";
include "includes/oturum_kontrol.php";

session_start();

// Admin giriş yapmamışsa login'e gönder

if(!isset($_SESSION["admin"])){

    header("Location: giris.php");
    exit;

}

header("Location: dashboard.php");
exit;