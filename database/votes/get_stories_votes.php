<?php

    function get_story_votes()
    {
        global $db;
        global $front_page_stories;

        $stmt = $db->prepare
        (
            "SELECT story, points
            FROM likes_story
            WHERE client = 'Des_locado'"  
        );

        $stmt->execute();

        return $stmt->fetchAll();
    }
?>