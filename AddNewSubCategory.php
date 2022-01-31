<?php

require_once( "db.php" );
require_once( "lib.php" );

dbConnect(ConfigFile);
$dataBaseName = $GLOBALS['configDataBase']->db;

$nome = $_GET["nome"];
$idCategoria = $_GET["idCategoria"];


$queryString = "SELECT * FROM `$dataBaseName`.`subcategoria` WHERE `nome`=$nome";

$queryResult = mysqli_query($GLOBALS['ligacao'], $queryString);

if ($queryResult) {
    echo -1;
} else {

    $queryInsertNew = "INSERT INTO `$dataBaseName`.`subcategoria` (`idCategoria`, `nome`) VALUES ('$idCategoria','$nome')";
    $queryResult = mysqli_query($GLOBALS['ligacao'], $queryInsertNew);
    if ($queryResult) {
        echo $idCategoria;
    } else {
        echo -1;
    }
}
?>

