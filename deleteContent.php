<?php

    session_start();
    $flags[] = FILTER_NULL_ON_FAILURE;
    if(isset($_SESSION['username'])){
        $user = $_SESSION['username'];
        $id = $_SESSION['id'];
        $userType = $_SESSION['userType'];  
    }
    
    require_once( "db.php" );
    require_once( "lib.php" );
    
    $method = filter_input( INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING, $flags);
    
    if ( $method=='POST') {
        $_INPUT_METHOD = INPUT_POST;
    } elseif ( $method=='GET' ) {
        $_INPUT_METHOD = INPUT_GET;
    }
    else {
        echo "Invalid HTTP method (" . $method . ")";
        exit();
    }
    dbConnect( ConfigFile );
    $dataBaseName = $GLOBALS['configDataBase']->db;
    mysqli_select_db( $GLOBALS['ligacao'], $dataBaseName );
    
    $idCont = filter_input( $_INPUT_METHOD, 'idCont', FILTER_SANITIZE_STRING, $flags);

    $queryStringLig = "DELETE FROM `smi_final`.`conteudo_sub_categoria` WHERE idConteudo = $idCont";
    $queryStringNot = "DELETE FROM `smi_final`.`notificacao` WHERE idConteudo = $idCont";
    $queryStringCom = "DELETE FROM `smi_final`.`comentario` WHERE idConteudo = $idCont";
    $queryStringCla = "DELETE FROM `smi_final`.`classificacao` WHERE idConteudo = $idCont";
    $queryString = "DELETE FROM `smi_final`.`conteudo` WHERE idConteudo = $idCont";
    
    mysqli_query( $GLOBALS['ligacao'], $queryStringLig );
    mysqli_query( $GLOBALS['ligacao'], $queryStringNot );
    mysqli_query( $GLOBALS['ligacao'], $queryStringCom );
    mysqli_query( $GLOBALS['ligacao'], $queryStringCla );
    mysqli_query( $GLOBALS['ligacao'], $queryString );
    
    
    $serverName = filter_input( INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_STRING, $flags);
    $serverPort = 80;
    $name = webAppName();
    $baseUrl = "http://" . $serverName . ":" . $serverPort;
    $baseNextUrl = $baseUrl . $name;
    $nextUrl = "contentManagement.php";

    header( "Location: " . $baseNextUrl . $nextUrl );