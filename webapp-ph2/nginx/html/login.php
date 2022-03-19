<?php
session_start();
require "db-connect.php";
$manager_stmt = $dbh->query("SELECT user_name,AES_DECRYPT(`user_password`,'ENCRYPT-KEY') from users where user_id=1");
$manager_data = $manager_stmt->fetchAll();
$users_stmt = $dbh->query("SELECT * from users where user_id!=1");
$users_data = $users_stmt->fetchAll();
$password = NULL;
$username = NULL;
$new_username = NULL;
$new_password = NULL;
$new_email = NULL;
$_SESSION['user'] = NULL;
//確認用
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $decode_password = $dbh->prepare("select AES_DECRYPT(`user_password`,'ENCRYPT-KEY') from users where user_name=?;");
    $decode_password->bindValue(1, $username);
    $decode_password->execute();
    $decode_password = $decode_password->fetchAll();
    $password = $_POST['password'];
    $new_username = $_POST['new_username'];
    $new_password = $_POST['new_password'];
    $new_email = $_POST['new_email'];
    if ($new_username == null && $new_password == null) {
        if ($manager_data[0]['user_name'] == $username && $manager_data[0]["AES_DECRYPT(`user_password`,'ENCRYPT-KEY')"] == $password) {
            header("Location:http://localhost:8080/manager.php");
        } elseif ($decode_password[0]["AES_DECRYPT(`user_password`,'ENCRYPT-KEY')"] == $password) {
            $users_stmt1 = $dbh->prepare("SELECT * from users where user_name=?");
            $users_stmt1->bindValue(1, $username);
            $users_stmt1->execute();
            $users_data1 = $users_stmt1->fetchAll();
            $_SESSION['user'] = $users_data1;
            header("Location:http://localhost:8080/webapp.php");
        }
    }
    $user_exist_count = 0;
    foreach ($users_data as $user_data) {
        if ($user_data['user_name'] == $new_username || $user_data['user_password'] == $new_password || $user_data['user_email'] == $new_email) {
            $user_exist_count++;
        };
    };
    if ($username == null && $password == null && $user_exist_count == 0) {
        $add_user_stmt = $dbh->prepare("INSERT into users (user_type,user_name,user_password,user_email) values ('一般ユーザー',?,AES_ENCRYPT(?,'ENCRYPT-KEY'),?);");
        $add_user_stmt->bindValue(1, $new_username);
        $add_user_stmt->bindValue(2, $new_password);
        $add_user_stmt->bindValue(3, $new_email);
        $add_user_stmt->execute();
        $users_stmt1 = $dbh->prepare("SELECT * from users where user_name=?");
        $users_stmt1->bindValue(1, $new_username);
        $users_stmt1->execute();
        $users_data1 = $users_stmt1->fetchAll();
        $_SESSION['user'] = $users_data1;
        header("Location:http://localhost:8080/webapp.php");
    }
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body style="margin:100px;">
    <div style="text-align:center;font-size:40px;">
        ログインページ
    </div>
    <form style="margin-top:50px;" action="" method="POST">
        <div style="text-align:center;font-size:20px;">
            既存ユーザー
        </div>
        <div style="display:flex;margin-top:10px;">
            <div style="width:50%;text-align:right;">
                ユーザーネーム:
            </div>
            <div>
                <textarea type="text" oninput="value = value.replace(/[^0-9A-Za-z_]+/,'');" name="username" placeholder="ユーザーネームを入力してください"></textarea>
            </div>
        </div>
        <div style="display:flex;margin-top:10px;">
            <div style="width:50%;text-align:right;">
                パスワード:
            </div>
            <div>
                <textarea type="text" oninput="value = value.replace(/[^0-9A-Za-z_]+/,'');" name="password" placeholder="ユーザーパスワードを入力してください"></textarea>
            </div>
        </div>
        <div style="display:flex;justify-content:center;margin-top:10px;">
            <input type="submit" value="ログイン"></input>
        </div>
    </form>
    <form style="margin-top:50px;" action="" method="POST">
        <div style="text-align:center;font-size:20px;">
            新規ユーザー
        </div>
        <div style="display:flex;margin-top:10px;">
            <div style="width:50%;text-align:right;">
                ユーザーネーム:
            </div>
            <div style="width:50%;">
                <textarea type="text" oninput="value = value.replace(/[^0-9A-Za-z_]+/,'');" name="new_username" placeholder="ユーザーネームを登録"></textarea>
            </div>
        </div>
        <div style="display:flex;margin-top:10px;">
            <div style="width:50%;text-align:right;">
                パスワード:
            </div>
            <div>
                <textarea type="text" oninput="value = value.replace(/[^0-9A-Za-z_]+/,'');" name="new_password" placeholder="ユーザーパスワードを登録"></textarea>
            </div>
        </div>
        <div style="display:flex;margin-top:10px;">
            <div style="width:50%;text-align:right;">
                Eメール:
            </div>
            <div>
                <input name="new_email" type="email"></input>
            </div>
        </div>
        <div style="display:flex;justify-content:center;margin-top:10px;">
            <input type="submit" value="新規登録"></input>
        </div>
    </form>
</body>

</html>