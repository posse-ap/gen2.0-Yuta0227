<html>

<head>
    <title>User List</title>
</head>

<body>
    <form action="big_questions.php" method="post">
        ID:<input type="text" name="id" value="<?php echo $_POST['id'] ?>">
        <?php
        if (preg_match("/[^0-9A-Za-z]/", $_POST['id'])) {
            echo " IDは英数字で入力してください！";
        }
        ?>
        <br>
        Name:<input type="text" name="user_name" value="<?php echo $_POST['user_name'] ?>"><br>
        <input type="submit">
    </form>
    <table>
        <tr>
            <th>ID</th>
            <th>User Name</th>
        </tr>
        <!-- ここでPHPのforeachを使って結果をループさせる -->
        <?php foreach ($stmt as $row) : ?>
            <tr>
                <td><?php echo $row[0] ?></td>
                <td><?php echo $row[1] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quizy</title>
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="index.css">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <script>
        window.twttr = (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0],
                t = window.twttr || {};
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "https://platform.twitter.com/widgets.js";
            fjs.parentNode.insertBefore(js, fjs);
            t._e = [];
            t.ready = function(f) {
                t._e.push(f);
            };
            return t;
        }(document, "script", "twitter-wjs"));
    </script>
</head>
<header>
    <div class="header-left">
        <i id="overlay-button" class="fas fa-bars"></i>
        <a href="kuizy.html" class="kuizy">kuizy</a>
    </div>
    <div class="header-right">
        <a href="create-quiz.html" class="create-quiz-button">クイズ・診断を作る</a>
        <a href="search.html" class="search-button">
            <i class="fas fa-search"></i>
            <div class="search-text">検索</div>
        </a>
    </div>
</header>
<nav class="overlay" id="overlay">
    <div></div>
    <a>ログイン</a>
    <a>クイズ</a>
    <a>診断</a>
    <a>お絵描き診断</a>
    <a>お絵描きしりとり</a>
    <a>スマートフォンアプリ</a>
    <a>作者ランキング</a>
    <a>公式Twitter</a>
    <a>よくある質問</a>
    <a>お問い合わせ</a>
    <a>利用規約</a>
    <a>プライバシーポリシー</a>
    <a>運営会社</a>
    <p>© 2021 Nooon LLC</p>
</nav>

<body>
    <div id="fade-filter"></div>
    <div id="content-container" class="content-container">
        <div class="menu-container">
            <a href="quiz.html" class="menu-black-text">
                <i class="fas fa-book"></i>
                <div class="text">クイズ</div>
            </a>
            <a href="assessment.html" class="menu-black-text">
                <i class="far fa-file-alt"></i>
                <div class="text">診断</div>
            </a>
            <a href="drawing.html" class="menu-black-text">
                <i class="fas fa-pen-nib fa-flip-vertical"></i>
                <div class="text">お絵描き診断</div>
            </a>
            <a href="login.html" class="menu-black-text">
                <i class="fas fa-sign-in-alt"></i>
                <div class="text">ログイン</div>
            </a>
        </div>
        <a href="pvp-game.html" class="pvp-game">今Kuizyお絵描きしりとりで対戦相手が待っています🎨！<span class="play-now">今すぐ遊ぶ！</span></a>
        <h1 class="title">ガチで東京の人しか解けない！ #東京の難読地名クイズ</h1>
        <a href="account.html" class="account">
            <img src="https://pbs.twimg.com/profile_images/1352968042024562688/doQgizBj_normal.jpg" alt="クイジーのロゴ">
            <p>@kuizy_net</p>
        </a>
        <a href="tokyo.html" class="tokyo">東京</a>
        <p>
            ビュー数<span class="red-color">100</span>
            平均正答率<span class="red-color">100%</span>
            全問正答率<span class="red-color">100%</span>
        </p>
        <p class="gray-color">正答率などの反映は少し遅れることがあります。</p>
        <div class="sns-container">
            <a href="https://twitter.com/share" data-dnt="true">
                <i class="fab fa-twitter-square skyblue-color fa-5x"></i>
            </a>
            <a href="https://www.facebook.com/sharer/sharer.php?u=https://syncer.jp/">
                <i class="fab fa-facebook-square darkblue-color fa-5x"></i>
            </a>
            <a href="http://line.me/R/msg/text/?{message}">
                <i class="fab fa-line lightgreen-color fa-5x"></i>
            </a>
        </div>
        <div id="entire"></div>
    </div>


    <script src="index.js"></script>

</body>

</html>

</html>