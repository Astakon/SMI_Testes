<?php
require_once( "lib.php" );
require_once( "db.php" );

$field = $_POST['field'];
$value = $_POST['value'];

echo existUserField($field,$value);
die;
