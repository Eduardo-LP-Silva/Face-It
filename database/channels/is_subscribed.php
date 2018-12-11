<?php

    function is_subscribed()
    {
        include_once('../../login/session.php');

        if(!isset($_SESSION['username']))
            return false;
        
        $_POST['database_path'] = '../db.db';
        include_once('../connection.php');
        
        global $db;
    
        $stmt = $db->prepare
        (
            'SELECT *
            FROM client_channel
            WHERE client = ?
            AND channel = ?'
        );
    
        $stmt->execute(array($_SESSION['username'], $_GET['channel']));
        $results = $stmt->fetch();
    
        return (!empty($results));
    }
    
?>