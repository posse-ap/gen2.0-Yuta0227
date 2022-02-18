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
        <?php
        $id = $_GET['id'];
        // (3) SQL作成
        $stmt1 = $pdo->prepare("SELECT * from mix where big_question_id=?");
        $stmt2 = $pdo->prepare("SELECT id from mix where big_question_id=?");
        $stmt3 = $pdo->prepare("SELECT distinct question_id from mix where big_question_id=?");
        $stmt4 = $pdo->prepare("SELECT name from mix where valid=1 and big_question_id=?");
        $stmt5 = $pdo->prepare("SELECT name from mix where valid=0 and big_question_id=?");
        $stmt6 = $pdo->prepare("SELECT distinct image from mix where big_question_id=?");
        $stmt7 = $pdo->prepare("SELECT big_question_name from big_questions where id=?");
        $stmt8 = $pdo->prepare("SELECT place from place where id=?");
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
            for ($i = 1; $i < 9; $i++) {
                ${"stmt".$i}->execute([$id]);
                ${"data" . $i} = ${"stmt" . $i}->fetchAll();
            };
            // foreach($data2 as $data){
            //     echo ($data["id"].PHP_EOL);
            // }
            // foreach使い方
            ?>
        </pre>
        <?php
        // }
        // (7) データベースの接続解除
        $pdo = null; ?>
        <?php include 'common.php'; ?>
        <div id="entire"></div>
    </div>
</body>

</html>
<script>
    'use strict';
    const entire = document.getElementById('entire');
    let correct = ['<?php echo $data4[0]["name"]; ?>', '<?php echo $data4[1]["name"]; ?>', ''];//2,3,4,5,6,
    let uncorrect1 = ['<?php echo $data5[0]["name"]; ?>', '<?php echo $data5[2]["name"]; ?>', ''];//4,6,8,
    let uncorrect2 = ['<?php echo $data5[1]["name"]; ?>', '<?php echo $data5[3]["name"]; ?>', ''];//5,7,9,
    const overlay = document.getElementById('overlay');
    const overlayButton = document.getElementById('overlay-button');
    const body = document.getElementsByTagName('body');

    let main = "";
    <?php for ($i = 0; $i < 2; $i++) { ?>
        main += `<span id="question<?php echo $i; ?>" class="question">` +
            `<h2 class="question-title"><?php echo $i + 1; ?>.この地名はなんて読む？</h2>` +
            `<img src="./asset/<?php echo $data6[$i]["image"]; ?>">` +
            `<section id="section<?php echo $i; ?>">` +
            `<a href="#question<?php echo $i + 1; ?>}">` +
            `<div id="correct-choice<?php echo $i; ?>" class="choice">${correct[<?php echo $i; ?>]}</div>` +
            `</a>` +
            `<a href="#question<?php echo $i + 1; ?>">` +
            `<div id="uncorrect-choice<?php echo $i; ?>1" class="choice">${uncorrect1[<?php echo $i; ?>]}</div>` +
            `</a>` +
            `<a href="#question<?php echo $i + 1; ?>">` +
            `<div id="uncorrect-choice<?php echo $i; ?>2" class="choice">${uncorrect2[<?php echo $i; ?>]}</div>` +
            `</a>` +
            `</section>` +
            `<div id="text-box<?php echo $i; ?>" class="text-box">` +
            `<div id="answer<?php echo $i; ?>" class="answer"></div>` +
            `<div id="text<?php echo $i; ?>" class="show-explanation">正解は「<?php echo $data4[$i]["name"]; ?>」です!</div>` +
            `</div>` +
            `</span>`
        entire.innerHTML = main;
    <?php };?>
    function shuffle() {
        <?php for ($j = 3; $j > 0; $j--){;?>
            <?php for ($i = 0;$i < 2;$i++){;?>
                document.getElementById(`section<?php echo $i;?>`).appendChild(document.getElementById(`section<?php echo $i; ?>`).children[Math.random() * <?php echo $j;?> | 0]);
            <?php };?>
        <?php };?>
    };
    <?php for ($i = 0; $i < 2; $i++) { ?>
        window.addEventListener("load", function() {
            document.getElementById(`text-box<?php echo $i; ?>`).classList.toggle('switch-display');
            shuffle();
        });
    <?php };?>
    <?php for ($i = 0; $i < 2; $i++) { ?>
        // innerHTMLとロード時とクリック時の文を分ける
        document.getElementById(`correct-choice<?php echo $i; ?>`).onclick = function() {
            document.getElementById(`correct-choice<?php echo $i; ?>`).classList.toggle('unclickable'); //一度押したら押せない
            document.getElementById(`uncorrect-choice<?php echo $i; ?>1`).classList.toggle('unclickable');
            document.getElementById(`uncorrect-choice<?php echo $i; ?>2`).classList.toggle('unclickable');
            document.getElementById(`correct-choice<?php echo $i; ?>`).classList.toggle('correct-color'); //正解を青色にする//
            document.getElementById(`text-box<?php echo $i; ?>`).classList.toggle('switch-display');
            document.getElementById(`answer<?php echo $i; ?>`).innerHTML = "正解!";
            document.getElementById(`correct-choice<?php echo $i; ?>`).classList.toggle('white-color');
        };
        document.getElementById(`uncorrect-choice<?php echo $i; ?>1`).onclick = function() {
            document.getElementById(`correct-choice<?php echo $i; ?>`).classList.toggle('unclickable'); //一度押したら押せない
            document.getElementById(`uncorrect-choice<?php echo $i; ?>1`).classList.toggle('unclickable');
            document.getElementById(`uncorrect-choice<?php echo $i; ?>2`).classList.toggle('unclickable');
            document.getElementById(`uncorrect-choice<?php echo $i; ?>1`).classList.toggle('uncorrect-color'); //不正解をオレンジ色にする//
            document.getElementById(`correct-choice<?php echo $i; ?>`).classList.toggle('correct-color'); //正解を青色にする//
            document.getElementById(`text-box<?php echo $i; ?>`).classList.toggle('switch-display');
            document.getElementById(`answer<?php echo $i; ?>`).innerHTML = "不正解!";
            document.getElementById(`uncorrect-choice<?php echo $i; ?>1`).classList.toggle('white-color');
        };
        document.getElementById(`uncorrect-choice<?php echo $i; ?>2`).onclick = function() {
            document.getElementById(`correct-choice<?php echo $i; ?>`).classList.toggle('unclickable'); //一度押したら押せない
            document.getElementById(`uncorrect-choice<?php echo $i; ?>1`).classList.toggle('unclickable');
            document.getElementById(`uncorrect-choice<?php echo $i; ?>2`).classList.toggle('unclickable');
            document.getElementById(`uncorrect-choice<?php echo $i; ?>2`).classList.toggle('uncorrect-color'); //不正解をオレンジ色にする//
            document.getElementById(`correct-choice<?php echo $i; ?>`).classList.toggle('correct-color'); //正解を青色にする//
            document.getElementById(`text-box<?php echo $i; ?>`).classList.toggle('switch-display');
            document.getElementById(`answer<?php echo $i; ?>`).innerHTML = "不正解!";
            document.getElementById(`uncorrect-choice<?php echo $i; ?>2`).classList.toggle('white-color');
        };
    <?php }; ?>

    overlayButton.addEventListener("click", function() {
        overlayButton.classList.toggle('unclickable');
        overlay.classList.add('show-overlay');
        document.getElementById('fade-filter').classList.add('show-fade-filter');
    })
    /**
     * 引数：クリックイベントが発生した位置を取得するための変数です
     */
    document.body.addEventListener("click", function(event) {
        let x = event.pageX / window.screen.width;
        if (x > 0.5 && overlay.classList.contains('show-overlay')) {
            overlay.classList.remove('show-overlay')
            overlayButton.classList.remove('unclickable');
            document.getElementById('fade-filter').classList.remove('show-fade-filter');
        }
    })
</script>