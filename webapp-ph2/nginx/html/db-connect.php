<?php
define('HOSTNAME','db');
define('DATABASE','webapp');
define('USERNAME','yuta');
define('PASSWORD','secret');
$dsn = 'mysql:dbname='.DATABASE.';port=3306;host='.HOSTNAME.';charset=utf8';
$user = USERNAME;
$password = PASSWORD;

try{
    $dbh = new PDO($dsn, $user, $password,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES=>false    
    ]
);
}catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
}
?>