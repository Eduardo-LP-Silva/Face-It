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
        "DELETE FROM likes_story WHERE story = :story AND client = :client AND points = :points"
    );

    $db->beginTransaction();

    $stmt->execute(array
    (
        ':client' => $client,
        ':story' => $story_id,
        ':points' => $vote
    ));

    $db->commit();

    echo 0;
?>