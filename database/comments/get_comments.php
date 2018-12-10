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
    

    function get_story_comments($id)
    {
        global $db;

        //Mudar para user
        $stmt = $db->prepare
        (
            "SELECT DISTINCT comment.comment as ID, client.username as username, user_profile.picture as picture, comment.content as content, comment.points as points, comment.story as story,
                story.title as story_title, comment.comment_date as comment_date
            FROM comment, client, story, user_profile
            WHERE story.story = $id
            AND client.username = user_profile.client
            AND comment.client = client.username
            AND comment.parent_comment IS NULL
            ORDER BY comment.comment_date DESC"
        );

        $stmt->execute();

        $user_comments = $stmt->fetchAll();

        return $user_comments;
    }

    function get_comment_comments($storyId, $parentId)
    {
        global $db;

        //Mudar para user
        $stmt = $db->prepare
        (
            "SELECT DISTINCT comment.comment as ID, client.username as username, user_profile.picture as picture, comment.content as content, comment.points as points, comment.story as story,
                story.title as story_title, comment.comment_date as comment_date
            FROM comment, client, story, user_profile
            WHERE story.story = $storyId
            AND client.username = user_profile.client
            AND comment.client = client.username
            AND comment.parent_comment = $parentId
            ORDER BY comment.comment_date DESC"
        );

        $stmt->execute();

        $user_comments = $stmt->fetchAll();

        return $user_comments;
    }


    function get_comments_by_story($storyId)
    {
        global $db;

        //Mudar para user
        $stmt = $db->prepare
        (
            "SELECT DISTINCT comment.comment
            FROM comment
            WHERE comment.story = $storyId
            ORDER BY comment.comment_date DESC"
        );

        $stmt->execute();

        $user_comments = $stmt->fetchAll();

        return $user_comments;
    }




?>