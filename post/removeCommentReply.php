<?php

$db = new PDO('sqlite:../database/db.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id = $_POST["commentId"];
$story = $_POST["story"];

$stmt = $db->prepare("DELETE FROM comment WHERE comment = :id ");
$stmt->execute([':id' => $id]);

header("Location: post.php?post=". $story);
exit();
?>