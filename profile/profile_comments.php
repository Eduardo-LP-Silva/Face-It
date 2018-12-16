<?php 
  include_once('../database/connection.php'); 
  include_once("../database/comments/get_comments.php"); 
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
    <link href="profile_comments/profile_comments_layout.css" rel="stylesheet"/>
    <link href="profile_comments/profile_comments_style.css" rel="stylesheet"/>
    <link href="../templates/navbar/navbar_layout.css" rel="stylesheet"/>
    <link href="../templates/navbar/navbar_style.css" rel="stylesheet"/>
  </head>
  <body>
    <?php
      $_GET['banner'] = 'The Face of the Internet'; 
      include('../templates/navbar/navbar.php'); 
      include("../templates/profile.php");

      $user_comments = get_user_comments($_GET['user']);

      foreach($user_comments as $user_comment)
      {
    ?>
      <div class="history_item">
        <p> <?=htmlspecialchars($user_comment['content'])?> </p>
        <div class="comment_stats">
          <div class="points">
            <img src="../assets/like_dislike.png" alt="Points Symbol"/>
            <p> <?=$user_comment['points']?> </p>
          </div>
          <div class="story">
            <img src="../assets/story.png" alt="Story symbol"/>
            <a href=<?= "../post/post.php?post=" . $user_comment['story']?>> <?=htmlspecialchars($user_comment['story_title'])?> </a> 
          </div>
        </div>
      </div>
      <?php }; ?>
    </section>
  </body>
</html>