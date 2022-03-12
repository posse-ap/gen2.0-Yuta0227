<?php 
require "db-connect.php";
$manager_stmt=$dbh->query("SELECT * from users where id=1");
$manager_stmt->execute();
$manager_data=$manager_stmt->fetchAll();
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username=$_POST['username'];
    $password=$_POST['password'];
    $new_username=$_POST['new_username'];
    $new_password=$_POST['new_password'];
    if($manager_data[0]['user_name']==$username&&$manager_data[0]['user_password']==$password){
        header("Location:http://localhost:8080/manager.php");
    }else{
        header("Location:http://localhost:8080/webapp.php");
    }
    print_r('<pre>');
    print_r($manager_data);
    print_r($id);
    print_r($password);
    print_r($new_id);
    print_r($new_password);
    print_r('</pre>');
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
    <form action="" method="POST">
        既存ユーザー:
        <textarea type="text" name="username" placeholder="ユーザーネームを入力してください"></textarea>        
        <textarea type="text" name="password" placeholder="ユーザーパスワードを入力してください"></textarea>
        <input type="submit" value="ログイン"></input>  
    </form>
    <form action="" method="POST">
        新規ユーザー:
        <textarea type="text" name="new_username" placeholder="ユーザーネームを登録"></textarea>
        <textarea type="text" name="new_password" placeholder="ユーザーパスワードを登録"></textarea>
        <input type="submit" value="登録"></input>
    </form>
</body>
</html>