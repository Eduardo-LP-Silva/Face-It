<?php
  include_once('../login/session.php');
  include_once('../database/connection.php');
  include_once('../database/channels/get_channels.php');
  include_once('../database/stories/get_stories.php');
  include_once('../database/votes/get_personal_story_votes.php');
  include_once('../utils/utils.php');
  include("../database/channels/is_subscribed.php");

  $channel_info = get_channel_description($_GET['channel']);

  if(empty($channel_info[0])){
      $_SESSION['error_message'] = 'CHANNEL NOT FOUND';
      die(header('Location: ../utils/errorPage.php'));
  }
  
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
    <script src="../scripts/expand_bar.js" defer> </script>
    <script src="../scripts/channel_subscriptions.js" defer> </script>
  </head>
  <body>
    <?php $_GET['banner'] = $_GET['channel'];?>
    <?php include('../templates/navbar/navbar.php');?>
    <?php include('../templates/channels/channels.php');?>
    <section class="channel_info">
      <p id="channel_name"><?=$_GET['channel'];?></p>
      <p id="channel_description"> <?=htmlspecialchars($channel_info['channel_description']);?> </p>
      <p id="expand_bar"> >> </p>
      <div id="subscribe">
        <?php

          if(!is_subscribed())
          {
            $subscribe_image_path = "../assets/subscribe.svg";
            $subscribe_text = "Subscribe";
          }
          else
          {
            $subscribe_image_path = "../assets/subscribed.svg";
            $subscribe_text = "Subscribed";
          }
        ?> 
        <img src=<?=$subscribe_image_path?> alt="Subscribe(d) symbol"/>
        <p><?=$subscribe_text?></p>
        <p> </p> <!-- Div -->
        <a id="new_post" href=<?="create_post.php?channel=" . $_GET['channel']?> > New Post </a> 
      </div>
    </section>
    <?php include_once('../templates/stories/stories.php') ?>
  </body>
</html>