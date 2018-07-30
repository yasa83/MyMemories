<?php
    session_start();
    require('dbconnect.php');

// 初期化
    $errors = [];

    if(!empty($_POST)){
        $email = $_POST['input_email'];
        $password = $_POST['input_password'];

        if($email!=''&& $password!=''){
            //データベースとの照合処理
            $sql = 'SELECT * FROM `users` WHERE `email`=?';
            $data = [$email];
            $stmt = $dbh->prepare($sql);
            $stmt->execute($data);
            $record = $stmt->fetch(PDO::FETCH_ASSOC);

            // メールアドレスでの本人確認
            // DBのemailと$recordが一致しなかったらfalseになる
            if($record == false){
                $errors['signin'] = 'failed';
            }

            
            // passwordが正しくないとエラーがでる
            // $passwordの配列のなかの記録と一致するか
            if(password_verify($password,$record['password'])){
                // 認証成功
                // SESSION変数にIDを保存
                $_SESSION['id'] = $record['id'];
                //timeline.phpに移動
                header("Location: index.php");
                exit();
            }else{
                // 認証失敗
                $errors['signin'] ='failed';
            }
        }else{
            $errors['signin'] ='blank';
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

    <div class="row">
        <div class="col-xs-8 col-xs-offset-2 thumbnail">
                <h2 class="text-center content_header">サインイン</h2>
                <form method="POST" action="" enctype="multipart/form-data">
                    <?php if(isset($errors['signin'])&&$errors['signin']=='blank'): ?>
                        <p class="text-danger">メールアドレスとパスワードを正しく入力してください。</p>
                        <?php endif; ?>
                        <?php if(isset($errors['signin'])&&$errors['signin']=='failed'): ?>
                        <p class="text-danger">サインインに失敗しました</p>
                    <?php endif;?>
                    <div class="form-group">
                        
                        <label for="email">メールアドレス</label>
                        <input type="email" name="input_email" class="form-control" id="email" placeholder="example@gmail.com">

                    </div>
                    <div class="form-group">
                        <label for="password">パスワード</label>
                        <input type="password" name="input_password" class="form-control" id="password" placeholder="4 ~ 16文字のパスワード">
                    </div>
                    <input type="submit" class="btn btn-info" value="サインイン">
                    <a href="signup.php" style="float: right; padding: 20px; background-color: blue; color: white;" class="text-success">ユーザー登録がまだの方はこちら</a>
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

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/bootstrap.js"></script>
  </body>
</html>
