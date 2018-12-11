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
        'DELETE FROM client_channel WHERE client_channel.client = ? AND client_channel.channel = ?'
    );

    $stmt->execute(array($client, $_GET['channel']));
?>