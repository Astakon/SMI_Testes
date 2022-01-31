<?php

require_once( "db.php" );
require_once( "lib.php" );

dbConnect(ConfigFile);

$dataBaseName = $GLOBALS['configDataBase']->db;

$pesquisa = $_POST['pesquisa'];

$flags[] = FILTER_NULL_ON_FAILURE;
$serverName = filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_STRING, $flags);

$serverPortSSL = 443;
$serverPort = 80;

$name = webAppName();

$conteudoEspecificoUrl = "https://" . $serverName . ":" . $serverPortSSL . $name . "ConteudoEspecifico.php?id=";

$queryString = "SELECT * FROM `$dataBaseName`.`conteudo` WHERE `titulo` like '$pesquisa%'";

$queryResult = mysqli_query($GLOBALS['ligacao'], $queryString);

if ($queryResult) {

    while ($registo = mysqli_fetch_array($queryResult)) {
        $result[] = array(
            'id' => $conteudoEspecificoUrl.$registo['idConteudo'],
            'titulo' => $registo['titulo']);
    }

    echo json_encode($result);
} else {
    echo "Erro ao ler conteudos file pesquisaAjax.php";
}
?>