<?php
$dsn = 'mysql:dbname=quizy;port=3306;host=db;charset=utf8;';
$user = 'root';
$password = 'secret';

// (1) 取得するデータのidを指定
// $id = 1;

// (2) データベースに接続
try{
    $pdo = new PDO($dsn, $user, $password,
    [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
     PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,]);
    print("phpとmysql接続成功");
}catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
}
?>