<?php
  include_once('../database/connection.php');
  include_once('../database/channels/get_channels.php');
  include_once('../database/stories/get_stories.php');
  include_once('../database/votes/get_personal_story_votes.php');
  include_once('../utils/utils.php');

  $channel_info = get_channel_info($_GET['channel']);
  $stories = get_channel_stories($_GET['channel']);
?>

<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title>FaceIt</title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="channel_style.css" rel="stylesheet"/>
    <link href="channel_layout.css" rel="stylesheet"/>
    <link href="../templates/navbar/navbar_layout.css" rel="stylesheet"/>
    <link href="../templates/navbar/navbar_style.css" rel="stylesheet"/>
    <link href="../templates/channels/channels_style.css" rel="stylesheet"/>
    <link href="../templates/channels/channels_layout.css" rel="stylesheet"/>
    <link href="../templates/stories/stories_layout.css" rel="stylesheet"/>
    <link href="../templates/stories/stories_style.css" rel="stylesheet"/>
    <script src="../scripts/story_vote.js" defer> </script>
  </head>
  <body>
    <?php $_GET['banner'] = $_GET['channel'];?>
    <?php include('../templates/navbar/navbar.php');?>
    <?php $_POST['channel_path'] = "./channel.php"; ?>
    <?php include('../templates/channels/channels.php');?>
    <section id="channel_info">
      <p id="channel_name"> <?=$_GET['channel'];?> </p>
      <p id="channel_description"> <?=$channel_info['channel_description'];?> </p>
    </section>
    <?php include_once('../templates/stories/stories.php') ?>
  </body>
</html>