<?php
session_start();

// データベースに接続
require_once('dbconnect.php');

// 直接このページに来たらsignup.phpに飛ぶようにする
if(!isset($_SESSION['register'])){
    header('Location:signup.php');
    exit();
}
//出力テスト
$name = $_SESSION['register']['name'];
$email = $_SESSION['register']['email'];
$password = $_SESSION['register']['password'];
$img_name = $_SESSION['register']['img_name'];

// 登録ボタンが押された時のみ処理するif文
if(!empty($_POST)){
// この中のデータベース登録処理を記述します
    $sql = 'INSERT INTO `users` SET `name`=?, `email`=?, `password`=?, `img_name`=?, `created`=NOW()';
    $data = array($name, $email, password_hash($password, PASSWORD_DEFAULT), $img_name);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    unset($_SESSION['register']);
    header('Location: thanks.php');
    exit();

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>My Memories</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/css/main.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="assets/js/chart.js"></script>
</head>

<body>
    <!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href=""><i class="fa fa-heart" style="color: #fff;"></i></a>
            </div>
        </div>
    </div>
    <!-- ここから -->
    <div class="row">
        <!-- ここから -->
        <div class="col-xs-8 col-xs-offset-2 thumbnail">
            <h2 class="text-center content_header">アカウント情報確認</h2>
            <div class="row">
                <div class="col-xs-4">
                    <img src="user_profile_img/<?php echo htmlspecialchars($img_name); ?>" class="img-responsive img-thumbnail">
                </div>
                <div class="col-xs-8">
                    <div>
                        <span>ユーザー名</span>
                        <p class="lead"><?php echo htmlspecialchars($name); ?></p>
                    </div>
                    <div>
                        <span>メールアドレス</span>
                        <p class="lead"><?php echo htmlspecialchars($email); ?></p>
                    </div>
                    <div>
                        <span>パスワード</span>
                        <!-- ② -->
                        <p class="lead">●●●●●●●●</p>
                    </div>
                    <!-- ③ -->
                    <form method="POST" action="">
                        <!-- ④ -->
                        <a href="signup.php?action=rewrite" class="btn btn-default">&laquo;&nbsp;戻る</a> | 
                        <!-- ⑤ -->
                        <input type="hidden" name="action" value="submit">
                        <input type="submit" class="btn btn-primary" value="ユーザー登録">
                    </form>
                </div>
            </div>
        </div>
    </div>

        <!-- ここまで -->

<footer>
    <div id="f">
        <div class="container">
            <div class="row">
                <p>I <i class="fa fa-heart"></i> Cubu.</p>
            </div>
        </div>
    </div>
</footer>
        <script src="../assets/js/jquery-3.1.1.js"></script>
        <script src="../assets/js/jquery-migrate-1.4.1.js"></script>
        <script src="../assets/js/bootstrap.js"></script>
</body>
</html>