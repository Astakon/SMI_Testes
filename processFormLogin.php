<?php
    require_once( "lib.php" );
    require_once( "db.php" );
    
    $flags[] = FILTER_NULL_ON_FAILURE;
    
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
    $flags[] = FILTER_NULL_ON_FAILURE;

    $username = filter_input( $_INPUT_METHOD, 'username', FILTER_SANITIZE_STRING, $flags);
    $password = filter_input( $_INPUT_METHOD, 'password', FILTER_SANITIZE_STRING, $flags);

    $serverName = filter_input( INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_STRING, $flags);

    $serverPort = 80;

    $name = webAppName();

    $baseUrl = "http://" . $serverName . ":" . $serverPort;

    $baseNextUrl = $baseUrl . $name;

    $idUser = isValid($username, $password, "utilizador");
    session_start();
    if ( $idUser>0 ) {
        
        $_SESSION['username'] = $username;
        $_SESSION['id'] = $idUser;
        $_SESSION['login'] = TRUE;
        $_SESSION['userType'] = getUserType($username);
        if (isset($_SESSION['locationAfterAuth'])) {
            $baseNextUrl = $baseUrl;
            $nextUrl = $_SESSION['locationAfterAuth'];
        } else {
            
            $nextUrl = "feed.php";
        }
    } else {
        $_SESSION['error'] = "O nome de utilizador ou palavra passe estão incorretos!";
        $nextUrl = "formLogin.php";
        
    }
    header( "Location: " . $baseNextUrl . $nextUrl );
?>