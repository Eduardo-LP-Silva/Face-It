<?php

    include_once('../login/session.php');

    function get_user_comments()
    {
        global $db;

        //Mudar para user
        $stmt = $db->prepare
        (
            "SELECT comment.comment as ID, comment.content as content, comment.points as points, comment.story as story,
                story.title as story_title
            FROM comment, client, story
            WHERE client.username = comment.client 
            AND client.username = ?
            AND comment.story = story.story
            ORDER BY comment.comment_date DESC"
        );

        $stmt->execute(array($_SESSION['username']));

        $user_comments = $stmt->fetchAll();

        return $user_comments;
    }

?>