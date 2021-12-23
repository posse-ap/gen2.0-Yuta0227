<?php
//データベースへ接続
$dsn = "mysql:dbname=quizy;host=localhost;charset=utf8mb4";
$username = "yuta";
$password = "2884Hyuta";
$driver_options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false,
];
$pdo = new PDO($dsn, $username, $password, $driver_options);
if (@$_POST["id"] != "" or @$_POST["user_name"] != "") { //IDおよびユーザー名の入力有無を確認
    $stmt = $pdo->query("SELECT * FROM user_list WHERE ID='" . $_POST["id"] . "' OR Name LIKE  '%" . $_POST["user_name"] . "%')"); //SQL文を実行して、結果を$stmtに代入する。
}
?>
<html>
<!-- 以下省略 -->