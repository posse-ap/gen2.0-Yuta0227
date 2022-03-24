<?php
class check{
    public function check_expire(){
        global $login_url;
        if ($_POST['login_page'] != NULL) {
            session_destroy();
            header("Location:" . $login_url);
        }
    }
    public function check_login(){
        global $login_url;
        if ($_SESSION['user'] == NULL) {
            session_destroy();
            header("Location:" . $login_url);
        }
    }
}
$check=new check;
function start_timer(){
    global $login_url;
    if (!isset($_SESSION['user'])) {
        header("Location:".$login_url);
    } else {
        //ログインしてから時間測る
        $_SESSION['start'] = time();
    }
    if (isset($_SESSION['start']) && (time() - $_SESSION['start'] > 1200)) {
        unset($_SESSION['user']);
        unset($_SESSION['start']);
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
    public function delete_data_table($show_delete_data,$delete_table_index){
        for($column_array_index=0;$column_array_index<=5;$column_array_index++){
            print_r('<td>');
            print_r($show_delete_data[$delete_table_index][$this->column_array[$column_array_index]]);
            print_r('</td>');
        }
    }
    public function check_existence($delete_request_id_data,$show_delete_data,$delete_table_index){
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

