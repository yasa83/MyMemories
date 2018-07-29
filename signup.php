<?php
    session_start();

    date_default_timezone_set('Asia/Manila');

    $name = '';
    $email = '';
    $errors = [];

    //check.phpから戻って来たときの処理
    if(isset($_GET['action']) && $_GET['action'] == 'rewrite'){
        $_POST['input_name'] = $_SESSION['register']['name'];
        $_POST['input_email'] = $_SESSION['register']['email'];
        $_POST['input_password'] = $_SESSION['register']['password'];

        $errors['rewrite'] =true;
    }

    //空のものがあるとポスト送信しない
    if(!empty($_POST)){
        $name = $_POST['input_name'];
        $email = $_POST['input_email'];
        $password = $_POST['input_password'];

        // ユーザーの空チェック
        if($name == ''){
            $errors['name'] = 'blank';
        }

        if($email == ''){
            $errors['email'] = 'blank';
        }

        $count = strlen($password);
        if($password == ''){
            $errors['password'] = 'blank';
        }elseif ($count < 4 || 16 < $count) {
            $errors['password'] = 'length';
        }

        // 画像名を取得
        $file_name ='';
        if(!isset($_GET['action'])){
            $file_name = $_FILES['input_img_name']['name'];
        }

        if(!empty($file_name)){
            // 拡張子チェック

            $file_type = substr($file_name, -3);
            $file_type = strtolower($file_type);

            if($file_type != 'jpg' && $file_type != 'png' && $file_type != 'gif'){
                $errors['img_name'] = 'type';
            }
        }else{
            $errors['img_name'] = 'blank';
        }

        // もしエラーが出なければ以下の処理をする
        if(empty($errors)){
            $date_str = date('YmdHis');
            $submit_file_name = $date_str.$file_name;
            move_uploaded_file($_FILES['input_img_name']['tmp_name'],'/user_profile_img/'.$submit_file_name);

            $_SESSION['register']['name'] = $_POST['input_name'];
            $_SESSION['register']['email'] = $_POST['input_email'];
            $_SESSION['register']['password'] = $_POST['input_password'];
            $_SESSION['register']['img_name'] = $submit_file_name;


            header('Location: check.php');
            exit();
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
            <li class="active"><a href="post.php">Post photos</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

      <!-- ここから -->
    <div class="row">
      <div class="col-xs-8 col-xs-offset-2 thumbnail">
        <h2 class="text-center content_header">アカウント作成</h2>
        <form method="POST" action="signup.php" enctype="multipart/form-data">
          <div class="form-group">
            <label for="name">ユーザー名</label>
            <input type="text" name="input_name" class="form-control" id="name" placeholder="山田 太郎" value="<?php echo htmlspecialchars($name);?>">
            <?php if (isset($errors['name']) && $errors['name'] == 'blank'): ?>
                <p class="text-danger">ユーザー名を入力してください。</p>
            <?php endif; ?>
          </div>

          <div class="form-group">
            <label for="email">メールアドレス</label>
            <input type="email" name="input_email" class="form-control" id="email" placeholder="example@gmail.com" value="<?php echo htmlspecialchars($email); ?>">
            <?php if (isset($errors['email']) && $errors['email'] == 'blank'): ?>
                <p class="text-danger">メールアドレスを入力してください。</p>
            <?php endif; ?>
          </div>
          <div class="form-group">
            <label for="password">パスワード</label>
            <input type="password" name="input_password" class="form-control" id="password" placeholder="4 ~ 16文字のパスワード">
            <?php if (isset($errors['password']) && $errors['password'] == 'blank'): ?>
                <p class="text-danger">パスワードを入力してください。</p>
            <?php endif; ?>
            <?php if (isset($errors['password']) && $errors['password'] == 'length') :?>
                <p class="text-danger">パスワードは４文字以上１６字以内で入力して下さい。</p>
            <?php endif; ?>
            <?php if (!empty($errors)): ?>
                <p class="text-danger">パスワードを再度入力して下さい。</p>
            <?php endif; ?>

          </div>
          <div class="form-group">
            <label for="img_name">プロフィール画像</label>
            <input type="file" name="input_img_name" accept = "image/*" id="img_name">
            <?php if(isset($errors['img_name']) && $errors['img_name'] == 'blank')
            : ?>
            <p class="text-danger">画像を選択してください。</p>
            <?php endif; ?>
            <?php if(isset($errors['img_name']) && $errors['img_name'] == 'type'): ?>
            <p class="text-danger">拡張子が「jpg」「png」「gif」の画像を選択して下さい。</p>
            <?php endif; ?>
          </div>
          <input type="submit" class="btn btn-default" value="確認">
          <a href="../signin.php" style="float: right; padding-top: 6px;" class="text-success">サインイン</a>
        </form>
      </div>
    </div>


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