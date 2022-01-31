<?php

require_once( "db.php" );
require_once( "lib.php" );


dbConnect(ConfigFile);
$dataBaseName = $GLOBALS['configDataBase']->db;

$category = $_GET["category"];

$queryString = "SELECT `idSubCategoria`, `idCategoria`, `nome` FROM `$dataBaseName`.`subcategoria` WHERE `idCategoria`=$category";

$queryResult = mysqli_query($GLOBALS['ligacao'], $queryString);

if ($queryResult) {


    while ($registo = mysqli_fetch_array($queryResult)) {
        $result[] = array(
            'idSubCategoria' => $registo['idSubCategoria'],
            'nome' => $registo['nome']);
    }
} else {
    $errDesc = mysqli_error($GLOBALS['ligacao']);
    $errNumber = mysqli_errno($GLOBALS['ligacao']);

    $result[] = array(
        'idSubCategoria' => -1,
        'nome' => "No subcategories Available");
    $result[] = array(
        'idSubCategoria' => -$errNumber,
        'nome' => $errDesc);
}

echo json_encode($result);
?>
