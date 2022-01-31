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
    $ativo = filter_input( $_INPUT_METHOD, 'ativo', FILTER_SANITIZE_STRING, $flags);
    
    
    if($ativo == 1){
        $ativo = 0;
    }
    else{
        $ativo = 1;
    }
    
    $queryString = "UPDATE `smi_final`.`conteudo` SET publico = $ativo WHERE idConteudo = $idCont";
    $queryResult = mysqli_query( $GLOBALS['ligacao'], $queryString );
    
    $serverName = filter_input( INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_STRING, $flags);
    $serverPort = 80;
    $name = webAppName();
    $baseUrl = "http://" . $serverName . ":" . $serverPort;
    $baseNextUrl = $baseUrl . $name;
    $nextUrl = "contentManagement.php";

    header( "Location: " . $baseNextUrl . $nextUrl );