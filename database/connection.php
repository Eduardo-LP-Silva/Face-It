<?php
    try
    {
        if($_POST['database_path'])
            $db = new PDO('sqlite:' . $_POST['database_path']);
        else
            $db = new PDO('sqlite:../database/db.db');
    }
    catch (PDOException $e)
    {
        echo $e->getMessage();
    }
    
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>