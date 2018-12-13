<?php

    include_once("../../login/session.php");

    $story_id = $_GET['story_id'];
    $client = $_SESSION['username'];
    $vote = $_GET['vote'];

    $db = new PDO('sqlite:../db.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $db->prepare
    (
        "INSERT INTO likes_story(client, story, points) VALUES (:client , :story, :vote)"
    );

    $stmt->execute(array
    (
        ':client' => $client,
        ':story' => $story_id,
        ':vote' => $vote
    ));

    echo 0;

?>