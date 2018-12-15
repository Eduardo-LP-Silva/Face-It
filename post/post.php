<?php
  include_once('../database/connection.php');
  include_once('../database/comments/get_comments.php');
  include_once('../database/stories/get_stories.php');
  include('../database/votes/get_personal_story_votes.php');
  include('../utils/utils.php');

  $stories = get_user_stories('joao');

  foreach($stories as $story) {
    $comments = get_story_comments($story['ID']);
    $nComments = get_subcomments_by_story($story['ID']);
    $nComments2 = get_comments_by_story($story['ID']);
    $nTotal = sizeof($nComments) + sizeof($nComments2);
  }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>FaceIt</title>
    <script src="script.js" defer></script>
    <link rel="stylesheet" href="post.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

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
      <form action="addComment.php" method="post"> 
          <p id = "commentsNumber"><?php echo $nTotal?> Comments</p>
          <input type='hidden' value=<?php echo $story['client'];?> name='client'/> 
          <input type='hidden' value=<?php echo $story['ID'];?> name='story'/> 
          <input type="text" id="name" name="user_name" placeholder="       Add a comment"/>
      </form>
    </div>

    <div id="comments">
    	<div class="comments-container">
        <ul id="comments-list" class="comments-list">
        <?php
        foreach($comments as $comment){
          $commentReplies = get_comment_comments($story['ID'], $comment['ID']);
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
                  <i class="fas fa-trash"></i>
                  <form action="removeComment.php" method="post"> 
                      <input type='hidden' value=<?php echo $comment['ID'];?> name='commentId'/> 
                  </form>
                </div>
                <div class="comment-content">
                  <?php echo $comment['content'];?>
                </div>
              </div>
            </div>
            <!-- Comment Answers -->
            <ul class="comments-list reply-list">
            <li class="replyForm" style="display:none">
                <div class="comment-avatar"><img src='https://scontent.flis7-1.fna.fbcdn.net/v/t1.0-1/p160x160/47252887_2485383431488395_7276177372590637056_n.jpg?_nc_cat=106&_nc_ht=scontent.flis7-1.fna&oh=230ee2703db93c913eca2b893da2f219&oe=5C9E9060' alt=""></div>
                <div class="comment-box">
                  <div class="comment-head">
                    <h6 class="comment-name by-author"><a href="../profile/profile_posts.php"></a></h6>
                    <span>Add a reply to the comment</span>
                  </div>
                  <div class="comment-content" >
                    <form action="addReply.php" method="post"> 
                      <input type="text" id="name" name="user_name"/>
                      <input type='hidden' value="edu" name='client'/> 
                      <input type='hidden' value=<?php echo $story['ID'];?> name='story'/> 
                      <input type='hidden' value=<?php echo $comment['ID'];?> name='parent'/>
                    </form>
                  </div>
                </div>
              </li>
            <?php
            foreach($commentReplies as $commentReply){
            ?>
              <li>
                <div class="comment-avatar"><img src=<?php echo $commentReply['picture'];?> alt=""></div>
                <div class="comment-box">
                  <div class="comment-head">
                    <h6 class="comment-name by-author"><a href="../profile/profile_posts.php"><?php echo $commentReply['username'];?></a></h6>
                    <span>10 minutes ago</span>
                    <i class="fas fa-trash"></i>
                    <form action="removeCommentReply.php" method="post"> 
                      <input type='hidden' value=<?php echo $commentReply['ID'];?> name='commentId'/> 
                  </form>
                  </div>
                  <div class="comment-content">
                    <?php echo $commentReply['content'];?>
                  </div>
                </div>
              </li>
              <?php }; ?>
            </ul>
          </li>
          <?php 
            };
          ?>
        </ul>
      </div>
      </div>
  </body>
</html>
