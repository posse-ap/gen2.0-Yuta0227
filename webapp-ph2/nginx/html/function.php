<?php
class check{
    public function check_expire(){
        global $login_url;
        if ($_POST['login_page'] != NULL) {
            //POSTでlogin_pageが送信されたらlogin.phpへ
            unset($_SESSION['user']);
            unset($_SESSION['start']);
            header("Location:" . $login_url);
        }
    }
    public function check_login(){
        //ログイン済み判定
        global $login_url;
        if ($_SESSION['user'] == NULL||$_SESSION['user'][0]['user_name']=='root') {
            unset($_SESSION['user']);
            unset($_SESSION['start']);
            header("Location:" . $login_url);
        }
    }
}
$check=new check;
class post{
    public function reset_time(){
        $_SESSION['month']=NULL;
        $_SESSION['year']=NULL;
    }
    public function set_time(){
        $_SESSION['month'] = $_GET['month'];
        $_SESSION['year'] = $_GET['year'];
    }
    public function receive_post(){
        global $delete_id;
        global $delete_reason;
        $delete_id = (int)$_POST['delete_id'];
        $delete_reason = $_POST['delete_reason'];
    }
    public function delete_sql(){
        if ($_POST['delete_id']&& $_POST['delete_reason']) {
            global $moveMonth;
            global $slack_url;
            $this->receive_post();
            global $dbh;
            global $delete_id;
            global $delete_reason;
            global $user;
            global $post_time;
            $delete_request = $dbh->prepare("INSERT into delete_request (delete_id,delete_reason,user_id) values (?,?,?);");
            $delete_request->bindValue(1, $delete_id, PDO::PARAM_INT);
            $delete_request->bindValue(2, $delete_reason);
            $delete_request->bindValue(3, $user[0]['user_id']);
            $delete_request->execute();
            if (isset($_GET['month']) && isset($_GET['year']) && $moveMonth <= 12) {
                $this->set_time();
            } else {
                $this->reset_time();
            };
            $post_time=date('Y/m/d');
            header("Location:" . $slack_url . "?delete_id=$delete_id&delete_reason=$delete_reason&date=$post_time");
            exit();
        };
    }
    public function set_date_array(){
        if ($_POST['date']){
            global $submit_date;
            $submit_date = explode('-', $_POST['date']);
            $submit_date = [
                'year' => (int)$submit_date[0],
                'month' => (int)$submit_date[1],
                'date' => (int)$submit_date[2]
            ];
        };
    }
    public function set_contents_array(){
        if ($_POST['contents']) {
            global $submit_contents_id;
            $submit_contents_id = $_POST['contents'];
            $submit_contents_name = [
                '1' => 'POSSE課題',
                '2' => 'ドットインストール',
                '3' => 'N予備校'
            ];
            global $submit_contents;
            $submit_contents = [
                '0' => [
                    'content_id' => (int)$submit_contents_id[0],
                    'content_name' => $submit_contents_name[$submit_contents_id[0]],
                ],
                '1' => [
                    'content_id' => (int)$submit_contents_id[1],
                    'content_name' => $submit_contents_name[$submit_contents_id[1]],
                ],
                '2' => [
                    'content_id' => (int)$submit_contents_id[2],
                    'content_name' => $submit_contents_name[$submit_contents_id[2]]
                ]
            ];
        };
    }
    public function set_language(){
        if ($_POST['language']){
            global $submit_language;
            global $submit_language_id;
            $submit_language_id = $_POST['language'];
            $submit_language_name = [
                '1' => 'Javascript',
                '2' => 'CSS',
                '3' => 'PHP',
                '4' => 'HTML',
                '5' => 'Laravel',
                '6' => 'SQL',
                '7' => 'SHELL',
                '8' => 'その他'
            ];
            $submit_language = [
                'language_id' => (int)$submit_language_id,
                'language_name' => $submit_language_name[$submit_language_id]
            ];
        };
    }
    public function set_hours(){
        global $div_submit_hours;
        global $submit_contents_id;
        if ($_POST['hours']) {
            $_SESSION['hours'] = $_POST['hours'];
            $submit_hours = (int)$_POST['hours'];
            $div_submit_hours = $submit_hours / count($submit_contents_id);
        };
    }
    public function insert_data(){
        global $dbh;
        global $submit_contents_id;
        global $submit_date;
        global $submit_language;
        global $submit_contents;
        global $div_submit_hours;
        global $submit_language_id;
        global $content_name;
        global $language_name;
        global $slack_url;
        global $user;
        global $post_time;
        for ($i = 1; $i <= count($submit_contents_id); $i++) {
            global ${"submit".$i};
            //コンテンツの個数回データ挿入
            if (
                $submit_date['date'] &&
                $submit_date['month'] &&
                $submit_date['year'] &&
                $submit_language['language_name'] &&
                $submit_contents[$i - 1]['content_name'] &&
                $div_submit_hours &&
                $submit_contents[$i - 1]['content_id'] &&
                $submit_language_id
            ) {
                //コンテンツの個数分sql文発行
                ${"submit" . $i} = $dbh->prepare("INSERT INTO time (date,month,year,language,content,hours,content_id,language_id,user_id) values (?,?,?,?,?,?,?,?,?);");
                ${"submit" . $i}->bindValue(1, $submit_date['date'], PDO::PARAM_INT);
                ${"submit" . $i}->bindValue(2, $submit_date['month'], PDO::PARAM_INT);
                ${"submit" . $i}->bindValue(3, $submit_date['year'], PDO::PARAM_INT);
                ${"submit" . $i}->bindValue(4, $submit_language['language_name']);
                ${"submit" . $i}->bindValue(5, $submit_contents[$i - 1]['content_name']);
                ${"submit" . $i}->bindValue(6, $div_submit_hours, PDO::PARAM_INT);
                ${"submit" . $i}->bindValue(7, $submit_contents[$i - 1]['content_id'], PDO::PARAM_INT);
                ${"submit" . $i}->bindValue(8, $submit_language_id, PDO::PARAM_INT);
                ${"submit" . $i}->bindValue(9, $user[0]['user_id']);
                ${"submit" . $i}->execute();
                $content_name = $submit_contents[$i - 1]['content_name'];
                $language_name = $submit_language['language_name'];
                if (isset($_GET['month']) && isset($_GET['year'])) {
                    $this->set_time();
                } else {
                    $this->reset_time();
                };
                $post_time=$submit_date['year'].'/'.$submit_date['month'].'/'.$submit_date['date'];
                header("Location:" . $slack_url . "?contents=$content_name&language=$language_name&hours=$div_submit_hours&date=$post_time");
                exit();
            }
        };
    }
}
$post=new post;
function start_timer(){
    global $login_url;
    if (!isset($_SESSION['user'])||!isset($_SESSION['start'])) {
        header("Location:".$login_url);
    }
    if (isset($_SESSION['start']) && (time() - $_SESSION['start'] > 1200)) {
        unset($_SESSION['user']);
        unset($_SESSION['start']);
        header("Location:".$login_url);
    }
};
class delete_data{
    public $column_array=[
        0=>'id',
        1=>'posted_at',
        2=>'date',
        3=>'content',
        4=>'language',
        5=>'hours'
    ];
    public function delete_data_table($delete_table_index){
        global $show_delete_data;
        for($column_array_index=0;$column_array_index<=5;$column_array_index++){
            print_r('<td>');
            print_r($show_delete_data[$delete_table_index][$this->column_array[$column_array_index]]);
            print_r('</td>');
        }
    }
    public function check_existence($delete_table_index){
        global $delete_request_id_data;
        global $show_delete_data;
        $id=$show_delete_data[$delete_table_index]['id'];
        ${"count".$delete_table_index} = 0;
        foreach ($delete_request_id_data as $data) {
            if ($id == $data['delete_id']){
                ${"count".$delete_table_index}++;
                //かぶりが存在している
            }
        }
        if ($count != 0||$show_delete_data[$delete_table_index]['id']==NULL) {
            print_r('<td><input name="delete_id" type="radio" value="'.$show_delete_data[$delete_table_index][$this->column_array[0]].'" id="delete-request-'.$delete_table_index.'" disabled></input></td>');
        }else{
            print_r('<td><input name="delete_id" type="radio" value="'.$show_delete_data[$delete_table_index][$this->column_array[0]].'" id="delete-request-'.$delete_table_index.'"></input></td>');
        }
    }
};
$delete_data=new delete_data;
function return_week(){
    global $date;
    switch (floor($date / 7)) {
        case 1;
            return '1';
            break;
        case 2;
            return '2';
            break;
        case 3;
            return '3';
            break;
        case 4;
            return '4';
            break;
    };
}
