<?php 
$raw=file_get_contents('php://input');
$data=json_decode($raw);
$submitDate=$data->{'date'};
$submitMonth=$data->{'month'};
$submitYear=$data->{'year'};
$submitContent=$data->{'content'};
$submitLanguage=$date->{'language'};
$submitHours=$date->{'hours'};
if(count($submitContent)==0){
    //提出無効
    echo 'yes'.PHP_EOL;
}
if(var_dump($submitLanguage)==NULL){
    echo 'no'.PHP_EOL;
}
// echo json_encode($res);
?> 