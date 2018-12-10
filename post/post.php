<?php
  include_once('../database/connection.php');
  include_once('../database/comments/get_comments.php');
  include_once('../database/stories/get_stories.php');
  include('../database/votes/get_personal_story_votes.php');
  include('../utils/utils.php');
  
  $comments = get_story_comments();
  $commentReplies = get_comment_comments();
  $stories = get_user_stories();

  foreach($stories as $story) {
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
    <?php include('../templates/navbar/navbar.php');?>
    <?php include('../templates/channels/channels.php');?>

    <div id = "content">
      <h1><?php echo $story['title'];?> </h1>
      <img src=<?php echo $story['picture'];?>>
      <p id = "description"> <span style="display:inline-block; width: 2em;"></span> <?php echo $story['content']; ?>
      </p>
      <p id = "postData"> <span id = "clientName"> <a href="https://www.google.com"><?php echo $story['client'];?></a></span> posted this on 03/12/2018</p>
    </div>

    <div id="commentInput">
      <form action="/my-handling-form-page" method="post"> 
          <p id = "commentsNumber"><?php echo sizeof($comments)?> Comments</p>
          <input type="text" id="name" name="user_name" placeholder="       Add a comment"/>
      </form>
    </div>

    <div id="comments">
    	<div class="comments-container">
        <ul id="comments-list" class="comments-list">
        <?php
        foreach($comments as $comment){
        ?>
          <li>
            <div class="comment-main-level">
              <!-- Avatar -->
              <div class="comment-avatar"><img src=<?php echo $comment['picture'];?> alt=""></div>
              <div class="comment-box">
                <div class="comment-head">
                  <h6 class="comment-name by-author"><a href="../profile/profile_posts.php"><?php echo $comment['username'];?> </a></h6>
                  <span>20 minutes ago</span>
                  <i class="fa fa-reply"></i>
                  <i class="fa fa-heart"></i>
                </div>
                <div class="comment-content">
                  <?php echo $comment['content'];?>
                </div>
              </div>
            </div>
            <!-- Comment Answers -->
            <ul class="comments-list reply-list">
            <?php
            foreach($commentReplies as $commentReply){
            ?>
              <li>
                <div class="comment-avatar"><img src=<?php echo $commentReply['picture'];?> alt=""></div>
                <div class="comment-box">
                  <div class="comment-head">
                    <h6 class="comment-name by-author"><a href="../profile/profile_posts.php"><?php echo $commentReply['username'];?></a></h6>
                    <span>10 minutes ago</span>
                    <i class="fa fa-reply"></i>
                    <i class="fa fa-heart"></i>
                  </div>
                  <div class="comment-content">
                    <?php echo $commentReply['content'];?>
                  </div>
                </div>
              </li>
              <?php }; ?>
            </ul>
          </li>
          <?php }; ?>
        </ul>
      </div>
      </div>
  </body>
</html>
