<?php

require_once( "db.php" );
require_once( "lib.php" );

dbConnect(ConfigFile);
$dataBaseName = $GLOBALS['configDataBase']->db;

$comentario = $_GET["comentario"];
$apagar_adicionar = $_GET["apagar_adicionar"];
$idUtilizador = $_GET["idUtilizador"];
$idConteudo = $_GET["idConteudo"];
$idComentario = $_GET["idComentario"];

if ($apagar_adicionar == 0) {
    $queryComentario = "DELETE FROM `$dataBaseName`.`comentario` WHERE idComentario = $idComentario";
    $comentarioResult = mysqli_query($GLOBALS['ligacao'], $queryComentario);
} else {
    $queryComentario = "INSERT INTO `$dataBaseName`.`comentario`(`idUtilizador`, `idConteudo`, `texto`, `publico`) VALUES ($idUtilizador,$idConteudo,'$comentario',true)";
    $comentarioResult = mysqli_query($GLOBALS['ligacao'], $queryComentario);
}



if ($comentarioResult) {
    echo $idComentario;
} else {
    echo $idComentario;
    exit();
}
?>