<?php
  include_once('../login/session.php');
  include_once('../database/connection.php');
  include_once('../database/stories/get_stories.php');
  include('../database/votes/get_personal_story_votes.php');
  include('../utils/utils.php');


  

  $stories = getFrontPageStories();
?>

<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title>FaceIt</title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="front_page_style.css" rel="stylesheet"/>
    <link href="front_page_layout.css" rel="stylesheet"/>
    <script src="../scripts/story_vote.js" defer> </script>
  </head>
  <body>

    <?php include('../templates/navbar.php');?>
    <?php include('../templates/channels.php');?>

    <section id="stories"> <!-- Get with php from DB, change href's accordingly -->
      <?php foreach($stories as $story)
      { ?>
        <div class="story" id=<?=$story['ID']?>>

          <?php $points = get_personal_story_votes($story['ID'], 'Des_locado'); //Mudar para user
           
            if(!empty($points))
            {
              $points = $points[0]['points'];

              if($points == 1)
              {
                $like_path = "../assets/like_pressed.png";
                $dislike_path = "../assets/dislike.png";
              }
              else
              {
                $like_path = "../assets/like.png";
                $dislike_path = "../assets/dislike_pressed.png";
              }
            }
            else
            {
              $like_path = "../assets/like.png";
              $dislike_path = "../assets/dislike.png";
            }
           ?>

          <img src=<?php echo $like_path ?> alt="Like Button"/>
          <p> <?=$story['points']?> </p>
          <img src=<?php echo $dislike_path ?> alt="Dislike Button" />
          <a href="front_page.html"> <?=$story['title']?> </a> <!-- Change href's to post -->
          <a href="front_page.html"> <img src=<?php if($story['picture' == null]) echo '../assets/no_image.png'?>
            alt="Post's minimized image or logo" /> </a> <!-- Change href's to post   -->
          <a href="front_page.html"> <img src="../assets/comment.png" alt="Comment Symbol"/> </a> <!-- Change href's to post -->
          <p> <?=$story['comment_number']?> </p>
          <img src="../assets/op.png" alt="OP Icon"/>
          <a href="front_page.html"> <?=$story['username']?> </a> <!-- Change href's to OP's profile -->
          <img src="../assets/channel.png" alt="Channel Icon"/>
          <a href="front_page.html"> <?=$story['channel_name']?> </a> <!-- Change href's to channel -->
        </div>
        <?php
      } ?>
    </section>
  </body>
</html>
