<?php
require_once( "lib.php" );
require_once( "db.php" );

session_start();

if(isset($_SESSION['username'])){
      $user = $_SESSION['username'];
      $id = $_SESSION['id'];
      $userType = $_SESSION['userType'];
}


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

$password = filter_input($_INPUT_METHOD, 'password', FILTER_SANITIZE_STRING, $flags);

dbConnect( ConfigFile );
$dataBaseName = $GLOBALS['configDataBase']->db;
mysqli_select_db( $GLOBALS['ligacao'], $dataBaseName );

$queryString = "UPDATE `$dataBaseName`.`utilizador` SET `pword` = '$password' WHERE `idUtilizador` = '$id'";
$queryResult = mysqli_query( $GLOBALS['ligacao'], $queryString);

$serverName = filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_STRING, $flags);
$serverPort = 80;
$name = webAppName();
$baseUrl = "http://" . $serverName . ":" . $serverPort;
$baseNextUrl = $baseUrl . $name;


$nextUrl = "ConfiguracaoPerfil.php";
header("Location: " . $baseNextUrl . $nextUrl);