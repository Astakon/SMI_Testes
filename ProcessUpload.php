<?php

require_once( "lib.php" );
require_once( "db.php" );
session_start();

$flags[] = FILTER_NULL_ON_FAILURE;

$method = filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_STRING, $flags);

if ($method == 'POST') {
    $_INPUT_METHOD = INPUT_POST;
} elseif ($method == 'GET') {
    $_INPUT_METHOD = INPUT_GET;
} else {
    echo "Invalid HTTP method (" . $method . ")";
    exit();
}


$_title = filter_input($_INPUT_METHOD, 'title', FILTER_SANITIZE_STRING, $flags);
$_description = filter_input($_INPUT_METHOD, 'description', FILTER_SANITIZE_STRING, $flags);
$_idTipoConteudo = filter_input($_INPUT_METHOD, 'tipoConteudo', FILTER_SANITIZE_STRING, $flags);
$_category = filter_input($_INPUT_METHOD, 'categories', FILTER_SANITIZE_STRING, $flags);
$_subcategory = filter_input($_INPUT_METHOD, 'subcategories', FILTER_SANITIZE_STRING, $flags);
$_idIdioma = filter_input($_INPUT_METHOD, 'idioma', FILTER_SANITIZE_STRING, $flags);
$_publico = filter_input($_INPUT_METHOD, 'publico', FILTER_SANITIZE_STRING, $flags);

$idUser = $_SESSION["id"];



$ServerName = filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_STRING, $flags);
$ServerPort = filter_input(INPUT_SERVER, 'SERVER_PORT', FILTER_SANITIZE_STRING, $flags);

$title = addslashes($_title);
$idIdioma = addslashes($_idIdioma);
$idTipoConteudo = addslashes($_idTipoConteudo);
$description = addslashes($_description);
$category = addslashes($_category);
$subcategory = addslashes($_subcategory);
$idioma = addslashes($_idIdioma);
$publico = addslashes($_publico);

$serverName = filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_STRING, $flags);

$serverPort = 80;

$name = webAppName();

$baseUrl = "http://" . $serverName . ":" . $serverPort;

$baseNextUrl = $baseUrl . $name;


if($publico == "true"){
    $publico = 1;
}else{
    $publico = 0;
}

dbConnect(ConfigFile);

$dataBaseName = $GLOBALS['configDataBase']->db;

mysqli_select_db($GLOBALS['ligacao'], $dataBaseName);

set_time_limit(300);

if (isset($_FILES['fileUpload'])) {

    $fileUpload = $_FILES['fileUpload']['name'];
}
$thumbnailUpload = $_FILES['thumbnailUpload']['name'];

if ($idTipoConteudo == 2) {
    $thumbnailUpload = $fileUpload;
}


$target_dir = "imagesDataBase/";
$target_file = $target_dir . basename($fileUpload[0]);

$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

move_uploaded_file($fileUpload[0], $target_file);

$target_thumb = $target_dir . basename($thumbnailUpload[0]);

$imageFileType = strtolower(pathinfo($target_thumb, PATHINFO_EXTENSION));

move_uploaded_file($thumbnailUpload[0], $target_thumb);

$queryInsertNew = "INSERT INTO `$dataBaseName`.`conteudo`
        (`idUtilizador`,`idTipoConteudo`, `idTipoIdioma`,`titulo` ,`descricao`, `path`,`thumbnailPath`, `dataHora`, `classificacao`, `publico`) values  
        ('$idUser','$idTipoConteudo', '$idIdioma','$title' ,'$description', '$target_file', '$target_thumb', CURRENT_TIMESTAMP(), 0, '$publico')";


if (mysqli_query($GLOBALS['ligacao'], $queryInsertNew) === false) {
    echo "Error inserting in ProcessUpload.php";
} else {
  
    $lastId = mysqli_insert_id($GLOBALS['ligacao']);
    $queryInsertNew = "INSERT INTO `$dataBaseName`.`conteudo_sub_categoria`
        (`idConteudo`, `idSubCategoria`) values  
        ('$lastId', '$subcategory')";
    
    if(mysqli_query($GLOBALS['ligacao'], $queryInsertNew) === false){
        echo "Error inserting in ProcessUpload.php";
    } else {
        $queryGetUserSubs = "SELECT * FROM `$dataBaseName`.`subscricao_utilizador` WHERE idPublicador = $idUser";
        $queryGetCatSubs = "SELECT * FROM `$dataBaseName`.`subscricao_categoria` WHERE idCategoria = $category";
        
        $queryResult = mysqli_query( $GLOBALS['ligacao'], $queryGetUserSubs );
        
        if ( $queryResult ) {
            while ($registo = mysqli_fetch_array($queryResult)) {
                $idUserSubbed = $registo['idSubscritor'];
                
                $queryNot = "INSERT INTO `$dataBaseName`.`notificacao` (idUtilizador,idConteudo) VALUES ('$idUserSubbed','$lastId')";
                mysqli_query( $GLOBALS['ligacao'], $queryNot );
            }
        }
        
        $queryResult2 = mysqli_query( $GLOBALS['ligacao'], $queryGetCatSubs );
        
        if ( $queryResult2 ) {
            while ($registo = mysqli_fetch_array($queryResult2)) {
                $idUserSubbed = $registo['idSubscritor'];
                
                $queryNot = "INSERT INTO `$dataBaseName`.`notificacao` (idUtilizador,idConteudo) VALUES ('$idUserSubbed','$lastId')";
                mysqli_query( $GLOBALS['ligacao'], $queryNot );
            }
        }
    }
}


dbDisconnect();
$nextUrl = "contentManagement.php";
header("Location: " . $baseNextUrl . $nextUrl);
?>