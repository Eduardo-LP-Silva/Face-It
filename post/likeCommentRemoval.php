<?php

$db = new PDO('sqlite:../database/db.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$comment = $_POST["comment"];
$client = $_POST["client"];
$story = $_POST["story"];
echo $comment;
echo " : split : ";
echo $client;

$stmt = $db->prepare("DELETE FROM likes_comment WHERE comment = ? AND client = ? ");
$stmt->execute(array($comment, $client));

header("Location: post.php?post=". $story);
exit();
?>