<?php

$host = "localhost";
$veritabani = "kozmetik_magazasi";
$kullanici = "root";
$sifre = "";

try{

    $db = new PDO(
        "mysql:host=$host;dbname=$veritabani;charset=utf8mb4",
        $kullanici,
        $sifre
    );

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}catch(PDOException $e){

    die("Veritabanı bağlantı hatası : " . $e->getMessage());

}