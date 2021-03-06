<?php

    include_once('../login/session.php');

    function get_user_comments()
    {
        global $db;

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
            "SELECT DISTINCT comment.comment as ID, client.username as username, user_profile.picture as picture, 
            comment.content as content, comment.points as points, comment.story as story, story.title as story_title
            FROM comment, client, story, user_profile
            WHERE story.story = ?
            AND client.username = user_profile.client
            AND comment.client = client.username
            AND comment.parent_comment IS NULL
            AND comment.story = story.story
            ORDER BY comment.comment_date DESC"
        );

        $stmt->execute(array($id));

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
                story.title as story_title
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


    function get_subcomments_by_story($storyId)
    {
        global $db;

        //Mudar para user
        $stmt = $db->prepare
        (
            "SELECT DISTINCT comment.comment
            FROM comment,(
                SELECT comment.comment 
                AS Parent 
                FROM comment
                WHERE comment.parent_comment IS NULL
                AND comment.story = $storyId
            )
            WHERE comment.story = $storyId
            AND comment.parent_comment = Parent
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
            WHERE comment.parent_comment IS NULL
            AND comment.story = $storyId"
        );

        $stmt->execute();

        $user_comments = $stmt->fetchAll();

        return $user_comments;
    }

    function get_comment_upvotes($commentID)
    {
        global $db;

        $stmt = $db->prepare
        (
            "SELECT count(*)
            FROM likes_comment
            WHERE comment = ?
            AND points = 1"
        );

        $stmt->execute(array($commentID));

       return $stmt->fetch();
    }

    function get_comment_downvotes($commentID)
    {
        global $db;

        $stmt = $db->prepare
        (
            "SELECT count(*)
            FROM likes_comment
            WHERE comment = ?
            AND points = -1"
        );

        $stmt->execute(array($commentID));

        return $stmt->fetch();
    }

    function get_comment_like($commentID, $client)
    {
        global $db;

        $stmt = $db->prepare
        (
            "SELECT count(*)
            FROM likes_comment
            WHERE comment = ?
            and client = ?
            AND points = 1"
        );

        $stmt->execute(array($commentID, $client));

        return $stmt->fetch();
    }

    function get_comment_dislike($commentID, $client)
    {
        global $db;

        $stmt = $db->prepare
        (
            "SELECT count(*)
            FROM likes_comment
            WHERE comment = ?
            and client = ?
            AND points = -1"
        );

        $stmt->execute(array($commentID));

        return $stmt->fetch();
    }

?>