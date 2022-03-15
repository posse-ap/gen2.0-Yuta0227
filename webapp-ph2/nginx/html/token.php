<?php
$headers = [
    'Authorization: Bearer xoxp-3233965073126-3240610434786-3239428217109-515ec188de3c6e10e59f1c87b340b2b9', //（1)
    'Content-Type: application/json;charset=utf-8'
];
//Bot user oauth token
//xoxb-3233965073126-3241197018803-JFY74HT3hxNYZ4J4y8BemFrn
//user oauth token
//xoxp-3233965073126-3240610434786-3239428217109-515ec188de3c6e10e59f1c87b340b2b9
//チャンネル増やすたびにtoken変更必要
$url = "https://slack.com/api/chat.postMessage"; //(2)
// $url = "https://hooks.slack.com/services/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"; //(2)

//(3)
if(isset($_GET['delete_id'])&&isset($_GET['reject_reason'])){
    // echo 1;
    //却下
    $delete_id=$_GET['delete_id'];
    $reject_reason=$_GET['reject_reason'];
    $post_fields = [
        "channel" => "#削除依頼",
        "text" => "削除依頼".$delete_id."を".$reject_reason."の理由で却下しました",
        "as_user" => true
    ];
}elseif(isset($_GET['delete_id'])&&!isset($_GET['reject_reason'])){
    //承認するとき
    $delete_id=$_GET['delete_id'];
    $post_fields = [
        "channel" => "#削除依頼",
        "text" => "削除依頼".$delete_id."を承認しました",
        "as_user" => true
    ];

};
if(isset($_GET['delete_id'])&&isset($_GET['delete_reason'])){
    // echo 2;
    $delete_id=$_GET['delete_id'];
    $delete_reason=$_GET['delete_reason'];
    $post_fields = [
        "channel" => "#削除依頼",
        "text" => "投稿".$delete_id."を".$delete_reason."の理由で削除依頼しました。確認お願いします。",
        "as_user" => true
    ];
};
if(isset($_GET['contents'])&&isset($_GET['language'])&&isset($_GET['hours'])){
    // echo 3;
    $contents=$_GET['contents'];
    $language=$_GET['language'];
    $hours=$_GET['hours'];
    $post_fields = [
        "channel" => "#勉強報告",
        "text" => $language."を".$contents."で".$hours."時間勉強しました。褒めろ。",
        "as_user" => true
    ];
};

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
if(isset($_GET['delete_id'])&&isset($_GET['reject_reason'])){
    //管理者
    header("Location:http://localhost:8080/manager.php");
    exit();
};
if($_SESSION['month']==NULL&&$_SESSION['year']==NULL){
    //月移動なしのwebapp
    header("Location:http://localhost:8080/webapp.php");
    exit();
};
if($_SESSION['month']!=NULL&&$_SESSION['year']!=NULL){
    //月移動ありのwebapp
    $month=$_SESSION['month'];
    $year=$_SESSION['year'];
    header("Location:http://localhost:8080/webapp.php?month=$month&year=$year");
    exit();
}
