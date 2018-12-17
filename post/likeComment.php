<?php

$db = new PDO('sqlite:../database/db.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$client = $_POST["client"];
$comment = $_POST["comment"];
$story = $_POST["story"];

$stmt = $db->prepare("INSERT INTO likes_comment(client, comment, points) 
                    VALUES (?, ?, 1)");
$stmt->execute(array($client, $comment));

header("Location: post.php?post=". $story);
exit();
?>