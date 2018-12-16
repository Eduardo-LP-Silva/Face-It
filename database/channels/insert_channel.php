<?php
    include_once('../../utils/utils.php');
    include_once('../../login/session.php');

    $_POST['database_path'] = '../db.db';
    include_once('../connection.php');

    global $db;

    $stmt2 = $db->prepare
    (
        'SELECT *
        FROM channel
        WHERE channel_name = ?'
    );
        
    $stmt2->execute(array($_GET['channel_name']));

    $channel = $stmt2->fetch();

    if($channel)
    {
        $_SESSION['error_message'] = "Channel Already Exists";
        header('Location: ../../utils/errorPage.php');
        exit();
    }
        
    $stmt = $db->prepare
    (
        "INSERT INTO channel(channel_name, channel_description) VALUES (?, ?)"
    );

    $stmt->execute(array($_GET['channel_name'], $_GET['channel_description']));

    $_GET['channel'] = $_GET['channel_name'];
    include_once('subscribe.php');

    header('Location: ../../front_page/front_page.php');
?>