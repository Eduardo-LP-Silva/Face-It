<?php
    include_once('../../utils/utils.php');
    include_once('../../login/session.php');

    $_POST['database_path'] = '../db.db';
    include_once('../connection.php');

    global $db;

    $time_stmt = $db->prepare("SELECT datetime('now', 'localtime')");
    $time_stmt->execute();

    $current_date = $time_stmt->fetch()[0];
    
    $stmt = $db->prepare
    (
        "INSERT INTO story(client, title, content, picture, points, comment_number, post_date, channel) VALUES 
        (:client, :title, :content, :picture, 0, 0, :post_date, :channel)"
    );

    if(!$_POST['post_text'])
        $post_text = null;
    else
        $post_text = $_POST['post_text'];

    if(!$_POST['post_image'])
        $post_image = null;
    else
        $post_image = $_POST['post_image'];

    echo $_POST['post_channel'];

    $stmt->execute(array
    (
        ':client' => $_SESSION['username'],
        ':title' => $_POST['post_title'],
        ':content' => $_POST['post_text'],
        ':picture' => $_POST['post_image'],
        ':post_date' => $current_date,
        ':channel' => $_POST['post_channel']
    )); 
?>