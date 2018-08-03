<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');


// データベースに接続
session_start();
require_once('dbconnect.php');

// 直接このページに来たらsignin.phpに飛ぶようにする
if(!isset($_SESSION['id'])){
    header('Location:signin.php');
    exit();
}

// ユーザーのSQLから配列を受け取る
$data=[];
$id =[];
$sql = 'SELECT * FROM `users` WHERE `id`=? ';
$data = array( $_SESSION['id']);
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

$signin_user = $stmt->fetch(PDO::FETCH_ASSOC);


// 初期化
$errors  = array();

// 写真の配列からデータを受け取る
$sql = 'SELECT * FROM `feeds` ORDER BY `id` DESC';
$stmt = $dbh->prepare($sql);
$stmt->execute();

$comments = array();
    while (1) {
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    if($rec == false) {
    break;
    }
    $comments[] = $rec;
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
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li class="active" style="margin: 0 15px 0 15px;"><a href="post.php">Post photos</a></li>

            <!-- ユーザーID取得 -->
            <li class="dropdown" style="background-color: #fff;">
                <span hidden id="signin-user"><? $signin_user['id']; ?></span>
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="user_profile_img/<?php echo $signin_user['img_name']; ?>" width="20" class="img-circle"><?php echo $signin_user['name']; ?><span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="#">マイページ</a></li>
                    <li><a href="signout.php">サインアウト</a></li>
                </ul>
            </li>
          </ul>
          <!-- ここまで -->
        </div>
      </div>
    </div>


  	<div id="hello">
  	    <div class="container">
  	    	<div class="row">
  	    		<div class="col-lg-8 col-lg-offset-2 centered">
  	    			<h1>My Memories</h1>
  	    			<h2>~ In Cebu ~</h2>
  	    		</div><!-- /col-lg-8 -->
  	    	</div><!-- /row -->
  	    </div> <!-- /container -->
  	</div><!-- /hello -->
  	
  	
  	<div class="container">
      <div class="main-contents">
    		<div class="row centered mt grid">
    			<h3>Album</h3>

            <?php if($comments["user_id"] == $_SESSION["id"]): ?>
            <?php foreach ($comments as $comment): ?>
    			<div class="col-lg-4">
    				<a href="detail.php?id=<?php echo $comment["id"]; ?>" class="trim"><img class="picture" src="post_img/<?php echo $comment['img_name']; ?>" class="img-responsive img-thumbnail"></a>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>

        </div> 
  		</div>
  	</div>

  	<div id="f">
  		<div class="container">
  			<div class="row">
  				<p>I <i class="fa fa-heart"></i> Cubu.</p>
  			</div>
  		</div>
    </div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/bootstrap.js"></script>
  </body>
</html>