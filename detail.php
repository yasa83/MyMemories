<?php
session_start();
require_once('dbconnect.php');

   // ユーザー情報
    $signin_user =[];
    $id = [];
    $sql = 'SELECT * FROM `users` WHERE `id`=? ';
    $signin_user = array($_SESSION['id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($signin_user);
    $signin_user = $stmt->fetch(PDO::FETCH_ASSOC);


    // DBからデータを取得する処理
    $sql = 'SELECT * FROM `feeds` WHERE `id` = ?';
    $data[] = $_GET['id'];
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);
    $comment = $stmt->fetch(PDO::FETCH_ASSOC);
    $dbh = null;




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


    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
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
                    <li><a href="index.php">マイページ</a></li>
                    <li><a href="signout.php">サインアウト</a></li>
                </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container">
      <div class="main-contents">
        <div class="col-lg-10 col-lg-offset-1 centered">
          
          <div class="col-xs-4">
            
            <a class="trim"><img class="picture" src="post_img/<?php echo $comment['img_name']; ?>" class="img-responsive img-thumbnail"></a>
          </div>
          <div class="col-xs-8">

            <form action="update.php" method="post">
            <div class="details">
              <h3>Title</h3>
              <input type="text" name="title" class="form-control" id="validate-text" placeholder="title" required value="<?php echo $comment['title'] ?>">
              <input type="hidden" name="id" value="<?php echo $comment['id'] ?>">

              <h3>Date</h3>
              <input type="text" name="date" class="form-control" id="validate-text" placeholder="date" required value="<?php echo $comment['date'] ?>">
              <input type="hidden" name="id" value="<?php echo $comment['id'] ?>">

              <h3>Detail</h3>
              <input type="text" name="detail" class="form-control" id="validate-text" placeholder="detail" required value="<?php echo $comment['detail'] ?>">
              <input type="hidden" name="id" value="<?php echo $comment['id'] ?>">
            </div>
            
          </form>
          <div class="edit_btn">
          <button type="submit" class="btn btn-primary col-xs-3" style="margin: 0 30px 0 20px; width: 125px;">Edit</button>
          <a href="delete.php?id=<?php echo $comment["id"]; ?>" class="btn btn-danger" style="color: white">Remove</a>
          </div>


          </div>
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
