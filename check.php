<?php
session_start();

// データベースに接続
require_once('../dbconnect.php');

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
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>Learn SNS</title>
        <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="../assets/font-awesome/css/font-awesome.css">
    </head>
    <body style="margin-top: 60px">
        <div class="container">
            <div class="row">
                <!-- ここから -->
            <div class="col-xs-8 col-xs-offset-2 thumbnail">
                <h2 class="text-center content_header">アカウント情報確認</h2>
                <div class="row">
                    <div class="col-xs-4">
                        <img src="../user_profile_img/<?php echo htmlspecialchars($img_name); ?>" class="img-responsive img-thumbnail">
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
            <!-- ここまで -->
            </div>
        </div>
       <script src="../assets/js/jquery-3.1.1.js"></script>
        <script src="../assets/js/jquery-migrate-1.4.1.js"></script>
        <script src="../assets/js/bootstrap.js"></script>
    </body>
</html>