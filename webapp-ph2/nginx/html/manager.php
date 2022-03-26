<?php
session_start();
require_once 'db-connect.php';
require_once "url.php";
require_once "function.php";
start_timer();
$delete_request_stmt = $dbh->query("SELECT delete_id,delete_reason,user_id from delete_request;");
$delete_request_data = $delete_request_stmt->fetchAll();
$email_stmt=$dbh->query("SELECT user_email from users where user_id!=1;");
$email_data=$email_stmt->fetchAll();
$email_array=[];
foreach($email_data as $data){
    array_push($email_array,$data['user_email']);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['delete'] != NULL && $_POST['reject_reason'] == NULL) {
        foreach ($_POST['delete'] as $delete) {
            $delete = (int)$delete;
            $delete_delete_request_stmt = $dbh->prepare("DELETE from delete_request where delete_id = ?;");
            $delete_delete_request_stmt->bindValue(1, $delete);
            $delete_delete_request_stmt->execute();
            $delete_time_stmt = $dbh->prepare("DELETE from time where id = ?;");
            $delete_time_stmt->bindValue(1, $delete);
            $delete_time_stmt->execute();
            $post_time=date('Y/m/d');
            header("Location:".$slack_url."?delete_id=$delete&date=$post_time");
            exit();
        }
    } elseif ($_POST['delete'] != NULL && $_POST['reject_reason'] != NULL) {
        //削除依頼却下
        foreach ($_POST['delete'] as $delete) {
            $delete = (int)$delete;
            $delete_delete_request_stmt = $dbh->prepare("DELETE from delete_request where delete_id = ?;");
            $delete_delete_request_stmt->bindValue(1, $delete);
            $delete_delete_request_stmt->execute();
            $reject_reason = $_POST['reject_reason'];
            $post_time=date('Y/m/d');
            header("Location:".$slack_url."?delete_id=$delete&reject_reason=$reject_reason&date=$post_time");
            exit();
        }
    }
    if($_POST['logout']!=NULL){
        unset($_SESSION['user']);
        unset($_SESSION['start']);
        header("Location:".$login_url);
    }
    mb_language("Japanese");
    mb_internal_encoding("UTF-8");
    $to = $_POST['to'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $headers = "From: yutahonjo@keio.jp \r\n";
    $mail = mb_send_mail($to, $title, $content, $headers);
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./reset.css">
</head>

<body>
    <h1 style="font-size:25px;background-color:white;text-align:center;padding:10% 0;">
        管理者画面
    </h1>
    <form method="POST" action="">
        <?php if (count($delete_request_data) == 0) { ?>
        <?php } else { ?>
            <div>
                承認する申請は選んで確定を押してください<br>
                却下する申請は選んで理由を書いて確定を押してください
            </div>
            <?php for ($i = 0; $i < count($delete_request_data); $i++) { ?>
                <div style="display:flex;background-color:lightblue;padding:10px;">
                    <div>ユーザーID:<?php echo $delete_request_data[$i]['user_id']; ?></div>
                    <div>投稿ID:<?php echo $delete_request_data[$i]['delete_id']; ?></div>
                    <div style="margin-left:20px;">理由:<?php echo $delete_request_data[$i]['delete_reason']; ?></div>
                    <label>
                        <input name="delete[]" style="margin-left:20px;" type="checkbox" value="<?php echo $delete_request_data[$i]['delete_id']; ?>">
                        <?php echo '削除申請' . $data['delete_id'] . 'を選択'; ?>
                        </input>
                    </label>
                </div>
                <?php } ?>
            <textarea type="text" name="reject_reason" placeholder="却下する理由を書いてください"></textarea>
            <input style="margin-left:20px;" type="submit" value="確定" <?php if (count($delete_request_data) == 0) {
                                                                            echo 'disabled';
                                                                        }; ?>></input>
        <?php } ?>
    </form>
    <section style="padding:0 10% 10% 10%;background-color:gray;">
        <h2 style="text-align:center;font-size:25px;padding:20px;">メール作成</h2>
        <form action="" method="POST">
            <div>
                <select name="to">
                    <?php foreach($email_array as $email){
                        print_r('<option>'.$email.'</option>');
                    }?>
                </select>
            </div>
            <div>
                <textarea style="width:100%;margin:0 auto;"placeholder="件名を記入してください" type="text" name="title"></textarea>
            </div>
            <div>
                <textarea style="width:100%;margin:0 auto;" placeholder="メッセージを記入してください" name="content" cols="60" rows="10"></textarea>
            </div>
            <div>
                <input style="width:100%;margin:0 auto;" type="submit" name="send" value="送信"></input>
            </div>
        </form>
    </section>
    <section>
        <form action="" method="POST">
            <div style="justify-content:center;display:flex;margin:200px 0;">
                <input name="logout" style="background-color:yellow;" type="submit" value="ログアウトする"></input>
            </div>
        </form>
    </section>
</body>

</html>