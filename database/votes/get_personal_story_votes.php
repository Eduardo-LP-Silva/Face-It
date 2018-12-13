<?php

    if($_GET['story'])
    {
        include_once("../../login/session.php");

        $db = new PDO('sqlite:../db.db');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $client = $_SESSION['username'];
        $story = $_GET['story'];

        $array = prepare_and_execute_statement($db, $story, $client);
    
        echo json_encode($array);
    }

    function get_personal_story_votes($story, $client)
    {
        global $db;

        $res = prepare_and_execute_statement($db, $story, $client);
        
        return $res;
    }

    function prepare_and_execute_statement($db, $story, $client)
    {
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

        return $stmt->fetchAll();
    }
    
?>