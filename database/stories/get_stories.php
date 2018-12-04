<?php

    function getFrontPageStories()
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
?>