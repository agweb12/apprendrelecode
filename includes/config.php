<?php
ob_start(); //turns on output buffering
session_start();

date_default_timezone_set("Europe/Paris");

try {
    $connection = new PDO("mysql:dbname=metmaticom;host=localhost","root","");
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
} catch (PDOException $e) {
    exit("Connection Echec :" . $e->getMessage());
}