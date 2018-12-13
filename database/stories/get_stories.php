<?php
    
    include_once('../login/session.php');


    function get_front_page_stories()
    {
        global $db;
        $stmt = $db->prepare
        (
            'SELECT story.story as ID, client.username as username, story.title as title, story.picture as picture, 
                story.points as points, story.comment_number as comment_number, channel.channel_name as channel_name  
            FROM story, client, channel, client_channel
            WHERE client.username = story.client and story.channel = channel.channel_name 
            and client_channel.client = ? and client_channel.channel = story.channel
            ORDER BY story.post_date DESC'
        );
        $stmt->execute(array($_SESSION['username']));

        $front_page_stories = $stmt->fetchAll();

        return $front_page_stories;
    }

    function get_all_stories()
    {
        global $db;
        $stmt = $db->prepare
        (
            'SELECT story.story as ID, client.username as username, story.title as title, story.picture as picture, 
                story.points as points, story.comment_number as comment_number, channel.channel_name as channel_name  
            FROM story, client, channel
            WHERE client.username = story.client and story.channel = channel.channel_name
            ORDER BY story.post_date DESC'
        );
        $stmt->execute();

        $front_page_stories = $stmt->fetchAll();

        return $front_page_stories;
    }

    function get_user_stories()
    {
        global $db;

        //Mudar para user
        $stmt = $db->prepare
        (
            "SELECT story.story as ID, story.picture as picture, story.title as title, story.content as content, story.client as client, story.picture as picture, story.points as points, 
                story.comment_number as comment_number, channel.channel_name as channel_name  
            FROM story, client, channel
            WHERE client.username = story.client 
            AND story.channel = channel.channel_name 
            AND client.username = ?
            ORDER BY story.post_date DESC"
        );

        $stmt->execute(array($_SESSION['username']));

        $user_stories = $stmt->fetchAll();

        return $user_stories;
    }

    function get_channel_stories($channel)
    {
        global $db;
        $stmt = $db->prepare
        (
            'SELECT story.story as ID, client.username as username, story.title as title, story.picture as picture, 
                story.points as points, story.comment_number as comment_number, channel.channel_name as channel_name  
            FROM story, client, channel
            WHERE client.username = story.client AND story.channel = channel.channel_name AND channel.channel_name = ? 
            ORDER BY story.post_date DESC'
        );
        $stmt->execute(array($channel));

        $channel_stories = $stmt->fetchAll();

        return $channel_stories;
    }
?>