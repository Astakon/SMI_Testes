<?php

require_once( "db.php" );
require_once( "lib.php" );

dbConnect( ConfigFile );
$dataBaseName = $GLOBALS['configDataBase']->db;
mysqli_select_db( $GLOBALS['ligacao'], $dataBaseName );

$ids = array();
$paths = array();

if(!empty($_POST['check_list'])) {
    foreach($_POST['check_list'] as $check) {
        array_push($ids,$check);
    }
}


for($i = 0; $i < count($ids); $i++){
    $queryString = "SELECT * FROM `smi_final`.`conteudo` WHERE idConteudo = $ids[$i]";
    $queryResult = mysqli_query( $GLOBALS['ligacao'], $queryString );
    
    if($queryResult){
        while ($registo = mysqli_fetch_array($queryResult)) {
            $path = $registo['path'];
            array_push($paths,$path);
        }
    }
}

$zip = new ZipArchive;
$tmp_file = 'myzip.zip';
if ($zip->open($tmp_file,  ZipArchive::CREATE)) {
    for($x = 0; $x < count($paths); $x++){
        $zip->addFile($paths[$x], $paths[$x]);
    }
    $zip->close();
    header('Content-disposition: attachment; filename=files.zip');
    header('Content-type: application/zip');
    readfile($tmp_file);
    
    if(file_exists('myzip.zip')){
        unlink('myzip.zip');
    }   
    
} else {
    echo 'Failed!';
}

$serverName = filter_input( INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_STRING, $flags);
$serverPort = 80;
$name = webAppName();
$baseUrl = "http://" . $serverName . ":" . $serverPort;
$baseNextUrl = $baseUrl . $name;
$nextUrl = "downloadManagement.php";

header( "Location: " . $baseNextUrl . $nextUrl );