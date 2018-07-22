<?php
    //削除する処理
    $dsn = 'mysql:dbname=MyMemories;host=localhost';
    $user = 'root';
    $password = '';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->query('SET NAMES utf8');


    $id = $_GET['id'];


    $sql = 'DELETE FROM `feeds` WHERE `id` = ?';
    // $sql = 'DELETE FROM `posts` WHERE `id` = ' . $_GET['id'];
    $data[] = $id;
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);



    $dbh = null;

    // リダイレクト 元のページに戻る処理
    header("Location: index.php");
    exit();

//htmlが後に続かないときは閉じtagがいらない