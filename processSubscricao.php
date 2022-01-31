<?php

require_once( "db.php" );
require_once( "lib.php" );

dbConnect(ConfigFile);
$dataBaseName = $GLOBALS['configDataBase']->db;

$subcricao = $_GET["subscricao"];
$idSubscritor = $_GET["idSubscritor"];
$idPublicador = $_GET["idPublicador"];



#Unfollow
if ($subcricao == 0) {
    $queryString = "DELETE FROM `$dataBaseName`.`subscricao_utilizador` WHERE idSubscritor = $idSubscritor AND idPublicador = $idPublicador";
}
#Follow
else {
    $queryString = "INSERT INTO `$dataBaseName`.`subscricao_utilizador`(`idSubscritor`, `idPublicador`) VALUES ($idSubscritor, $idPublicador)";
}


$queryResult = mysqli_query($GLOBALS['ligacao'], $queryString);

if ($queryResult) {

    echo "true";
} else {
    echo "false";
}
?>
