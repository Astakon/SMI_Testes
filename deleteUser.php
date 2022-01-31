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
    
    $idUser = filter_input( $_INPUT_METHOD, 'idUser', FILTER_SANITIZE_STRING, $flags);
    
    
    $queryString = "SELECT * FROM `smi_final`.`conteudo` WHERE idUtilizador = $idUser";
    
    $queryResult = mysqli_query( $GLOBALS['ligacao'], $queryString );

    if ( $queryResult ) {
        while ($registo = mysqli_fetch_array($queryResult)) {
            $idCont = $registo['idConteudo'];
            
            $queryStringLig = "DELETE FROM `smi_final`.`conteudo_sub_categoria` WHERE idConteudo = $idCont";
            $queryStringCom = "DELETE FROM `smi_final`.`comentario` WHERE idConteudo = $idCont";
            $queryStringNot = "DELETE FROM `smi_final`.`notificacao` WHERE idConteudo = $idCont";
            $queryStringCla = "DELETE FROM `smi_final`.`classificacao` WHERE idConteudo = $idCont";
            $queryString = "DELETE FROM `smi_final`.`conteudo` WHERE idConteudo = $idCont";

            mysqli_query( $GLOBALS['ligacao'], $queryStringLig );
            mysqli_query( $GLOBALS['ligacao'], $queryStringNot );
            mysqli_query( $GLOBALS['ligacao'], $queryStringCom );
            mysqli_query( $GLOBALS['ligacao'], $queryStringCla );
            mysqli_query( $GLOBALS['ligacao'], $queryString );
        }
    }
    
    $queryStringCome = "DELETE FROM `smi_final`.`comentario` WHERE idUtilizador = $idUser";
    $queryStringClass = "DELETE FROM `smi_final`.`classificacao` WHERE idUtilizador = $idUser";
    $queryStringSubCat = "DELETE FROM `smi_final`.`subscricao_categoria` WHERE idSubscritor = $idUser";
    $queryStringNot = "DELETE FROM `smi_final`.`notificacao` WHERE idUtilizador = $idUser";
    $queryStringSubUsr = "DELETE FROM `smi_final`.`subscricao_utilizador` WHERE idSubscritor = $idUser";
    
    $queryStringFinal = "DELETE FROM `smi_final`.`utilizador` WHERE idUtilizador = $idUser";
    
    mysqli_query( $GLOBALS['ligacao'], $queryStringCome );
    mysqli_query( $GLOBALS['ligacao'], $queryStringClass );
    mysqli_query( $GLOBALS['ligacao'], $queryStringSubCat );
    mysqli_query( $GLOBALS['ligacao'], $queryStringSubUsr );
    mysqli_query( $GLOBALS['ligacao'], $queryStringNot );
    
    mysqli_query( $GLOBALS['ligacao'], $queryStringFinal );
    
    $serverName = filter_input( INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_STRING, $flags);
    $serverPort = 80;
    $name = webAppName();
    $baseUrl = "http://" . $serverName . ":" . $serverPort;
    $baseNextUrl = $baseUrl . $name;
    $nextUrl = "userManagement.php";

    header( "Location: " . $baseNextUrl . $nextUrl );
    