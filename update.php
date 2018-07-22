<?php
// データベースに接続
require_once('dbconnect.php');

    $title = htmlspecialchars($_POST['title']);
    $date = htmlspecialchars($_POST['date']);
    $detail = htmlspecialchars($_POST['detail']);
    $id = htmlspecialchars($_POST['id']);



    $sql = 'UPDATE `feeds` SET `title` = ?, `date` = ? , `detail` = ? WHERE `id` = ?';
    //$sql = 'UPDATE `posts` SET `nickname` = :nickname, `comment` = :comment WHERE `id` = :id';
    $data = [$title, $date, $detail, $id];
    $stmt = $dbh->prepare($sql);
    // $stmt->bindValue(':nickname', $nickname);
    // $stmt->bindValue(':comment', $comment);
    // $stmt->bindValue(':id', $id);
    // $stmt->execute();
    $stmt->execute($data);

    $dbh = null;

    header("Location: index.php");
    exit();