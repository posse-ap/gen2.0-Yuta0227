<?php
require 'url.php';
function start_timer(){
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
}
?>