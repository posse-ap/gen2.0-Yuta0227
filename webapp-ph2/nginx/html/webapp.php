<?php
require "db-connect.php";
$submit_date = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submit_date = explode('-', $_POST['date']);
    $submit_date = [
        'year' => (int)$submit_date[0],
        'month' => (int)$submit_date[1],
        'date' => (int)$submit_date[2]
    ];
    $submit_contents_id = $_POST['contents'];
    $submit_contents_name = [
        '1' => 'POSSE課題',
        '2' => 'ドットインストール',
        '3' => 'N予備校'
    ];
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
    $submit_language_id = $_POST['language'];
    $submit_language_name = [
        '1' => 'Javascript',
        '2' => 'CSS',
        '3' => 'PHP',
        '4' => 'HTML',
        '5' => 'Laravel',
        '6' => 'SQL',
        '7' => 'SHELL',
        '8' => '情報システム基礎知識(その他)'
    ];
    $submit_language = [
        'language_id' => (int)$submit_language_id,
        'language_name' => $submit_language_name[$submit_language_id]
    ];
    $submit_hours = (int)$_POST['hours'];
    $div_submit_hours = $submit_hours / count($submit_contents_id);
    //NULLの場合intでキャストすると0になる
    for ($i = 1; $i <= count($submit_contents_id); $i++) {
        //コンテンツの個数分sql文発行
        ${"submit" . $i} = $dbh->prepare("INSERT INTO time values (?,?,?,?,?,?,?,?);");
        ${"submit" . $i}->bindValue(1, $submit_date['date'], PDO::PARAM_INT);
        ${"submit" . $i}->bindValue(2, $submit_date['month'], PDO::PARAM_INT);
        ${"submit" . $i}->bindValue(3, $submit_date['year'], PDO::PARAM_INT);
        ${"submit" . $i}->bindValue(4, $submit_language['language_name']);
        ${"submit" . $i}->bindValue(5, $submit_contents[$i - 1]['content_name']);
        ${"submit" . $i}->bindValue(6, $div_submit_hours, PDO::PARAM_INT);
        ${"submit" . $i}->bindValue(7, $submit_contents[$i - 1]['content_id'], PDO::PARAM_INT);
        ${"submit" . $i}->bindValue(8, $submit_language_id, PDO::PARAM_INT);
        ${"submit" . $i}->execute();
    };
    if (isset($_GET['month']) && isset($_GET['year']) && $moveMonth <= 12) {
        header("Location:http://localhost:8080/webapp.php?month=$moveMonth&year=$moveYear");
    } else {
        header("Location:http://localhost:8080/webapp.php");
    }
    exit;
};
?>
<?php
//最初は現在日程のテーブル表示
//下の方でクリック時$date$month$yearを増減しurlを再度読み込む
$time = new DateTime();
$date = (int)date('d');
$month = (int)date('n');
$year = (int)date('Y');
$moveMonth = $_GET['month'];
$moveYear = $_GET['year'];
if (isset($_GET['month']) && isset($_GET['year']) && $moveMonth <= 12) {
    $stmt2 = $dbh->prepare("SELECT sum(hours) from time where month = $moveMonth AND year = $moveYear;"); //該当月
} else {
    $stmt2 = $dbh->prepare("SELECT sum(hours) from time where month =$month and year = $year;");
};
?>
<?php
// echo $date;
// echo $date;
$stmt1 = $dbh->prepare("SELECT sum(hours) from time where date = $date AND month = $month AND year = $year;"); //today専用
$stmt3 = $dbh->prepare("SELECT sum(hours) from time;"); //合計
$stmt4 = $dbh->prepare("SELECT sum(hours) from time where content_id=1;");
$stmt5 = $dbh->prepare("SELECT sum(hours) from time where content_id=2;");
$stmt6 = $dbh->prepare("SELECT sum(hours) from time where content_id=3;");
$stmt7 = $dbh->prepare("SELECT sum(hours) from time where language_id=1;");
$stmt8 = $dbh->prepare("SELECT sum(hours) from time where language_id=2;");
$stmt9 = $dbh->prepare("SELECT sum(hours) from time where language_id=3;");
$stmt10 = $dbh->prepare("SELECT sum(hours) from time where language_id=4;");
$stmt11 = $dbh->prepare("SELECT sum(hours) from time where language_id=5;");
$stmt12 = $dbh->prepare("SELECT sum(hours) from time where language_id=6;");
$stmt13 = $dbh->prepare("SELECT sum(hours) from time where language_id=7;");
$stmt14 = $dbh->prepare("SELECT sum(hours) from time where language_id=8;");
$content4 = $dbh->prepare("SELECT distinct content from time where content_id=1;"); //1=>POSSE課題
$content5 = $dbh->prepare("SELECT distinct content from time where content_id=2;"); //2=>ドットインストール
$content6 = $dbh->prepare("SELECT distinct content from time where content_id=3;"); //3=>N予備校
$language7 = $dbh->prepare("SELECT distinct language from time where language_id=1;"); //1=>Javascript
$language8 = $dbh->prepare("SELECT distinct language from time where language_id=2;"); //2=>CSS
$language9 = $dbh->prepare("SELECT distinct language from time where language_id=3;"); //3=>PHP
$language10 = $dbh->prepare("SELECT distinct language from time where language_id=4;"); //4=>HTML
$language11 = $dbh->prepare("SELECT distinct language from time where language_id=5;"); //5=>Laravel
$language12 = $dbh->prepare("SELECT distinct language from time where language_id=6;"); //6=>SQL
$language13 = $dbh->prepare("SELECT distinct language from time where language_id=7;"); //7=>SHELL
$language14 = $dbh->prepare("SELECT distinct language from time where language_id=8;"); //8=>情報システム基礎知識(その他)

for ($i = 1; $i <= 14; $i++) {
    ${"stmt" . $i}->execute();
    ${"data" . $i} = ${"stmt" . $i}->fetchAll();
}
for ($g = 4; $g <= 6; $g++) {
    ${"content" . $g}->execute();
    ${"content_data" . $g} = ${"content" . $g}->fetchAll();
}
for ($h = 7; $h <= 14; $h++) {
    ${"language" . $h}->execute();
    ${"language_data" . $h} = ${"language" . $h}->fetchAll();
}
for ($a = 1; $a <= 14; $a++) {
    if (${"data" . $a}[0]['sum(hours)'] == NULL) {
        ${"data" . $a}[0]['sum(hours)'] = 0;
    }
}
// <?php echo $content_array[0]; ,
$content_array = [
    ['合計時間' => (int)$data4[0]['sum(hours)'], 'コンテンツ' => $content_data4[0]['content']],
    ['合計時間' => (int)$data5[0]['sum(hours)'], 'コンテンツ' => $content_data5[0]['content']],
    ['合計時間' => (int)$data6[0]['sum(hours)'], 'コンテンツ' => $content_data6[0]['content']],
];
foreach ($content_array as $key => $value) {
    $multi_content_array[$key] = $value['合計時間'];
};
array_multisort($multi_content_array, SORT_DESC, SORT_NUMERIC, $content_array);
$language_array = [
    ['合計時間' => (int)$data7[0]['sum(hours)'], '言語' => $language_data7[0]['language']],
    ['合計時間' => (int)$data8[0]['sum(hours)'], '言語' => $language_data8[0]['language']],
    ['合計時間' => (int)$data9[0]['sum(hours)'], '言語' => $language_data9[0]['language']],
    ['合計時間' => (int)$data10[0]['sum(hours)'], '言語' => $language_data10[0]['language']],
    ['合計時間' => (int)$data11[0]['sum(hours)'], '言語' => $language_data11[0]['language']],
    ['合計時間' => (int)$data12[0]['sum(hours)'], '言語' => $language_data12[0]['language']],
    ['合計時間' => (int)$data13[0]['sum(hours)'], '言語' => $language_data13[0]['language']],
    ['合計時間' => (int)$data14[0]['sum(hours)'], '言語' => $language_data14[0]['language']],
];
foreach ($language_array as $key => $value) {
    $multi_language_array[$key] = $value['合計時間'];
};
array_multisort($multi_language_array, SORT_DESC, SORT_NUMERIC, $language_array);
//連想配列で数値と言語名も取れると最高
$date_array = [];
for ($j = 1; $j <= date('t'); $j++) {
    if (isset($_GET['month']) && isset($_GET['year']) && $moveMonth <= 12) {
        ${"date_stmt" . $j} = $dbh->prepare("SELECT sum(hours) from time where date = $j and month = $moveMonth and year= $moveYear;"); //日付の合計時間
    } else {
        ${"date_stmt" . $j} = $dbh->prepare("SELECT sum(hours) from time where date = $j and month = $month and year= $year;"); //日付の合計時間
    }
    // ${"date_stmt" . $j} = $dbh->prepare("SELECT date,sum(hours) from time where date =" . $j . " AND month = " . $month . " AND year = " . $year . ";"); //日付の合計時間
    ${"date_stmt" . $j}->execute();
    ${"date_data" . $j} = ${"date_stmt" . $j}->fetchAll();
    ${"date_data" . $j}[0]['sum(hours)'] = ${"date_data" . $j}[0]['sum(hours)'] - 0;
    if (${"date_data" . $j}[0]['sum(hours)'] == NULL) {
        ${"date_data" . $j}[0]['sum(hours)'] = 0;
    };
    array_push($date_array, ${"date_data" . $j}[0]["sum(hours)"]);
};
?>
<!DOCTYPE html>
<html lang="ja">


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
            投稿消すボタン過去5件一覧表示して選んで削除。投稿時間スプレッドシートに反映
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
                    <div class="today"><?php echo $year; ?>/<?php echo $month; ?>/<?php echo $date; ?></div>
                    <div class="number">
                        <?php echo (int)$data1[0]['sum(hours)']; ?>
                    </div>
                    <div class="hour">hour</div>
                </div>
                <div class="month-container">
                    <div class="month">
                        <?php echo $year; ?>/<?php
                                                if (isset($_GET['month']) && isset($_GET['year']) && $moveMonth <= 12) {
                                                    echo $moveMonth;
                                                } else {
                                                    echo $month;
                                                }; ?>
                    </div>
                    <div class="number">
                        <?php echo (int)$data2[0]['sum(hours)']; ?>
                    </div>
                    <div class="hour">hour</div>
                </div>
                <div class="total-container">
                    <div class="total">Total</div>
                    <div class="number">
                        <?php echo (int)$data3[0]['sum(hours)']; ?>
                    </div>
                    <div class="hour">hour</div>
                </div>
            </div>
            <div id="bargraph-container">
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
                        <li><i class="fas fa-circle" style="color:#0345EC"></i><?php echo $language_array[0]['言語']; ?></li>
                        <li><i class="fas fa-circle" style="color:#0F71BD"></i><?php echo $language_array[1]['言語']; ?></li>
                        <li><i class="fas fa-circle" style="color:#20BDDE"></i><?php echo $language_array[2]['言語']; ?></li>
                        <li><i class="fas fa-circle" style="color:#3CCEFE"></i><?php echo $language_array[3]['言語']; ?></li>
                        <li><i class="fas fa-circle" style="color:#B29EF3"></i><?php echo $language_array[4]['言語']; ?></li>
                        <li><i class="fas fa-circle" style="color:#6D46EC"></i><?php echo $language_array[5]['言語']; ?></li>
                        <li><i class="fas fa-circle" style="color:#4A17EF"></i><?php echo $language_array[6]['言語']; ?></li>
                        <li><i class="fas fa-circle" style="color:#3105C0"></i><?php echo $language_array[7]['言語']; ?></li>
                    </ul>
                </div>
            </div>
            <div class="material-chart-container">
                <div class="piechart-title">学習コンテンツ</div>
                <canvas id="material-chart-doughnut" width="15" height="10"></canvas>
                <div>
                    <ul class="material">
                        <li><i class="fas fa-circle" style="color:#0345EC"></i><?php echo $content_array[0]['コンテンツ']; ?></li>
                        <li><i class="fas fa-circle" style="color:#0F71BD"></i><?php echo $content_array[1]['コンテンツ']; ?></li>
                        <li><i class="fas fa-circle" style="color:#20BDDE"></i><?php echo $content_array[2]['コンテンツ']; ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- 月移動 -->
    <div class="calender">
        <button id="previous-month" class="calender-arrow">&lt;</button>
        <div id="year-month">
            <span id="year">
                <?php
                if (isset($_GET['month']) && isset($_GET['year'])) {
                    echo $moveYear;
                } else {
                    echo $year;
                }; ?></span>年<span id="month"><?php
                                                    if (isset($_GET['month']) && isset($_GET['year']) && $moveMonth <= 12) {
                                                        echo $moveMonth;
                                                    } else {
                                                        echo $month;
                                                    }; ?>
            </span>月
        </div>
        <button id="next-month" class="calender-arrow">&gt;</button>
    </div>
    <!-- スマホ用のボタンPCでは非表示 -->
    <div class="smartphone-button-container">
        <button id="smartphone-button" class="smartphone-button">記録・投稿</button>
    </div>
    <!-- 記録投稿ボタンを押した時表示されるオーバーレイ -->
    <div id="fullOverlay" hidden>
        <div class="overlay">
            <form action="" method="POST">
                <div class="form">
                    <div class="form-left">
                        <div class="date-container">
                            <div>学習日</div>
                            <input id="date" type="date" name="date" size="20" class="textbox" value="
                                <?php
                                // if (isset($_GET['month']) && isset($_GET['year'])) {
                                //     $one_digit_date = $moveYear . '-' . $moveMonth . '-' . $date;
                                //     echo date('Y-m-d', strtotime($one_digit_date));
                                // } else {
                                //     echo date('Y-m-d');
                                // };
                                echo htmlspecialchars($submitDate, ENT_QUOTES, 'UTF-8');
                                ?>
                                                                                                            " required>
                        </div>
                        <div class="study-content-container">
                            <div>学習コンテンツ</div>
                            <label id="label1">
                                <input id="checkbox1" name="contents[]" type="checkbox" value="3">
                                <i id="my-checkbox1" class="fas fa-check-circle"></i>
                                <span id="content-span1">
                                    N予備校
                                </span>
                            </label>
                            <label id="label2">
                                <input id="checkbox2" name="contents[]" type="checkbox" value="2">
                                <i id="my-checkbox2" class="fas fa-check-circle"></i>
                                <span id="content-span2">
                                    ドットインストール
                                </span>
                            </label>
                            <label id="label3">
                                <input id="checkbox3" name="contents[]" type="checkbox" value="1">
                                <i id="my-checkbox3" class="fas fa-check-circle"></i>
                                <span id="content-span3">
                                    POSSE課題
                                </span>
                            </label>
                        </div>
                        <div class="language-container">
                            <div>学習言語</div>
                            <label id="label4">
                                <input id="checkbox4" type="checkbox" name="language" value="4">
                                <i id="my-checkbox4" class="fas fa-check-circle"></i>
                                <span id="language-span4">
                                    HTML
                                </span>
                            </label>
                            <label id="label5">
                                <input id="checkbox5" type="checkbox" name="language" value="2">
                                <i id="my-checkbox5" class="fas fa-check-circle"></i>
                                <span id="language-span5">
                                    CSS
                                </span>
                            </label>
                            <label id="label6">
                                <input id="checkbox6" type="checkbox" name="language" value="1">
                                <i id="my-checkbox6" class="fas fa-check-circle"></i>
                                <span id="language-span6">
                                    Javascript
                                </span>
                            </label>
                            <label id="label7">
                                <input id="checkbox7" type="checkbox" name="language" value="3">
                                <i id="my-checkbox7" class="fas fa-check-circle"></i>
                                <span id="language-span7">
                                    PHP
                                </span>
                            </label>
                            <label id="label8">
                                <input id="checkbox8" type="checkbox" name="language" value="5">
                                <i id="my-checkbox8" class="fas fa-check-circle"></i>
                                <span id="language-span8">
                                    Laravel
                                </span>
                            </label>
                            <label id="label9">
                                <input id="checkbox9" type="checkbox" name="language" value="6">
                                <i id="my-checkbox9" class="fas fa-check-circle"></i>
                                <span id="language-span9">
                                    SQL
                                </span>
                            </label>
                            <label id="label10">
                                <input id="checkbox10" type="checkbox" name="language" value="7">
                                <i id="my-checkbox10" class="fas fa-check-circle"></i>
                                <span id="language-span10">
                                    SHELL
                                </span>
                            </label>
                            <label id="label11">
                                <input id="checkbox11" type="checkbox" name="language" value="8">
                                <i id="my-checkbox11" class="fas fa-check-circle"></i>
                                <span id="language-span11">
                                    情報システム基礎知識(その他)
                                </span>
                            </label>
                        </div>
                    </div>
                    <div class="form-right">
                        <div class="hour-container">
                            <div>学習時間</div>
                            <textarea type="text" name="hours" id="time" placeholder="半角数字で入力してください" size="20" class="textbox" oninput="value = value.replace(/[^\d]+/i,'');" / required></textarea>
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
                    <input type="submit" value="記録・投稿" id="post-button" class="post-button"></input>
                </div>
                <button id="exit" class="exit"><i class="fas fa-times"></i></button>
        </div>
        </form>
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
<script>
    var hourBargraphCtx = document.getElementById("hour-bargraph").getContext('2d');
    var hourBargraph = document.getElementById('hour-bragraph');
    var bargraphContainer = document.getElementById('bargraph-container');
    // hourBargraphCtx.canvas.height=bargraphContainer.style.height;
    // hourBargraphCtx.canvas.width=bargraphContainer.style.width;

    var gradient = hourBargraphCtx.createLinearGradient(15, 0, 15, 300);
    //今はバーグラフの左上を基準にしたのグラデーション。各バーを基準にしたグラデーション。数値が12じゃないときグラデーション崩れる
    gradient.addColorStop(0, '#137DC4');
    gradient.addColorStop(0.9, '#38C7F9');

    var myChart = new Chart(hourBargraphCtx, {
        type: "bar", // ★必須　グラフの種類
        data: {
            labels: ["2", "4", "6", "8", "10", "12", "14", "16", "18", "20", "22", "24", "26", "28", "30"], // Ｘ軸のラベル
            datasets: [{
                label: "Data", // 系列名
                data: [
                    <?php echo $date_array[0]; ?>,
                    <?php echo $date_array[1]; ?>,
                    <?php echo $date_array[2]; ?>,
                    <?php echo $date_array[3]; ?>,
                    <?php echo $date_array[4]; ?>,
                    <?php echo $date_array[5]; ?>,
                    <?php echo $date_array[6]; ?>,
                    <?php echo $date_array[7]; ?>,
                    <?php echo $date_array[8]; ?>,
                    <?php echo $date_array[9]; ?>,
                    <?php echo $date_array[10]; ?>,
                    <?php echo $date_array[11]; ?>,
                    <?php echo $date_array[12]; ?>,
                    <?php echo $date_array[13]; ?>,
                    <?php echo $date_array[14]; ?>,
                    <?php echo $date_array[15]; ?>,
                    <?php echo $date_array[16]; ?>,
                    <?php echo $date_array[17]; ?>,
                    <?php echo $date_array[18]; ?>,
                    <?php echo $date_array[19]; ?>,
                    <?php echo $date_array[20]; ?>,
                    <?php echo $date_array[21]; ?>,
                    <?php echo $date_array[22]; ?>,
                    <?php echo $date_array[23]; ?>,
                    <?php echo $date_array[24]; ?>,
                    <?php echo $date_array[25]; ?>,
                    <?php echo $date_array[26]; ?>,
                    <?php echo $date_array[27]; ?>,
                    <?php echo $date_array[28]; ?>,
                    <?php echo $date_array[29]; ?>,
                    <?php echo $date_array[30]; ?>,
                ], // ★必須　系列Ａのデータ
                backgroundColor: gradient, // 棒の塗りつぶし色
                borderColor: gradient, // 棒の枠線の色
                borderWidth: 1, // 枠線の太さ
            }]
        },

        options: { // オプション
            responsive: true, // canvasサイズ自動設定機能を使わない。HTMLで指定したサイズに固定
            title: { // タイトル
                display: false, // 表示設定
                fontSize: 18, // フォントサイズ
                fontFamily: "sans-serif",
                text: 'タイトル' // タイトルのラベル
            },
            legend: { // 凡例
                display: false // 表示の有無
                // position: 'bottom'              // 表示位置
            },
            scales: { // 軸設定
                xAxes: [ // Ｘ軸設定
                    {
                        display: true, // 表示の有無
                        barPercentage: 0.4, // カテゴリ幅に対する棒の幅の割合
                        //categoryPercentage: 0.8,    // 複数棒のスケールに対する幅の割合
                        scaleLabel: { // 軸ラベル
                            display: false, // 表示設定
                            labelString: '横軸ラベル', // ラベル
                            fontColor: "#97b9d1", // 文字の色
                            fontSize: 8 // フォントサイズ
                        },
                        gridLines: { // 補助線
                            display: false // 補助線なし
                        },
                        ticks: { // 目盛り
                            fontColor: "#97b9d1", // 目盛りの色
                            fontSize: 14, // フォントサイズ
                        },
                    }
                ],
                yAxes: [ // Ｙ軸設定
                    {
                        display: true, // 表示の有無
                        scaleLabel: { // 軸ラベル
                            display: false, // 表示の有無
                            labelString: '縦軸ラベル', // ラベル
                            fontFamily: "sans-serif", // フォントファミリー
                            fontColor: "#97b9d1", // 文字の色
                            fontSize: 16 // フォントサイズ
                        },
                        gridLines: { // 補助線
                            display: false, // 補助線なし
                            color: "rgba(0, 0, 255, 0.2)", // 補助線の色
                            zeroLineColor: "black" // y=0（Ｘ軸の色）
                        },
                        ticks: { // 目盛り
                            min: 0, // 最小値
                            max: 20, // 最大値
                            stepSize: 4, // 軸間隔
                            fontColor: "#97b9d1", // 目盛りの色
                            fontSize: 14 // フォントサイズ
                        },
                    }
                ],
            },
            layout: { // 全体のレイアウト
                padding: { // 余白
                    left: 0,
                    right: 0,
                    top: 50,
                    bottom: 0
                }
            },
            plugins: {
                labels: {
                    display: false,
                    // render: 'percentage',
                    fontColor: '#00000000',
                    fontSize: 20,
                },
                datalabels: {
                    display: false
                }
            },
            maintainAspectRatio: true
        }
    });



    //学習言語と学習コンテンツのチャート
    var language = document.getElementById('language-chart-doughnut');
    var myLanguageChart = new Chart(language, {
        type: 'doughnut',
        data: {
            labels: [
                '<?php echo $language_array[0]['言語']; ?>',
                '<?php echo $language_array[1]['言語']; ?>',
                '<?php echo $language_array[2]['言語']; ?>',
                '<?php echo $language_array[3]['言語']; ?>',
                '<?php echo $language_array[4]['言語']; ?>',
                '<?php echo $language_array[5]['言語']; ?>',
                '<?php echo $language_array[6]['言語']; ?>',
                '<?php echo $language_array[7]['言語']; ?>'
            ],
            datasets: [{
                data: [
                    <?php echo $language_array[0]['合計時間']; ?>,
                    <?php echo $language_array[1]['合計時間']; ?>,
                    <?php echo $language_array[2]['合計時間']; ?>,
                    <?php echo $language_array[3]['合計時間']; ?>,
                    <?php echo $language_array[4]['合計時間']; ?>,
                    <?php echo $language_array[5]['合計時間']; ?>,
                    <?php echo $language_array[6]['合計時間']; ?>,
                    <?php echo $language_array[7]['合計時間']; ?>,
                ],
                backgroundColor: ['#0345EC', '#0F71BD', '#20BDDE', '#3CCEFE', '#B29EF3', '#6D46EC', '#4A17EF', '#3105C0'],
                weight: 100,
            }],
        },
        options: {
            legend: {
                display: false
            },
            title: {
                display: true,
                text: '割合'
            },
            plugins: {
                labels: {
                    render: 'percentage',
                    fontColor: '#00000000',
                    fontSize: 10
                }
            }
        }
    });
    var material = document.getElementById('material-chart-doughnut');
    var myMaterialChart = new Chart(material, {
        type: 'doughnut',
        data: {
            labels: [
                '<?php echo $content_array[0]['コンテンツ']; ?>',
                '<?php echo $content_array[1]['コンテンツ']; ?>',
                '<?php echo $content_array[2]['コンテンツ']; ?>',
            ],
            datasets: [{
                data: [
                    <?php echo $content_array[0]['合計時間']; ?>,
                    <?php echo $content_array[1]['合計時間']; ?>,
                    <?php echo $content_array[2]['合計時間']; ?>
                ],
                backgroundColor: ['#0345EC', '#0F71BD', '#20BDDE'],
                weight: 100,
            }],
        },
        //表示順を大きい順にする方法がわからん。おそらくこのままだと数値は順番変更できてもそれがラベルの内容とずれるかも
        options: {
            legend: {
                display: false
            },
            title: {
                display: true,
                text: '割合'
            },
            plugins: {
                labels: {
                    render: 'percentage',
                    fontColor: '#00000000',
                    fontSize: 10
                }
            }
        }
    });
</script>

</html>
<!-- 最初はurlから情報取得せず現在の日時などを表示月移動するときurlから数値取得して$monthから引いたり足したりする -->