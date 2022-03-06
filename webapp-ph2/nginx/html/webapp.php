<script>
    <?php
    //最初は現在日程のテーブル表示
    //下の方でクリック時$date$month$yearを増減しurlを再度読み込む
    $time = new DateTime('now');
    $date = (int)$time->format('d');
    $month = (int)date('n');
    $year = (int)$time->format('Y');
    ?>
    // window.onload=function(){
    //     window.open("localhost:8080/webapp.php?date="+<?php echo $date; ?>+"?month="+<?php echo $month; ?>+"?year="+<?php echo $year; ?>);
    // };
    //開くときurl設定して月移動しても反映するようにしたい
    //最重要    
</script>
<?php
require "db-connect.php";
// require "request.php";
?>
<?php
$stmt1 = $dbh->prepare("SELECT sum(hours) from time where date=$date AND month=$month AND year=$year;"); //today専用
$stmt2 = $dbh->prepare("SELECT sum(hours) from time where month=$month AND year=$year;"); //該当月
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
$content_hour_array = [
    (int)$data4[0]['sum(hours)'],
    (int)$data5[0]['sum(hours)'],
    (int)$data6[0]['sum(hours)'],
];
$language_hour_array = [
    (int)$data7[0]['sum(hours)'],
    (int)$data8[0]['sum(hours)'],
    (int)$data9[0]['sum(hours)'],
    (int)$data10[0]['sum(hours)'],
    (int)$data11[0]['sum(hours)'],
    (int)$data12[0]['sum(hours)'],
    (int)$data13[0]['sum(hours)'],
    (int)$data14[0]['sum(hours)'],
];
rsort($content_hour_array);
rsort($language_hour_array);
$content_color_array = [];
for ($u = 0; $u <= 2; $u++) {
    for ($m = 4; $m <= 6; $m++) {
        if ($content_hour_array[$u] == (int)${"data" . ($m)}[0]['sum(hours)']) {
            if (count($content_color_array) == $u) {
                array_push($content_color_array, ${"content_data" . ($u + 4)}[0]['content']);
            }
            // array_push($content_color_array, ${"content_data" . $c}[0]['content']);

        }
    }
}
// var_dump($content_color_array);
$language_color_array = [
    0,0,0,0,0,0,0,0
];
for ($k = 0; $k <= 7; $k++) {
    for($z=7;$z<=14;$z++){
        if ($language_hour_array[$k] == (int)${"data" . $z}[0]['sum(hours)']) {
                if($language_color_array[$k]==0){
                    $language_color_array[$k]=${"language_data" . $z}[0]['language'];
                };
                print_r($language_color_array[$k]);
        }
    }
}
// print_r($language_color_array);
// var_dump($language_color_array);
// var_dump($content_color_array);
// var_dump($content_color_array);
// var_dump($language_color_array);
$date_array = [];
for ($j = 1; $j <= 31; $j++) {
    ${"date_stmt" . $j} = $dbh->prepare("SELECT date,sum(hours) from time where date =" . $j . " AND month = " . $month . " AND year = " . $year . ";"); //日付の合計時間
    ${"date_stmt" . $j}->execute();
    ${"date_data" . $j} = ${"date_stmt" . $j}->fetchAll();
    if (${"date_data" . $j}[0]['sum(hours)'] == NULL) {
        ${"date_data" . $j}[0]['sum(hours)'] = 0;
    }
    array_push($date_array, ${"date_data" . $j}[0]["sum(hours)"]);
    // array_push($date_array, ${"date_data" . $j}[0]["sum(hours)"]);
};
// var_dump($date_data1);
// echo $date_array[1]["sum(hours)"];
// var_dump($date_array);
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
<!-- <pre>
        <!-- <?php var_dump($language_color_array); ?> -->
<!-- <?php var_dump($language_hour_array); ?> -->
<!-- javascript,css,sqlが同列4位で3回ループしてる時間のランキングでは正常 -->
<!-- </pre> -->

<body>
    <header>
        <div class="logo-week">
            <img src="./img/posse_logo.png" alt="posseのロゴ" class="logo">
            <div class="week">4th week</div>
            とりあえず汚くていいから完成させるフィードバックもらう
            パーセント表示反映できてないplugin.jsを編集
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
                    <div class="number">
                        <?php echo $data1[0]['sum(hours)']; ?>
                    </div>
                    <div class="hour">hour</div>
                </div>
                <div class="month-container">
                    <div class="month">Month</div>
                    <div class="number">
                        <?php echo $data2[0]['sum(hours)']; ?>
                    </div>
                    <div class="hour">hour</div>
                </div>
                <div class="total-container">
                    <div class="total">Total</div>
                    <div class="number">
                        <?php echo $data3[0]['sum(hours)']; ?>
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
                        <li><i class="fas fa-circle" style="color:#0345EC"></i><?php echo $language_color_array[0]; ?></li>
                        <li><i class="fas fa-circle" style="color:#0F71BD"></i><?php echo $language_color_array[1]; ?></li>
                        <li><i class="fas fa-circle" style="color:#20BDDE"></i><?php echo $language_color_array[2]; ?></li>
                        <li><i class="fas fa-circle" style="color:#3CCEFE"></i><?php echo $language_color_array[3]; ?></li>
                        <li><i class="fas fa-circle" style="color:#B29EF3"></i><?php echo $language_color_array[4]; ?></li>
                        <li><i class="fas fa-circle" style="color:#6D46EC"></i><?php echo $language_color_array[5]; ?></li>
                        <li><i class="fas fa-circle" style="color:#4A17EF"></i><?php echo $language_color_array[6]; ?></li>
                        <li><i class="fas fa-circle" style="color:#3105C0"></i><?php echo $language_color_array[7]; ?></li>
                    </ul>
                </div>
            </div>
            <div class="material-chart-container">
                <div class="piechart-title">学習コンテンツ</div>
                <canvas id="material-chart-doughnut" width="15" height="10"></canvas>
                <div>
                    <ul class="material">
                        <li><i class="fas fa-circle" style="color:#0345EC"></i><?php echo $content_color_array[0]; ?></li>
                        <li><i class="fas fa-circle" style="color:#0F71BD"></i><?php echo $content_color_array[1]; ?></li>
                        <li><i class="fas fa-circle" style="color:#20BDDE"></i><?php echo $content_color_array[2]; ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- 月移動 -->
    <div class="calender">
        <button id="previous-month" class="calender-arrow">&lt;</button>
        <div id="year-month"></div>
        <button id="next-month" class="calender-arrow">&gt;</button>
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
                            Laravel
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
                        <input id="time" placeholder="半角数字で入力してください" size="20" class="textbox" oninput="value = value.replace(/[^\d]+/i,'');" / required></textarea>
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
                    <?php echo $date_array[1]; ?>,
                    <?php echo $date_array[3]; ?>,
                    <?php echo $date_array[5]; ?>,
                    <?php echo $date_array[7]; ?>,
                    <?php echo $date_array[9]; ?>,
                    <?php echo $date_array[11]; ?>,
                    <?php echo $date_array[13]; ?>,
                    <?php echo $date_array[15]; ?>,
                    <?php echo $date_array[17]; ?>,
                    <?php echo $date_array[19]; ?>,
                    <?php echo $date_array[21]; ?>,
                    <?php echo $date_array[23]; ?>,
                    <?php echo $date_array[25]; ?>,
                    <?php echo $date_array[27]; ?>,
                    <?php echo $date_array[29]; ?>,
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
                            max: 12, // 最大値
                            stepSize: 2, // 軸間隔
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
                '<?php echo $language_color_array[0]; ?>',
                '<?php echo $language_color_array[1]; ?>',
                '<?php echo $language_color_array[2]; ?>',
                '<?php echo $language_color_array[3]; ?>',
                '<?php echo $language_color_array[4]; ?>',
                '<?php echo $language_color_array[5]; ?>',
                '<?php echo $language_color_array[6]; ?>',
                '<?php echo $language_color_array[7]; ?>'
            ],
            datasets: [{
                data: [
                    <?php echo $language_hour_array[0]; ?>,
                    <?php echo $language_hour_array[1]; ?>,
                    <?php echo $language_hour_array[2]; ?>,
                    <?php echo $language_hour_array[3]; ?>,
                    <?php echo $language_hour_array[4]; ?>,
                    <?php echo $language_hour_array[5]; ?>,
                    <?php echo $language_hour_array[6]; ?>,
                    <?php echo $language_hour_array[7]; ?>,
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
            labels: ["<?php echo $content_color_array[0]; ?>", "<?php echo $content_color_array[1]; ?>", "<?php echo $content_color_array[2]; ?>"],
            datasets: [{
                data: [
                    <?php echo $content_hour_array[0]; ?>,
                    <?php echo $content_hour_array[1]; ?>,
                    <?php echo $content_hour_array[2]; ?>
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