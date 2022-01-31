<?php

require_once( "db.php" );
require_once( "lib.php" );

dbConnect(ConfigFile);
$dataBaseName = $GLOBALS['configDataBase']->db;

$subcricao = $_GET["subscricao"];
$idSubscritor = $_GET["idSubscritor"];
$idCategoria = $_GET["idCategoria"];



#Unfollow
if ($subcricao == 0) {
    $queryString = "DELETE FROM `$dataBaseName`.`subscricao_categoria` WHERE idSubscritor = $idSubscritor AND idCategoria = $idCategoria";
}
#Follow
else {
    $queryString = "INSERT INTO `$dataBaseName`.`subscricao_categoria`(`idSubscritor`, `idCategoria`) VALUES ($idSubscritor, $idCategoria)";
}


$queryResult = mysqli_query($GLOBALS['ligacao'], $queryString);

if ($queryResult) {

    echo "true";
} else {
    echo "false";
}
?>
