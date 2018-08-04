<?php
    session_start();
    require_once('dbconnect.php');
    date_default_timezone_set('Asia/Manila');

    $title = '';
    $date = '';
    $detail = '';
    $errors = [];

    // ユーザー情報取得
    $data=[];
    $id = [];
    $sql = 'SELECT * FROM `users` WHERE `id`=? ';
    $data = array($_SESSION['id']);
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    $signin_user = $stmt->fetch(PDO::FETCH_ASSOC);



        // emptyは空かどうかを調べる
        // isssetは変数が存在するかどうかチェック

    // 空のものがあるとポスト送信しない
    if(!empty($_POST)){
        $title = $_POST['input_title'];
        $date = $_POST['input_date'];
        $detail = $_POST['input_detail'];

        // 空チェックのバリデーション
        // ifemptyを使うと０もbkankとして処理されてしまう
        $count_title = mb_strlen($title);
        if($title ==''){
            $errors['title'] = 'blank';
        } elseif ($count_title > 24) {
            $errors['title'] = 'length';
        }

        if($detail == ''){
            $errors['date'] = 'blank';
        }


        $count_detail = mb_strlen($detail);
        if($detail == ''){
            $errors['detail'] = 'blank';
        } elseif ($count_detail > 140 ){
            $errors['detail'] = 'length';
        }

        // 画像名を取得
        $file_name = '';
        if(!isset($_GET['action'])){
            $file_name = $_FILES['input_img_name']['name'];
        }

        if(!empty($file_name)){ 
            // 拡張子のチェック
            $file_type =substr($file_name,-4);
            $file_type = strtolower($file_type);

             if($file_type != '.jpg' && $file_type != '.png' && $file_type != '.gif' && $file_type != 'jpge'){
                $errors['img_name'] = 'type';
            }
        }else {
            $errors['img_name'] = 'blank';
        }

                // もしエラーがなかったら以下の処理を行う
        if (empty($errors)){
            $date_str = date('YmdHis');
            $submit_file_name = $date_str.$file_name;
            move_uploaded_file($_FILES['input_img_name']['tmp_name'],'post_img/'.$submit_file_name);
        
        $sql = 'INSERT INTO `feeds` SET `title`=?, `date`=?, `detail`=?, `img_name`=? ,`user_id`=? ';
        $data = array($title,$date,$detail,$submit_file_name,$_SESSION['id']);
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);

        header('Location: index.php');
        exit();
        $dbh = null;
        }
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
          <!-- ここまで -->
        </div>
      </div>
    </div>
  
    
    <div class="container">
      <div class="col-xs-8 col-xs-offset-2 thumbnail">
        <h2 class="text-center content_header">写真投稿</h2>
        <form method="POST" action="" enctype="multipart/form-data">
          <div class="form-group">
            <label for="title">タイトル</label>
            <input type="text" name="input_title" class="form-control" id="title" placeholder="タイトルを24字以内で入力してください" value="<?php echo htmlspecialchars($title); ?>">
            <?php if (isset($errors['title']) && $errors['title'] == 'blank'): ?>
                <p class="text-danger">タイトルを入力してください</p>
            <?php endif; ?>
            <?php if (isset($errors['title']) && $errors['title'] == 'length') :?>
                <p class="text-danger">タイトルは24字以内で入力してください</p>
            <?php endif; ?>
            
          </div>


          <div class="form-group">
            <label for="date">日付</label>
            <input type="date" name="input_date" class="form-control" value="<?php echo htmlspecialchars($date); ?>">
            <?php if(isset($errors['date']) && $errors['date'] == 'blank'): ?>
                <p class="text-danger">日付を入力してください</p>
            <?php endif; ?>
          </div>

          <div class="form-group">
            <label for="detail">詳細</label>
            <input type="text" name="input_detail" class="form-control" rows="4" placeholder="場所、天気、カメラなどの詳細を140字以内で記述してください" value="<?php echo htmlspecialchars($detail); ?>">
            
            <?php if(isset($errors['detail']) && $errors['detail'] == 'blank'): ?>
                <p class="text-danger">詳細を入力してください</p>
            <?php endif; ?>
            <?php if (isset($errors['detail']) && $errors['detail'] == 'length') :?>
                <p class="text-danger">詳細は140字以内で入力してください</p>
            <?php endif; ?>
          </div>

          <div class="form-group">
            <label for="img_name">写真</label>
            <input type="file" name="input_img_name" id="image/*"
            id="img_name">
            <?php if(isset($errors['img_name']) && $errors['img_name'] == 'blank'): ?>
            <p class="text-danger">画像を選択してください</p>
            <?php endif; ?>
            <?php if(isset($errors['img_name']) && $errors['img_name'] == 'type'): ?>
            <p class="text-danger">拡張子が「jpg」「png」「gif」「jpge」の画像を選択して下さい</p>
            <?php endif; ?>
          </div>

          <br>

          <ul class="nav navbar-nav navbar-left">
            <li class="active"><a href="index.php" style="margin: 12px;">戻る</a></li>
          </ul>
          <input type="submit" class="btn btn-primary" value="投稿">
        </form>
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
