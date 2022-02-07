<?php
require "db-connect.php";
?>

<html lang="ja">
<html>
<?php include 'head.php'; ?>
<?php include 'header.php'; ?>

<body>
    <div id="fade-filter"></div>
    <div id="content-container" class="content-container">
        <?php include 'common.php';
        $id = $_GET['id'];
        // (3) SQL作成
        $stmt1 = $pdo->query("SELECT * FROM big_questions");
        $stmt2 = $pdo->query("SELECT image from questions where big_question_id=$id");
        // (4) 登録するデータをセット
        // $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        // (5) SQL実行
        // $res = $stmt->execute();
        
        // (6) 該当するデータを取得
        // if ($res) {
            ?>
        <pre>
            <?php
            // $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $data1 = $stmt1->fetchAll();
            $data2 = $stmt2->fetchAll();
            print_r($data1[$id-1]["id"]);
            print_r($data1[$id-1]["name"].PHP_EOL);
            ?>
            <!-- <img src="./asset/<?php echo($data2[0]["image"].PHP_EOL);?>">
            <img src="./asset/<?php echo($data2[1]["image"].PHP_EOL);?>"> -->
        </pre>
        <?php
        // }
        // (7) データベースの接続解除
        $pdo = null; ?>
        <div id="entire"></div>
    </div>
</body>

</html>
<script>
'use strict';
const entire = document.getElementById('entire');
let correct = ['たかなわ', 'かめいど', 'こうじまち', 'おなりもん', 'とどろき', 'しゃくじい', 'ぞうしき', 'おかちまち', 'ししぼね', 'こぐれ'];
let uncorrect1 = ['こうわ', 'かめと', 'おかとまち', 'おかどもん', 'たたりき', 'いじい', 'ざっしき', 'ごしろちょう', 'ろっこつ', 'こばく'];
let uncorrect2 = ['たかわ', 'かめど', 'かゆまち', 'ごせいもん', 'たたら', 'せきこうい', 'ざっしょく', 'みとちょう', 'しこね', 'こしゃく'];
let img = [
    "https://d1khcm40x1j0f.cloudfront.net/quiz/34d20397a2a506fe2c1ee636dc011a07.png",
    "https://d1khcm40x1j0f.cloudfront.net/quiz/512b8146e7661821c45dbb8fefedf731.png",
    "https://d1khcm40x1j0f.cloudfront.net/quiz/ad4f8badd896f1a9b527c530ebf8ac7f.png",
    "https://d1khcm40x1j0f.cloudfront.net/quiz/ee645c9f43be1ab3992d121ee9e780fb.png",
    "https://d1khcm40x1j0f.cloudfront.net/quiz/6a235aaa10f0bd3ca57871f76907797b.png",
    "https://d1khcm40x1j0f.cloudfront.net/quiz/0b6789cf496fb75191edf1e3a6e05039.png",
    "https://d1khcm40x1j0f.cloudfront.net/quiz/23e698eec548ff20a4f7969ca8823c53.png",
    "https://d1khcm40x1j0f.cloudfront.net/quiz/50a753d151d35f8602d2c3e2790ea6e4.png",
    "https://d1khcm40x1j0f.cloudfront.net/words/8cad76c39c43e2b651041c6d812ea26e.png",
    "https://d1khcm40x1j0f.cloudfront.net/words/34508ddb0789ee73471b9f17977e7c9c.png"
];
let text = [
    "正解は「たかなわ」です！",
    "正解は「かめいど」です！",
    "正解は「こうじまち」です！",
    "正解は「おなりもん」です！",
    "正解は「とどろき」です！",
    "正解は「しゃくじい」です！",
    "正解は「ぞうしき」です！",
    "正解は「おかちまち」です！",
    "江戸川区にあります。",
    "正解は「こぐれ」です！",
]
let adImg=["","","",""];
let adLink=["","","",""];
let adAlt=["広告1です","あいうえお","広告3です","広告4です"]
const overlay = document.getElementById('overlay');
const overlayButton = document.getElementById('overlay-button');
const body = document.getElementsByTagName('body');

//一応見た目はできてる。画像はmysqlからとれてる。選択肢、問題番号とれてない。正解表示のテキストmysqlからとれてない
let main = "";
<?php for ($i = 0; $i < 2; $i++) {?>
        main+=`<span id="question<?php echo $i;?>" class="question">`
        + `<h2 class="question-title"><?php echo $i+1;?>.この地名はなんて読む？</h2>`
        + `<img src="./asset/<?php echo $data2[$i]["image"];?>">`
        + `<section id="section<?php echo $i;?>">`
        + `<a href="#question<?php echo $i+1;?>}">`
        + `<div id="correct-choice<?php echo $i;?>" class="choice">${correct[<?php echo $i;?>]}</div>`
        + `</a>`
        + `<a href="#question<?php echo $i+1;?>">`
        + `<div id="uncorrect-choice<?php echo $i;?>1" class="choice">${uncorrect1[<?php echo $i;?>]}</div>`
        + `</a>`
        + `<a href="#question<?php echo $i+1;?>">`
        + `<div id="uncorrect-choice<?php echo $i;?>2" class="choice">${uncorrect2[<?php echo $i;?>]}</div>`
        + `</a>`
        + `</section>`
        + `<div id="text-box<?php echo $i;?>" class="text-box">`
        + `<div id="answer<?php echo $i;?>" class="answer"></div>`
        + `<div id="text<?php echo $i;?>" class="show-explanation">${text[<?php echo $i;?>]}</div>`
        + `</div>`
        + `</span>`
    entire.innerHTML = main;   
<?php };?>
<?php for ($i = 0; $i < 2; $i++) {?>
    function shuffle() {
        for (let j = document.getElementById(`section<?php echo $i;?>`).children.length; j >= 0; j--) {
            document.getElementById(`section<?php echo $i-1;?>`).appendChild(document.getElementById(`section<?php echo $i-1;?>`).children[Math.random() * j | 0]);
        }
    }
    window.addEventListener("load", function () {
        document.getElementById(`text-box<?php echo $i;?>`).classList.toggle('switch-display');
        shuffle();
    });
<?php };?>
// innerHTMLとロード時とクリック時の文を分ける
<?php for ($i = 0; $i < 2; $i++) {?>
    document.getElementById(`correct-choice<?php echo $i;?>`).onclick = function () {
        document.getElementById(`correct-choice<?php echo $i;?>`).classList.toggle('unclickable');//一度押したら押せない
        document.getElementById(`uncorrect-choice<?php echo $i;?>1`).classList.toggle('unclickable');
        document.getElementById(`uncorrect-choice<?php echo $i;?>2`).classList.toggle('unclickable');
        document.getElementById(`correct-choice<?php echo $i;?>`).classList.toggle('correct-color');//正解を青色にする//
        document.getElementById(`text-box<?php echo $i;?>`).classList.toggle('switch-display');
        document.getElementById(`answer<?php echo $i;?>`).innerHTML = "正解!";
        document.getElementById(`correct-choice<?php echo $i;?>`).classList.toggle('white-color');
    };
    document.getElementById(`uncorrect-choice<?php echo $i;?>1`).onclick = function () {
        document.getElementById(`correct-choice<?php echo $i;?>`).classList.toggle('unclickable');//一度押したら押せない
        document.getElementById(`uncorrect-choice<?php echo $i;?>1`).classList.toggle('unclickable');
        document.getElementById(`uncorrect-choice<?php echo $i;?>2`).classList.toggle('unclickable');
        document.getElementById(`uncorrect-choice<?php echo $i;?>1`).classList.toggle('uncorrect-color');//不正解をオレンジ色にする//
        document.getElementById(`correct-choice<?php echo $i;?>`).classList.toggle('correct-color');//正解を青色にする//
        document.getElementById(`text-box<?php echo $i;?>`).classList.toggle('switch-display');
        document.getElementById(`answer<?php echo $i;?>`).innerHTML = "不正解!";
        document.getElementById(`uncorrect-choice<?php echo $i;?>1`).classList.toggle('white-color');
    };
    document.getElementById(`uncorrect-choice<?php echo $i;?>2`).onclick = function () {
        document.getElementById(`correct-choice<?php echo $i;?>`).classList.toggle('unclickable');//一度押したら押せない
        document.getElementById(`uncorrect-choice<?php echo $i;?>1`).classList.toggle('unclickable');
        document.getElementById(`uncorrect-choice<?php echo $i;?>2`).classList.toggle('unclickable');
        document.getElementById(`uncorrect-choice<?php echo $i;?>2`).classList.toggle('uncorrect-color');//不正解をオレンジ色にする//
        document.getElementById(`correct-choice<?php echo $i;?>`).classList.toggle('correct-color');//正解を青色にする//
        document.getElementById(`text-box<?php echo $i;?>`).classList.toggle('switch-display');
        document.getElementById(`answer<?php echo $i;?>`).innerHTML = "不正解!";
        document.getElementById(`uncorrect-choice<?php echo $i;?>2`).classList.toggle('white-color');
    };
<?php };?>

overlayButton.addEventListener("click", function () {
    overlayButton.classList.toggle('unclickable');
    overlay.classList.add('show-overlay');
    document.getElementById('fade-filter').classList.add('show-fade-filter');
})
/**
 * 引数：クリックイベントが発生した位置を取得するための変数です
 */
document.body.addEventListener("click", function (event) {
    let x = event.pageX / window.screen.width;
    if (x > 0.5 && overlay.classList.contains('show-overlay')) {
        overlay.classList.remove('show-overlay')
        overlayButton.classList.remove('unclickable');
        document.getElementById('fade-filter').classList.remove('show-fade-filter');
    }
})
</script>
