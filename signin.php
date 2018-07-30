
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
            <li class="active"><a href="signup.php">ユーザー登録がまだの方はこちら</a></li>
          </ul>
        </div><!--/.nav-collapse -->
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
