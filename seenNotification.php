<?php

    require_once( "db.php" );
    require_once( "lib.php" );

    dbConnect(ConfigFile);
    $dataBaseName = $GLOBALS['configDataBase']->db;

    $idCont = $_GET["idCont"];
    $idUser = $_GET["idUser"];

    $queryString = "UPDATE `$dataBaseName`.`notificacao` SET `seen` = '1' WHERE `idConteudo`='$idCont' AND `idUtilizador` = '$idUser'";

    mysqli_query($GLOBALS['ligacao'], $queryString);


    $serverName = filter_input( INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_STRING, $flags);
    $serverPort = 80;
    $name = webAppName();
    $baseUrl = "http://" . $serverName . ":" . $serverPort;
    $baseNextUrl = $baseUrl . $name;
    $nextUrl = "Notificacoes.php";

    header( "Location: " . $baseNextUrl . $nextUrl );
