<?php
  include_once('../database/connection.php');
  include_once('../database/comments/get_comments.php');
  include_once('../database/stories/get_stories.php');
  include('../database/votes/get_personal_story_votes.php');
  include('../utils/utils.php');
  
  $comments = get_user_comments();
  $stories = get_user_stories();
  foreach($comments as $comment) {
    // echo $comment['ID'], '<br>';
    // echo $comment['content'], '<br>';
    // echo $comment['points'], '<br>';
    // echo $comment['story'], '<br>';
    // echo $comment['story_title'], '<br>';
  }

  foreach($stories as $story) {
    // echo $story['client'], '<br>';
    // echo $story['ID'], '<br>';
    // echo $story['title'], '<br>';
    // echo $story['points'], '<br>';
    // echo $story['comment_number'], '<br>';
    // echo $story['channel_name'], '<br>';
  }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Post</title>
    <link rel="stylesheet" href="post.css">
    <!-- <link rel="stylesheet" href="../templates/templates.css"> -->
  </head>
  <body>
    <?php include('../templates/navbar.php');?>
    <?php include('../templates/channels.php');?>

    <div id = "content">
      <h1><?php echo $story['title'];?> </h1>
      <img src="../assets/deslocado.jpg">
      <p id = "description"> <span style="display:inline-block; width: 2em;"></span> <?php echo $story['conteudo'], '<br>'; ?>
      </p>
      <p id = "postData"> <span><?php echo $story['client'];?> </span> posted this on 03/12/2018</p>
    </div>

    <div id="commentInput">
      <form action="/my-handling-form-page" method="post"> 
          <p id = "commentsNumber">496 Comments</p>
          <input type="text" id="name" name="user_name" placeholder="       Add a comment"/>
      </form>
    </div>

    <div id="comments">
    	<div class="comments-container">
        <ul id="comments-list" class="comments-list">
          <li>
            <div class="comment-main-level">
              <!-- Avatar -->
              <div class="comment-avatar"><img src="http://i9.photobucket.com/albums/a88/creaticode/avatar_1_zps8e1c80cd.jpg" alt=""></div>
              <div class="comment-box">
                <div class="comment-head">
                  <h6 class="comment-name by-author"><a href="http://creaticode.com/blog">Agustin Ortiz</a></h6>
                  <span>20 minutes ago</span>
                  <i class="fa fa-reply"></i>
                  <i class="fa fa-heart"></i>
                </div>
                <div class="comment-content">
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit omnis animi et iure laudantium vitae, praesentium optio, sapiente distinctio illo?
                </div>
              </div>
            </div>
            <!-- Comment Answers -->
            <ul class="comments-list reply-list">
              <li>
                <!-- Avatar -->
                <div class="comment-avatar"><img src="http://i9.photobucket.com/albums/a88/creaticode/avatar_2_zps7de12f8b.jpg" alt=""></div>
                <div class="comment-box">
                  <div class="comment-head">
                    <h6 class="comment-name"><a href="http://creaticode.com/blog">Lorena Rojero</a></h6>
                    <span>10 minutes ago</span>
                    <i class="fa fa-reply"></i>
                    <i class="fa fa-heart"></i>
                  </div>
                  <div class="comment-content">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit omnis animi et iure laudantium vitae, praesentium optio, sapiente distinctio illo?
                  </div>
                </div>
              </li>

              <li>
                <!-- Avatar -->
                <div class="comment-avatar"><img src="http://i9.photobucket.com/albums/a88/creaticode/avatar_1_zps8e1c80cd.jpg" alt=""></div>
                <div class="comment-box">
                  <div class="comment-head">
                    <h6 class="comment-name by-author"><a href="http://creaticode.com/blog">Agustin Ortiz</a></h6>
                    <span>10 minutes ago</span>
                    <i class="fa fa-reply"></i>
                    <i class="fa fa-heart"></i>
                  </div>
                  <div class="comment-content">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit omnis animi et iure laudantium vitae, praesentium optio, sapiente distinctio illo?
                  </div>
                </div>
              </li>
            </ul>
          </li>

          <li>
            <div class="comment-main-level">
              <!-- Avatar -->
              <div class="comment-avatar"><img src="http://i9.photobucket.com/albums/a88/creaticode/avatar_2_zps7de12f8b.jpg" alt=""></div>
              <div class="comment-box">
                <div class="comment-head">
                  <h6 class="comment-name"><a href="http://creaticode.com/blog">Lorena Rojero</a></h6>
                  <span>10 minutes ago</span>
                  <i class="fa fa-reply"></i>
                  <i class="fa fa-heart"></i>
                </div>
                <div class="comment-content">
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit omnis animi et iure laudantium vitae, praesentium optio, sapiente distinctio illo?
                </div>
              </div>
            </div>
          </li>
        </ul>
      </div>
      </div>
  </body>
</html>
