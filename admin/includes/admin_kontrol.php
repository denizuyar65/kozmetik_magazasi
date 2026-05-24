<?php

if(
    !isset($_SESSION["admin_id"])
    ||
    !isset($_SESSION["admin_rol"])
    ||
    $_SESSION["admin_rol"] != "admin"
){

    header("Location: giris.php");
    exit;

}