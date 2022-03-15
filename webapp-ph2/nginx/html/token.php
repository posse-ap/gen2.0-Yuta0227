<?php
$headers = [
    // 'Authorization: Bearer xoxb-3233965073126-3241197018803-0IoazFrrxl5dw666pO9KP3KF', //（1)
    'Authorization: Bearer xoxp-3233965073126-3240610434786-3264963112096-9084c2157dd0a755fb453fb53c6876df', //（1)
    'Content-Type: application/json;charset=utf-8'
];
//Bot user oauth token
//xoxb-3233965073126-3241197018803-0IoazFrrxl5dw666pO9KP3KF
//user oauth token
//xoxp-3233965073126-3240610434786-3264963112096-9084c2157dd0a755fb453fb53c6876df
$url = "https://slack.com/api/chat.postMessage"; //(2)
// $url = "https://hooks.slack.com/services/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"; //(2)

//(3)

if(isset($_GET['delete_id'])&&isset($_GET['delete_reason'])){
    $delete_id=$_GET['delete_id'];
    $delete_reason=$_GET['delete_reason'];
    $post_fields = [
        "channel" => "#削除依頼",
        "text" => "投稿".$delete_id."を".$delete_reason."の理由で削除依頼しました。確認お願いします。",
        "as_user" => true
    ];
}elseif(isset($_GET['contents'])&&isset($_GET['language'])&&isset($_GET['hours'])){
    $contents=$_GET['contents'];
    $language=$_GET['language'];
    $hours=$_GET['hours'];
    $post_fields = [
        "channel" => "#勉強報告",
        "text" => $language."を".$contents."で".$hours."時間勉強しました。褒めろ。",
        "as_user" => true
    ];
}

$options = [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => $headers,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($post_fields) 
];

$ch = curl_init();

curl_setopt_array($ch, $options);

$result = curl_exec($ch); 

curl_close($ch);
if($_SESSION['month']==NULL&&$_SESSION['year']==NULL){
    header("Location:http://localhost:8080/webapp.php");
}else{
    $month=$_SESSION['month'];
    $year=$_SESSION['year'];
    header("Location:http://localhost:8080/webapp.php?month=$month&year=$year");
}
