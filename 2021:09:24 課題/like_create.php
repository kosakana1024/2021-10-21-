<?php 
// var_dump($_GET);
// exit();

include('functions.php');

$user_id = $_GET['user_id'];
$contents_id = $_GET['contents_id'];

$pdo = connect_to_db();

// $sql = 'INSERT INTO like_table (id, user_id, contents_id, created_at) VALUES (NULL, :user_id, :contents_id, sysdate())';
$sql = 'SELECT COUNT(*) FROM like_table WHERE user_id=:user_id AND contents_id=:contents_id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindValue(':contents_id', $todo_id, PDO::PARAM_STR);
$status = $stmt->execute();

if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    // header("Location:keiziban_read.php");
    // exit();
    $like_count = $stmt->fetchColumn();
    // like_create.php

if ($like_count != 0) {
    // いいねされている状態
    $sql = 'DELETE FROM like_table WHERE user_id=:user_id AND contents_id=:contents_id';
} else {
    // いいねされていない状態
    $sql = 'INSERT INTO like_table (id, user_id, contents_id, created_at) VALUES (NULL, :user_id, :contents_id, sysdate())';
}

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindValue(':contents_id', $contents_id, PDO::PARAM_STR);
$status = $stmt->execute();

if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    header("Location:keiziban_read.php");
    exit();
}

}

?>