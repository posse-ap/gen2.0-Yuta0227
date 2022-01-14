<?php
$dsn = 'mysql:dbname=quizy;port=3306;host=db;charset=utf8;';
$user = 'root';
$password = 'secret';



// (1) 取得するデータのidを指定
$id = 1;

// (2) データベースに接続
try{
    $pdo = new PDO($dsn, $user, $password);
    print("phpとmysql接続成功");
}catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
}
// (3) SQL作成
$stmt = $pdo->prepare("SELECT name FROM big_questions WHERE id = :id");

// (4) 登録するデータをセット
$stmt->bindParam( ':id', $id, PDO::PARAM_INT);

// (5) SQL実行
$res = $stmt->execute();

// (6) 該当するデータを取得
if( $res ) {
	$data = $stmt->fetch();
	var_dump($data);
}

// (7) データベースの接続解除
$pdo = null;
?>
<html lang="ja">
<html>
<?php include 'head.php'; ?>
<?php include 'header.php'; ?>

<body>
    <div id="fade-filter"></div>
    <div id="content-container" class="content-container">
        <?php include 'common.php'; ?>
        <div id="entire"></div>
    </div>
</body>

</html>
<script src="index.js"></script>