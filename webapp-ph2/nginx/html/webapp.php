<?php 
include "db-connect.php"
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./reset.css">
    <link rel="stylesheet" type="text/css" href="./webapp.css">
    <title>Document</title>
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
</head>

<body>
    <header>
        <div class="logo-week">
            <img src="./img/posse_logo.png" alt="posseのロゴ" class="logo">
            <div class="week">4th week</div>
        </div>
        <div class="button-container">
            <button id="header-button" class="post-button">記録・投稿</button>
        </div>
    </header>
    <div class="content-container">
        <!-- 一段目 -->
        <div class="first-container">
            <div class="today-month-total-container">
                <div class="today-container">
                    <div class="today">Today</div>
                    <div class="number">3</div>
                    <div class="hour">hour</div>
                </div>
                <div class="month-container">
                    <div class="month">Month</div>
                    <div class="number">120</div>
                    <div class="hour">hour</div>
                </div>
                <div class="total-container">
                    <div class="total">Total</div>
                    <div class="number">1348</div>
                    <div class="hour">hour</div>
                </div>
            </div>
            <div id="bargraph-container" >
                <canvas id="hour-bargraph" class="bargraph-container" width="20" height="10"></canvas>
            </div>
        </div>
        <!-- 二段目 -->
        <div class="second-container">
            <div class="language-chart-container">
                <div class="piechart-title">学習言語</div>
                <canvas id="language-chart-doughnut" width="15" height="10"></canvas>
                <div>
                    <ul class="language">
                        <li><i class="fas fa-circle" style="color:#0345EC"></i>Javascript</li>
                        <li><i class="fas fa-circle" style="color:#0F71BD"></i>CSS</li>
                        <li><i class="fas fa-circle" style="color:#20BDDE"></i>PHP</li>
                        <li><i class="fas fa-circle" style="color:#3CCEFE"></i>HTML</li>
                        <li><i class="fas fa-circle" style="color:#B29EF3"></i>Lavarel</li>
                        <li><i class="fas fa-circle" style="color:#6D46EC"></i>SQL</li>
                        <li><i class="fas fa-circle" style="color:#4A17EF"></i>SHELL</li>
                        <li><i class="fas fa-circle" style="color:#3105C0"></i>情報システム基礎知識(その他)</li>
                    </ul>
                </div>
            </div>
            <div class="material-chart-container">
                <div class="piechart-title">学習コンテンツ</div>
                <canvas id="material-chart-doughnut" width="15" height="10"></canvas>
                <div>
                    <ul class="material">
                        <li><i class="fas fa-circle" style="color:#0345EC"></i>ドットインストール</li>
                        <li><i class="fas fa-circle" style="color:#0F71BD"></i>N予備校</li>
                        <li><i class="fas fa-circle" style="color:#20BDDE"></i>POSSE課題</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- 月移動 -->
    <div class="calender">
        <div class="calender-arrow">&lt;</div>
        <div>2020年10月</div>
        <div class="calender-arrow">&gt;</div>
    </div>
    <!-- スマホ用のボタンPCでは非表示 -->
    <div class="smartphone-button-container">
        <button id="smartphone-button" class="smartphone-button">記録・投稿</button>
    </div>
    <!-- 記録投稿ボタンを押した時表示されるオーバーレイ -->
    <div id="fullOverlay" hidden>
        <div class="overlay">
            <div class="form">
                <div class="form-left">
                    <div class="date-container">
                        <div>学習日</div>
                        <input id="date" type="date" size="20" class="textbox" required>
                    </div>
                    <div class="study-content-container">
                        <div>学習コンテンツ</div>
                        <label id="label1">
                            <input id="checkbox1" type="checkbox">
                            <i id="my-checkbox1" class="fas fa-check-circle"></i>
                            N予備校
                        </label>
                        <label id="label2">
                            <input id="checkbox2" type="checkbox">
                            <i id="my-checkbox2" class="fas fa-check-circle"></i>
                            ドットインストール
                        </label>
                        <label id="label3">
                            <input id="checkbox3" type="checkbox">
                            <i id="my-checkbox3" class="fas fa-check-circle"></i>
                            POSSE課題
                        </label>
                    </div>
                    <div class="language-container">
                        <div>学習言語</div>
                        <label id="label4">
                            <input id="checkbox4" type="checkbox">
                            <i id="my-checkbox4" class="fas fa-check-circle"></i>
                            HTML
                        </label>
                        <label id="label5">
                            <input id="checkbox5" type="checkbox">
                            <i id="my-checkbox5" class="fas fa-check-circle"></i>
                            CSS
                        </label>
                        <label id="label6">
                            <input id="checkbox6" type="checkbox">
                            <i id="my-checkbox6" class="fas fa-check-circle"></i>
                            Javascript
                        </label>
                        <label id="label7">
                            <input id="checkbox7" type="checkbox">
                            <i id="my-checkbox7" class="fas fa-check-circle"></i>
                            PHP
                        </label>
                        <label id="label8">
                            <input id="checkbox8" type="checkbox">
                            <i id="my-checkbox8" class="fas fa-check-circle"></i>
                            Lavarel
                        </label>
                        <label id="label9">
                            <input id="checkbox9" type="checkbox">
                            <i id="my-checkbox9" class="fas fa-check-circle"></i>
                            SQL
                        </label>
                        <label id="label10">
                            <input id="checkbox10" type="checkbox">
                            <i id="my-checkbox10" class="fas fa-check-circle"></i>
                            SHELL
                        </label>
                        <label id="label11">
                            <input id="checkbox11" type="checkbox">
                            <i id="my-checkbox11" class="fas fa-check-circle"></i>
                            情報システム基礎知識(その他)
                        </label>
                    </div>
                </div>
                <div class="form-right">
                    <div class="hour-container">
                        <div>学習時間</div>
                        <input id="time" placeholder="半角数字で入力してください" size="20" class="textbox"
                            oninput="value = value.replace(/[^\d]+/i,'');" / required></textarea>
                        <!-- 半角数字以外入力無効 -->
                    </div>
                    <div class="comment-container">
                        <div>Twitter用コメント</div>
                        <textarea id="comment" class="twitter-comment textbox" placeholder="ツイート内容を入力してください"></textarea>
                    </div>
                    <div class="share-container">
                        <label id="label12">
                            <input id="checkbox12" type="checkbox">
                            <i id="my-checkbox12" class="fas fa-check-circle fa-2x"></i>
                            Twitterにシェアする
                        </label>
                    </div>
                </div>
            </div>
            <div class="overlay-button-container">
                <button id="post-button" class="post-button">
                    記録・投稿
                </button>
            </div>
            <button id="exit" class="exit"><i class="fas fa-times"></i></button>
        </div>
    </div>
    <!-- ロード画面のアニメーション -->
    <div id="animation-filter" class="animation-filter" hidden>
        <div class="animation-container">
            <div id="animation-text"></div>
            <div class="animation"></div>
        </div>
    </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.0/chart.min.js" integrity="sha512-GMGzUEevhWh8Tc/njS0bDpwgxdCJLQBWG3Z2Ct+JGOpVnEmjvNx6ts4v6A2XJf1HOrtOsfhv3hBKpK9kE5z8AQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>
<!-- datalabelsプラグインを呼び出す -->
<script src="./chartjs-plugin-labels.js"></script>
<script src="./webapp.js"></script>

</html>