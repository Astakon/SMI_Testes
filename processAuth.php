<?php
   require_once( "lib.php" );
   require_once( "db.php" );

   $username = $_GET[ "name" ];
   
   $nextUrl = "formLogin.php";
   dbConnect( ConfigFile );
   $dataBaseName = $GLOBALS['configDataBase']->db;
   mysqli_select_db( $GLOBALS['ligacao'], $dataBaseName );
   
   $queryString = "UPDATE `$dataBaseName`.`utilizador` SET `ativo` = 1 WHERE `username` = '$username'";

   $queryResult = mysqli_query( $GLOBALS['ligacao'], $queryString);
   
  
   echo "Authentification Done Please Login Again!";
  
   $serverName = filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_STRING, $flags);

   $serverPort = 80;

   $name = webAppName();

   $baseUrl = "http://" . $serverName . ":" . $serverPort;

   $baseNextUrl = $baseUrl . $name;
   
   dbDisconnect();

   header("Location: " . $baseNextUrl . $nextUrl);
?>

