<?php

$db = new PDO('sqlite:../database/db.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$client = $_POST["client"];
$story = $_POST["story"];
$content = $_POST["user_name"];

$stmt = $db->prepare("INSERT INTO comment(comment, client, story, parent_comment, content, comment_date, points) 
                    VALUES (NULL, ?, ?, NULL, ?, '2018-12-02 14:31:00.0000', 0)");
$stmt->execute(array($client, $story, $content));

header("Location: post.php?post=". $story);
exit();
?>