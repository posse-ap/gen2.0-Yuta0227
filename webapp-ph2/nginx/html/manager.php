<?php
require 'db-connect.php';
$delete_request_stmt = $dbh->query("SELECT delete_id,delete_reason,user_id from delete_request;");
$delete_request_data = $delete_request_stmt->fetchAll();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['delete'] != NULL) {
        foreach ($_POST['delete'] as $delete) {
            $delete = (int)$delete;
            $delete_delete_request_stmt = $dbh->prepare("DELETE from delete_request where delete_id = ?;");
            $delete_delete_request_stmt->bindValue(1, $delete);
            $delete_delete_request_stmt->execute();
            $delete_time_stmt = $dbh->prepare("DELETE from time where id = ?;");
            $delete_time_stmt->bindValue(1, $delete);
            $delete_time_stmt->execute();
        }
        // header("Location:http://localhost:8080/manager.php");
    }
    mb_language("Japanese");
    mb_internal_encoding("UTF-8");
    $to = $_POST['to'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $headers = "From: yutahonjo@keio.jp \r\n";
    var_dump($to);
    var_dump($title);
    var_dump($content);
    var_dump($headers);
    $mail=mb_send_mail($to,$title,$content,$headers);
    var_dump($mail);
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
    <h1>
        管理者画面
    </h1>
    <form method="POST" action="">
        <?php foreach ($delete_request_data as $data) { ?>
            <div style="display:flex;background-color:lightblue;padding:10px;">
                <div>ユーザーID:<?php echo $data['user_id'] ?></div>
                <div>ID:<?php echo $data['delete_id']; ?></div>
                <div style="margin-left:20px;">理由:<?php echo $data['delete_reason']; ?></div>
                <label>
                    <input name="delete[]" style="margin-left:20px;" type="checkbox" value="<?php echo $data['delete_id']; ?>">
                    <?php echo '削除申請' . $data['delete_id'] . 'を承認する'; ?>
                    </input>
                </label>
            </div>
        <?php }; ?>
        <input style="margin-left:20px;" type="submit" value="確定" <?php if (count($delete_request_data) == 0) {
                                                                        echo 'disabled';
                                                                    }; ?>></input>
    </form>
    <form action="manager.php" method="POST">
        <p>送り先</p><input type="text" name="to"></input>
        <p>件名</p><input type="text" name="title"></input>
        <p>メッセージ</p><textarea name="content" cols="60" rows="10"></textarea>
        <p><input type="submit" name="send" value="送信"></input></p>
    </form>
</body>

</html>