<?php

    include_once("../../login/session.php");

    $story_id = $_GET['story_id'];
    $client = $_SESSION['username'];
    $vote = $_GET['vote'];

    $db = new PDO('sqlite:../db.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $db->prepare
    (
        "DELETE FROM likes_story WHERE story = :story AND client = :client AND points = :points"
    );

    $stmt->execute(array
    (
        ':client' => $client,
        ':story' => $story_id,
        ':points' => $vote
    ));

    echo 0;
?>