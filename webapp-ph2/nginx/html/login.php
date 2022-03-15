<?php 
session_start();
require "db-connect.php";
$manager_stmt=$dbh->query("SELECT * from users where user_id=1");
$manager_data=$manager_stmt->fetchAll();
$users_stmt=$dbh->query("SELECT * from users where user_id!=1");
$users_data=$users_stmt->fetchAll();
$password=NULL;
$username=NULL;
$new_username=NULL;
$new_password=NULL;
$new_email=NULL;
//確認用
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username=$_POST['username'];
    $hash_password=$dbh->prepare("select user_password from users where user_name=?;");
    $hash_password->bindValue(1,$username);
    $hash_password->execute();
    $hash_password=$hash_password->fetchAll();
    $password=$_POST['password'];
    $new_username=$_POST['new_username'];
    if($new_password!=NULL){
        $new_password=password_hash($_POST['new_password'],PASSWORD_DEFAULT);
    }
    $new_email=$_POST['new_email'];
    print_r($new_password);
    if($new_username==null&&$new_password==null){
        if($manager_data[0]['user_name']==$username&&$manager_data[0]['user_password']==$password){
            header("Location:http://localhost:8080/manager.php");
        }elseif(password_verify($password,$hash_password[0]['user_password'])){
            $users_stmt1=$dbh->prepare("SELECT * from users where user_name=?");
            $users_stmt1->bindValue(1,$username);
            $users_stmt1->execute();
            $users_data1=$users_stmt1->fetchAll();
            $_SESSION['user']=$users_data1;
            header("Location:http://localhost:8080/webapp.php");
        }
    }
    $user_exist_count=0;
    foreach($users_data as $user_data){
        if($user_data['user_name']==$new_username||$user_data['user_password']==$new_password||$user_data['user_email']==$new_email){
            $user_exist_count++;
        };
    };
    // print_r($user_exist_count);
    // print_r($username);
    // var_dump($password);
    if($username==null&&$password==null&&$user_exist_count==0){
        $add_user_stmt=$dbh->prepare("INSERT into users (user_type,user_name,user_password,user_email) values ('一般ユーザー',?,?,?);");
        $add_user_stmt->bindValue(1,$new_username);
        $add_user_stmt->bindValue(2,$new_password);
        $add_user_stmt->bindValue(3,$new_email);
        $add_user_stmt->execute();
        $users_stmt1=$dbh->prepare("SELECT * from users where user_name=?");
        $users_stmt1->bindValue(1,$new_username);
        $users_stmt1->execute();
        $users_data1=$users_stmt1->fetchAll();
        $_SESSION['user']=$users_data1;
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
<body>
    パスワードハッシュ化するとテーブルになぜか追加できない
    <form action="" method="POST">
        既存ユーザー:
        <textarea type="text" oninput="value = value.replace(/[^0-9A-Za-z_]+/,'');" name="username" placeholder="ユーザーネームを入力してください"></textarea>        
        <textarea type="text" oninput="value = value.replace(/[^0-9A-Za-z_]+/,'');" name="password" placeholder="ユーザーパスワードを入力してください"></textarea>
        <input type="submit" value="ログイン"></input>  
    </form>
    <form action="" method="POST">
        新規ユーザー:
        <textarea type="text" oninput="value = value.replace(/[^0-9A-Za-z_]+/,'');" name="new_username" placeholder="ユーザーネームを登録"></textarea>
        <textarea type="text" oninput="value = value.replace(/[^0-9A-Za-z_]+/,'');" name="new_password" placeholder="ユーザーパスワードを登録"></textarea>
        <input name="new_email" type="email"></input>
        <input type="submit" value="登録"></input>
    </form>
</body>
</html>