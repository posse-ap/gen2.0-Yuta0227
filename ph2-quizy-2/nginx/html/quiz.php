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
        $stmt = $pdo->query("SELECT * FROM big_questions");

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
            $data = $stmt->fetchAll();
            print_r($data[$id-1]["name"]);
            ?>
        </pre>
        <?php
        // }
        // (7) データベースの接続解除
        $pdo = null; ?>
        <div id="entire"></div>
    </div>
</body>

</html>
<script src="index.js"></script>