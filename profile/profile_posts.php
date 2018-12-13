<?php 

  include_once('../login/session.php');
  include_once('../database/connection.php'); 
  include_once("../database/stories/get_stories.php"); 
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
        <a href="../post/post.php"> <?=htmlspecialchars($user_story['title'])?> </a> <!-- Change href's to post -->
        <a href="front_page.html"> <img src=<?php if($user_story['picture'] == null) {echo '../assets/no_image.png';}
                else echo htmlspecialchars($user_story['picture']);?>
          alt="Post's minimized image or logo" /> </a> <!-- Change href's to post   -->
        <div class="points">
          <img src="../assets/like_dislike.png" alt="Points Symbol"/>
          <p> <?=$user_story['points']?> </p>
        </div>
        <div class="comment">
          <a href="front_page.html"> <img src="../assets/comment.png" alt="Comment Symbol"/> </a> <!-- Change href's to post -->
          <p> <?=$user_story['comment_number']?> </p>
        </div>
        <div class="channel">
          <img src="../assets/channel.png" alt="Channel Icon"/>
          <a href="front_page.html"> <?=htmlspecialchars($user_story['channel_name'])?> </a> <!-- Change href's to channel -->
        </div>
      </div>
      <?php }; ?>
    </section>
  </body>
</html>