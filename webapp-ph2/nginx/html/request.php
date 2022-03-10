<?php

// require 'db-connect.php';
// $raw = file_get_contents('php://input');
// $data = json_decode($raw);
// $submitDate = $data->{'date'};
// $submitMonth = $data->{'month'};
// $submitYear = $data->{'year'};
// $submitContent = $data->{'content'};
// $submitLanguage = $data->{'language'};
// $submitHours = $data->{'hours'};
// print_r($data);
// // if(count($submitContent)==0){
// //     //提出無効
// //     echo 'yes'.PHP_EOL;
// // }else
// // var_dump($submitContent[0]);
// // if (var_dump($submitContent) == 'array') {
// $content_array = [];
// $all_contents_array = ["POSSE課題", "ドットインストール", "N予備校"];
// $all_languages_array = [
//     "Javascript",
//     "CSS",
//     "PHP",
//     "HTML",
//     "Laravel",
//     "SQL",
//     "SHELL",
//     "情報システム基礎知識(その他)"
// ];
// for ($i = 1; $i <= 3; $i++) {
//     ${"submitContent" . $i} = $submitContent[$i - 1];
//     for ($j = 1; $j <= 3; $j++) {
//         if (${"submitContent" . $i} == $all_contents_array[$j - 1]) {
//             ${"content_id" . $i} = $j; //数字が入る
//         }
//     };
//     if (${"submitContent" . $i} != NULL) {
//         array_push($content_array, ${"submitContent" . $i});
//     };
// };
// for ($i = 1; $i <= 8; $i++) {
//     if ($submitLanguage == $all_languages_array[$i - 1]) {
//         $language_id = $i + 1;
//     };
// };
// $divSubmitHours = 1;
// if (count($content_array) != 0) {
//     $divSubmitHours = $submitHours / count($content_array);
//     //コンテンツの個数で時間を割った
// }
// // };

// // if(var_dump($submitLanguage)==NULL){
// //     echo 'no'.PHP_EOL;
// // };
// for ($i = 1; $i <= count($content_array); $i++) {
//     //コンテンツの個数分sql文発行
//     ${"submit" . $i} = $dbh->prepare("INSERT INTO time values (?,?,?,?,?,?,?,?);");
//     ${"submit" . $i}->bindValue(1, $submitDate, PDO::PARAM_INT);
//     ${"submit" . $i}->bindValue(2, $submitMonth, PDO::PARAM_INT);
//     ${"submit" . $i}->bindValue(3, $submitYear, PDO::PARAM_INT);
//     ${"submit" . $i}->bindValue(4, $submitLanguage);
//     ${"submit" . $i}->bindValue(5, $content_array[$i]);
//     ${"submit".$i}->bindValue(6,$divSubmitHours,PDO::PARAM_INT);
//     ${"submit" . $i}->bindValue(7, (int)${"content_id" . $i}, PDO::PARAM_INT);
//     ${"submit" . $i}->bindValue(8, $language_id, PDO::PARAM_INT);
//     ${"submit" . $i}->execute();
// };
// echo $content_id1;


// //insertしたらページリロード
// ?>
