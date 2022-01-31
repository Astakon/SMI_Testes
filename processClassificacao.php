<?php

require_once( "db.php" );
require_once( "lib.php" );

dbConnect(ConfigFile);
$dataBaseName = $GLOBALS['configDataBase']->db;

$classificacao = $_GET["classificacao"];
$idConteudo = $_GET["idConteudo"];
$idUtilizador = $_GET["idUtilizador"];

$queryClassificaco = "SELECT * FROM `$dataBaseName`.`conteudo` WHERE idConteudo = $idConteudo";
$classificacaoResult = mysqli_query($GLOBALS['ligacao'], $queryClassificaco);

if ($classificacaoResult) {
    $currentClassificacao = mysqli_fetch_array($classificacaoResult)["classificacao"];
} else {
    echo "Erro ao ler classificacao do conteudo processClassificacao.php";
    exit();
}


$queryString = "SELECT * FROM `$dataBaseName`.`classificacao` WHERE idUtilizador = $idUtilizador AND idConteudo = $idConteudo";
$queryResult = mysqli_query($GLOBALS['ligacao'], $queryString);

if ($queryResult && mysqli_num_rows($queryResult) > 0) {
    $gostou = mysqli_fetch_array($queryResult)["gostou"];
    if ($classificacao == 1 && !$gostou) {
        $queryString = " UPDATE `$dataBaseName`.`classificacao` SET `idUtilizador`=$idUtilizador,`idConteudo`=$idConteudo,`gostou`=true "
                . "WHERE `idUtilizador`=$idUtilizador AND `idConteudo`=$idConteudo";
        $currentClassificacao += 2;
    } else if ($classificacao == -1 && $gostou) {
        $queryString = " UPDATE `$dataBaseName`.`classificacao` SET `idUtilizador`=$idUtilizador,`idConteudo`=$idConteudo,`gostou`=false "
                . "WHERE `idUtilizador`=$idUtilizador AND `idConteudo`=$idConteudo";
        $currentClassificacao -= 2;
    } else {
        $queryString = "DELETE FROM `$dataBaseName`.`classificacao` WHERE `idUtilizador`=$idUtilizador AND`idConteudo`=$idConteudo";
        if ($classificacao == 1) {
            $currentClassificacao -= 1;
        } else {
            $currentClassificacao += 1;
        }
    }
} else if ($queryResult && mysqli_num_rows($queryResult) == 0) {
    if ($classificacao == 1) {
        $queryString = "INSERT INTO `$dataBaseName`.`classificacao`(`idUtilizador`, `idConteudo`, `gostou`) VALUES ($idUtilizador, $idConteudo, true)";
        $currentClassificacao += 1;
    } else {
        $queryString = "INSERT INTO `$dataBaseName`.`classificacao`(`idUtilizador`, `idConteudo`, `gostou`) VALUES ($idUtilizador, $idConteudo, false)";
        $currentClassificacao -= 1;
    }
} else {
    echo "Erro ao ler classificacao processClassificacao.php";
    exit();
}


$editClassificacaoTableResult = mysqli_query($GLOBALS['ligacao'], $queryString);

$editClassificacaoConteudoString = "UPDATE `$dataBaseName`.`conteudo` SET `classificacao`=$currentClassificacao WHERE idConteudo = $idConteudo";

$editClassificacaoConteudoResult = mysqli_query($GLOBALS['ligacao'], $editClassificacaoConteudoString);

if ($editClassificacaoTableResult && $editClassificacaoConteudoResult) {

    echo $currentClassificacao;
} else {
    echo "Erro no ficheiro processClassificacao.php";
}
?>
