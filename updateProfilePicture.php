<?php
session_start();
require_once( "lib.php" );
require_once( "db.php" );

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

$serverName = filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_STRING, $flags);
$serverPort = 80;
$name = webAppName();
$baseUrl = "http://" . $serverName . ":" . $serverPort;
$baseNextUrl = $baseUrl . $name;

dbConnect( ConfigFile );
$dataBaseName = $GLOBALS['configDataBase']->db;
mysqli_select_db( $GLOBALS['ligacao'], $dataBaseName );

$srcName = $_FILES['fileUpload']['name'];
$target_dir = "imagesDataBase/";
$target_file = $target_dir . basename($_FILES["fileUpload"]["name"]);

$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $target_file);

$queryString = "UPDATE `$dataBaseName`.`utilizador` SET `path` = '$target_file' WHERE `idUtilizador` = '$id'";

$queryResult = mysqli_query( $GLOBALS['ligacao'], $queryString);

$nextUrl = "ConfiguracaoPerfil.php";
header("Location: " . $baseNextUrl . $nextUrl);