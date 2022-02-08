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
        $stmt1 = $pdo->query("SELECT * from mix where big_question_id=$id");
        $stmt2 = $pdo->query("SELECT id from mix where big_question_id=$id");
        $stmt3 = $pdo->query("SELECT distinct question_id from mix where big_question_id=$id");
        $stmt4 = $pdo->query("SELECT name from mix where valid=1 and big_question_id=$id");
        $stmt5 = $pdo->query("SELECT name from mix where valid=0 and big_question_id=$id");
        $stmt6 = $pdo->query("SELECT distinct image from mix where big_question_id=$id");
        $stmt7 = $pdo->query("SELECT big_question_name from big_questions where id=$id");
        $stmt8 = $pdo->query("SELECT place from place where id=$id");
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
                ${"data" . $i} = ${"stmt" . $i}->fetchAll();
            };
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
    let correct = ['<?php echo $data4[0]["name"]; ?>', '<?php echo $data4[1]["name"]; ?>', 'あ'];
    let uncorrect1 = ['<?php echo $data5[0]["name"]; ?>', '<?php echo $data5[2]["name"]; ?>', 'い'];
    let uncorrect2 = ['<?php echo $data5[1]["name"]; ?>', '<?php echo $data5[3]["name"]; ?>', 'う'];
    const overlay = document.getElementById('overlay');
    const overlayButton = document.getElementById('overlay-button');
    const body = document.getElementsByTagName('body');

    //一応見た目はできてる。画像はmysqlからとれてる。
    //シャッフル二つ目以降の問題しかできてない。テキストと正誤判定のシャッフル別になってる
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
            document.getElementById(`section<?php echo $data3[$i]["question_id"]-1;?>`).appendChild(document.getElementById(`section<?php echo $data3[$i]["question_id"]-1; ?>`).children[Math.random() * <?php echo $j;?> | 0]);
            console.log('<?= $data3[$i]["question_id"]-1;?> 回目のループ(0スタート）シャッフル機能のループ');
            <?php };?>
        <?php };?>
        console.log('<?= $i; ?>回目のループ(0スタート）シャッフル機能');
    };
    <?php for ($i = 0; $i < 2; $i++) { ?>
        console.log('no');
        window.addEventListener("load", function() {
            document.getElementById(`text-box<?php echo $i; ?>`).classList.toggle('switch-display');
            shuffle();
            console.log('<?= $i; ?>回目のループ(0スタート）ロード時');
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