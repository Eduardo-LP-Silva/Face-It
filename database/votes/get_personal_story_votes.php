<?php

    $db = new PDO('sqlite:../db.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $client = $_GET['client'];
    $story = $_GET['story'];

    $stmt = $db->prepare
    (
        "SELECT story, points
        FROM likes_story
        WHERE client = :client
        AND story = :story"
    );
    $stmt->execute(array
    (
        ':client' => $client, 
        ':story' => $story
    ));

    $array = $stmt->fetchAll();

    echo json_encode($array);
?>