<?php 

  include_once('../login/session.php');
  include_once('../database/connection.php'); 
  include_once("../database/stories/get_stories.php");
  include_once("../database/client/get_client.php"); 

  if(!checkUsername($_GET['user'])){
        $_POST['error_message'] = 'PROFILE NOT FOUND';
        die(header("Location: ../utils/errorPage.php"));
       
  }


?>

<!-- Replace info with respective user's -->
<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title>FaceIt</title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="profile_style.css" rel="stylesheet"/>
    <link href="profile_layout.css" rel="stylesheet"/>
    <link href="profile_posts/profile_posts_layout.css" rel="stylesheet"/>
    <link href="profile_posts/profile_posts_style.css" rel="stylesheet"/>
    <link href="../templates/navbar/navbar_layout.css" rel="stylesheet"/>
    <link href="../templates/navbar/navbar_style.css" rel="stylesheet"/>
  </head>
  <body>
    <?php
      $_GET['banner'] = 'The Face of the Internet';
      include('../templates/navbar/navbar.php'); 
      include("../templates/profile.php");

      $user_stories = get_user_stories($_GET['user']);

      foreach($user_stories as $user_story)
      {
    ?>
      <div class="history_item">
        <a href=<?= "../post/post.php?post=" . $user_story['ID']?>> <?=htmlspecialchars($user_story['title'])?> </a> <!-- Change href's to post -->
        <img src=<?php if($user_story['picture'] == null) {echo '../assets/no_image.png';}
                else echo htmlspecialchars($user_story['picture']);?>
          alt="Post's minimized image or logo" >
        <div class="points">
          <img src="../assets/like_dislike.png" alt="Points Symbol"/>
          <p> <?=$user_story['points']?> </p>
        </div>
        <div class="comment">
          <img src="../assets/comment.png" alt="Comment Symbol"/>
          <p> <?=$user_story['comment_number']?> </p>
        </div>
        <div class="channel">
          <img src="../assets/channel.png" alt="Channel Icon"/>
          <a href=<?="../channels/channel.php?channel=" . htmlspecialchars($user_story['channel_name'])?>> 
          <?=htmlspecialchars($user_story['channel_name'])?> </a>
        </div>
      </div>
      <?php }; ?>
    </section>
  </body>
</html>