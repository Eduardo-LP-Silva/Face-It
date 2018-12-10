<?php
  include_once('../login/session.php');
  include_once('../database/connection.php');
  include_once('../database/stories/get_stories.php');
  include_once('../database/votes/get_personal_story_votes.php');
  include_once('../utils/utils.php');

  if(!isset($_SESSION['username'])){
    die(header("Location: ../login/login.php?error=nosession"));
  }

  $stories = get_front_page_stories();
?>

<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title>FaceIt</title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="front_page_style.css" rel="stylesheet"/>
    <link href="front_page_layout.css" rel="stylesheet"/>
    <link href="../templates/navbar/navbar_layout.css" rel="stylesheet"/>
    <link href="../templates/navbar/navbar_style.css" rel="stylesheet"/>
    <link href="../templates/channels/channels_style.css" rel="stylesheet"/>
    <link href="../templates/channels/channels_layout.css" rel="stylesheet"/>
    <link href="../templates/stories/stories_layout.css" rel="stylesheet"/>
    <link href="../templates/stories/stories_style.css" rel="stylesheet"/>
    <script src="../scripts/story_vote.js" defer> </script>
  </head>
  <body>
    <?php $_GET['banner'] = 'The Face of the Internet'?>
    <?php include('../templates/navbar/navbar.php');?>
    <?php $_POST['channel_path'] = "../channels/channel.php";?>
    <?php include('../templates/channels/channels.php');?>
    <?php include("../templates/stories/stories.php"); ?>
  </body>
</html>
