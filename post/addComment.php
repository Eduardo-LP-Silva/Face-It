<?php

$db = new PDO('sqlite:../database/db.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$client = $_POST["client"];
$story = $_POST["story"];
$content = $_POST["user_name"];

$date = gmdate("Y-m-d H:i:s");

$stmt = $db->prepare("INSERT INTO comment(comment, client, story, parent_comment, content, comment_date, points) 
                    VALUES (NULL, ?, ?, NULL, ?, ?, 0)");
$stmt->execute(array($client, $story, $content, $date));

header("Location: post.php?success=addcomment");
exit();
?>