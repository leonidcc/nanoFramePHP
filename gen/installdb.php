<?php

// php gen/crud.php test name:string price:float valor:int
include 'core/conexion.class.php';
include 'config.php';

$file = "./Template.sql";
$fp = fopen($file, "r");
$contents = fread($fp, filesize($file));

$db->consult($contents,[]);


 ?>
