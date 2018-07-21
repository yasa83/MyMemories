<?php
session_start();

// データベースに接続
require_once('dbconnect.php');

// 直接このページに来たらpost.phpに飛ぶようにする
if(!isset($_SESSION['register'])){
    header('Location:post.php');
    exit();
}
//出力テスト
$title = $_SESSION['register']['title'];
$date = $_SESSION['register']['date'];
$detail = $_SESSION['register']['detail'];
$img_name = $_SESSION['register']['img_name'];

// 登録ボタンが押された時のみ処理するif文
if(!empty($_POST)){
    $sql = 'INSERT INTO `feeds` SET `title` =?, `date` = ?,`detail` = ?,`img_name`=?, `created`=NOW()';
    $data = array($title,$date,$detail,$img_name);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    unset($_SESSION['register']);
    header("Location:thanks.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="ja">
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

    <!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href=""><i class="fa fa-camera" style="color: #fff;"></i></a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="index.php">Main Page</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>



    <body style="margin-top: 60px">
        <div class="container">
            <div class="row">
                <!-- ここから -->
            <div class="col-xs-8 col-xs-offset-2 thumbnail">
                <h2 class="text-center content_header">登録確認</h2>
                <div class="row">
                    <div class="col-xs-4">
                        <img src="post_img/<?php echo htmlspecialchars($img_name); ?>" class="img-responsive img-thumbnail">
                    </div>
                    <div class="col-xs-8">
                        <div>
                            <span>タイトル</span>
                            <p class="lead"><?php echo htmlspecialchars($title); ?></p>
                        </div>
                        <div>
                            <span>日付</span>
                            <p class="lead"><?php echo htmlspecialchars($date); ?></p>
                        </div>
                        <div>
                            <span>詳細</span>
                            <!-- ② -->
                            <p class="lead"><?php echo htmlspecialchars($detail); ?></p>
                        </div>
                        <!-- ③ -->
                        <form method="POST" action="">
                            <!-- ④ -->
                            <a href="post.php?action=rewrite" class="btn btn-default">&laquo;&nbsp;戻る</a> | 
                            <!-- ⑤ -->
                            <input type="hidden" name="action" value="submit">
                            <input type="submit" class="btn btn-primary" value="写真投稿">
                        </form>
                    </div>
                </div>
            </div>
            <!-- ここまで -->
            </div>
        </div>
       <script src="assets/js/jquery-3.1.1.js"></script>
        <script src="assets/js/jquery-migrate-1.4.1.js"></script>
        <script src="assets/js/bootstrap.js"></script>
    </body>
</html>