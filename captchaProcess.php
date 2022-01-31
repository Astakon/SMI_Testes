<?php

session_start();

header( 'Content-Type: text/html; charset=utf-8' );

if ($_SESSION['captcha'] == $_POST['captcha']) {
    echo 0;
}
else {
    echo 1;
}
?>