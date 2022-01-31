<?php
    session_start();
    session_destroy();
    $_SESSION['username'] = '';
    $_SESSION['id'] = '';
    $_SESSION['login'] = FALSE;
    $_SESSION['userType'] = '';
    echo "<META HTTP-EQUIV=\"refresh\" CONTENT=\"2; URL=formLogin.php\">";
?>