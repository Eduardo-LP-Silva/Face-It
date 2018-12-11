<?php

    include_once('../../login/session.php');

    if(!isset($_SESSION['username']))
        die(header("Location: ../../login/login.php?error=nosession"));

    $_POST['database_path'] = '../db.db';
    include_once('../connection.php');

    $client = $_SESSION['username'];

    global $db;

    $stmt = $db->prepare
    (
        'INSERT INTO client_channel(client, channel) VALUES (?, ?)'
    );

    $stmt->execute(array($client, $_GET['channel']));
?>