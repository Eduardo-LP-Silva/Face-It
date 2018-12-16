<?php

    include_once("../../login/session.php");

    $story_id = $_GET['story_id'];
    $client = $_SESSION['username'];
    $vote = $_GET['vote'];

    $_POST['database_path'] = '../db.db';
    include_once('../connection.php');

    global $db;

    $stmt = $db->prepare
    (
        "INSERT INTO likes_story(client, story, points) VALUES (:client , :story, :vote)"
    );

    $db->beginTransaction();

    $stmt->execute(array
    (
        ':client' => $client,
        ':story' => $story_id,
        ':vote' => $vote
    ));

    $db->commit();

    echo 0;
?>