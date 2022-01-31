<?php
require_once( "lib.php" );
require_once( "db.php" );
require_once( "lib-mail-v2.php" );

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

$username = filter_input($_INPUT_METHOD, 'username', FILTER_SANITIZE_STRING, $flags);
$password = filter_input($_INPUT_METHOD, 'password', FILTER_SANITIZE_STRING, $flags);
$passwordConfirm = filter_input($_INPUT_METHOD, 'passwordConfirm', FILTER_SANITIZE_STRING, $flags);
$email = filter_input($_INPUT_METHOD, 'email', FILTER_SANITIZE_STRING, $flags);
$date = filter_input($_INPUT_METHOD, 'nascimento', FILTER_SANITIZE_STRING, $flags);
$desc = filter_input($_INPUT_METHOD, 'description', FILTER_SANITIZE_STRING, $flags);

$serverName = filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_STRING, $flags);

$serverPort = 80;

$name = webAppName();

$baseUrl = "http://" . $serverName . ":" . $serverPort;

$baseNextUrl = $baseUrl . $name;

//$idUser = isValid($username, $password, "basic");
$userAlreadyExists = existUserField("username", $username, "utilizador");

$emailAlreadyExists = existUserField("email", $email);

echo "<h2>" . $username . "</h2>";

if ($password != $passwordConfirm) {
    $nextUrl = "formRegister.php";
} 
if ($userAlreadyExists || $emailAlreadyExists) {
    $nextUrl = "formRegister.php";
    
} else {
    $nextUrl = "formLogin.php";
    dbConnect( ConfigFile );
    $dataBaseName = $GLOBALS['configDataBase']->db;
    mysqli_select_db( $GLOBALS['ligacao'], $dataBaseName );
    
    $srcName = $_FILES['fileUpload']['name'];
    $target_dir = "imagesDataBase/";
    $target_file = $target_dir . basename($_FILES["fileUpload"]["name"]);

    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $target_file);
    
    $queryString = "INSERT INTO `$dataBaseName`.`utilizador` (`idTipoUtilizador`,`username`,`email`,`pword`,`descricao`,`data_nascimento`,`path`,`ativo`) VALUES(1,'$username', '$email','$password', '$desc','$date','$target_file', 0)";
    #echo $queryString;
    $queryResult = mysqli_query( $GLOBALS['ligacao'], $queryString);

    
    
    
    //EMAIL SENDING 
    $Account = 1;
    $ToName = $username;
    $ToEmail = $email;
    $Subject = "Please verify your email - Game Along";
    $Message = "https://localhost/examples-smi/SMI_Testes/processAuth.php?name=$username";
    
    dbConnect( ConfigFile );
                

    mysqli_select_db( $GLOBALS['ligacao'], $dataBaseName );

    $queryString2 = "SELECT * FROM `$dataBaseName`.`emailaccounts` WHERE `id`='$Account'";
    $queryResult2 = mysqli_query( $GLOBALS['ligacao'], $queryString2 );
    $record = mysqli_fetch_array( $queryResult2 );
        
    $smtpServer = $record[ 'smtpServer' ];
    $port = intval( $record[ 'port' ] );
    $useSSL = boolval( $record[ 'useSSL' ] );
    $timeout = intval( $record[ 'timeout' ] );
    $loginName = $record[ 'loginName' ];
    $password = $record[ 'password' ];
    $fromEmail = $record[ 'email' ];
    $fromName = $record[ 'displayName' ];
    
    mysqli_free_result( $queryResult2 );
    $Debug = FALSE;
    
    $result = sendAuthEmail(
            $smtpServer,
            $useSSL,
            $port,
            $timeout,
            $loginName,
            $password,
            $fromEmail,
            $fromName,
            $ToName . " <" . $ToEmail . ">",
            NULL,
            NULL,
            $Subject,
            $Message,
            $Debug,
            NULL );
    
    echo $result;
    

    dbDisconnect();
}

header("Location: " . $baseNextUrl . $nextUrl);
?>