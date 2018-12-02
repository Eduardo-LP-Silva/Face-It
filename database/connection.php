<?php
    try
    {
        $db = new PDO('sqlite:../database/db.db');
    }
    catch (PDOException $e)
    {
        echo $e->getMessage();
    }
    
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>