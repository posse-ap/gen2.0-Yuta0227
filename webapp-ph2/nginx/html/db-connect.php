<?php
$dsn = 'mysql: dbname=webapp; port=3306; host=172.30.0.2; charset=utf8;';
$user = 'root';
$password = 'secret';

try{
    $dbh = new PDO($dsn, $user, $password);
    echo '接続完了';
}catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
}
?>