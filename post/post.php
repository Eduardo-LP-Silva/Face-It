<?php
  include_once('../login/session.php');
  include_once('../database/connection.php');
  include_once('../database/comments/get_comments.php');
  include_once('../database/stories/get_stories.php');
  include_once('../database/client/get_client.php');
  include('../database/votes/get_personal_story_votes.php');
  include('../utils/utils.php');

  $story = get_story_info($_GET['post']);

  if(!$story){
  $_SESSION['error_message'] = 'POST NOT FOUND';
    die(header('Location: ../utils/errorPage.php'));
  }
  $comments = get_story_comments($story['story']);
  $nComments = get_subcomments_by_story($story['story']);
  $nComments2 = get_comments_by_story($story['story']);
  $nTotalTest = sizeof($nComments) + sizeof($nComments2);
  $nTotal = $story['comment_number'];
  $like = 0;

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>FaceIt</title>
    <script src="script.js" defer></script>
    <link rel="stylesheet" href="post.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link href="../templates/navbar/navbar_layout.css" rel="stylesheet"/>
    <link href="../templates/navbar/navbar_style.css" rel="stylesheet"/>
    <link href="../templates/channels/channels_style.css" rel="stylesheet"/>
    <link href="../templates/channels/channels_layout.css" rel="stylesheet"/>
  </head>
  <body>
    <?php include('../templates/navbar/navbar.php');?>
    <?php include('../templates/channels/channels.php');?>

    <div id = "content">
      <h1><?php echo htmlspecialchars($story['title']);?> </h1>
      <img src=<?php echo $story['picture'];?>>
      <p id = "description"> <span style="display:inline-block; width: 2em;"></span> <?php echo htmlspecialchars($story['content']);?>
      </p>
      <p id = "postData"> <span id = "clientName"> <a href=<?="../profile/profile_posts.php?user=" . $story['client']?>>
      <?php echo htmlspecialchars($story['client']);?>
      </a></span> posted this on <?=$story['post_date']?> </p>
    </div>

    <div id="commentInput">
      <form action="addComment.php" method="post"> 
          <p id = "commentsNumber"><?php echo $nTotalTest?> Comments</p>
          <input type='hidden' value=<?php echo $_SESSION['username'];?> name='client'/> 
          <input type='hidden' value=<?php echo $story['story'];?> name='story'/> 
          <input type="text" id="name" name="user_name" placeholder="       Add a comment"/>
      </form>
    </div>

    <div id="comments">
    	<div class="comments-container">
        <ul id="comments-list" class="comments-list">
        <?php
        foreach($comments as $comment){
          $commentReplies = get_comment_comments($story['story'], $comment['ID']);
        ?>
          <li>
            <div class="comment-main-level">
              <!-- Avatar -->
              <div class="comment-avatar"><img src=<?php echo $comment['picture'];?> alt="Comment Avatar"></div>
              <div class="comment-box">
                <div class="comment-head">
                  <h6 class="comment-name by-author"><a href=<?="../profile/profile_posts.php?user=" . $comment['username']?>> 
                  <?php echo htmlspecialchars($comment['username']);?> </a></h6>
                  <span style = "margin-left:37em;"><?php echo get_comment_upvotes($comment['ID'])[0]?> Likes</span>
                  <?php 
                  if(get_comment_like($comment['ID'], $_SESSION['username'])[0] > 0){ ?>
                    <i class="fas fa-thumbs-up" style = "color:#03658c;"></i>
                    <form action="likeCommentRemoval.php" method="post"> 
                      <input type='hidden' value=<?php echo $story['story'];?> name='story'/>   
                      <input type='hidden' value=<?php echo $comment['ID'];?> name='comment'/> 
                      <input type='hidden' value=<?php echo $_SESSION['username'];?> name='client'/> 
                    </form>
                  <?php } ?>
                  <?php 
                  if(get_comment_like($comment['ID'], $_SESSION['username'])[0] == 0){ ?>
                    <i class="fas fa-thumbs-up"></i>
                    <form action="likeComment.php" method="post"> 
                      <input type='hidden' value=<?php echo $story['story'];?> name='story'/>   
                      <input type='hidden' value=<?php echo $comment['ID'];?> name='comment'/> 
                      <input type='hidden' value=<?php echo $_SESSION['username'];?> name='client'/> 
                    </form>
                  <?php } ?>
                  
                  <i class="fa fa-reply"></i>

                  <?php 
                  if($_SESSION['username'] == $comment['username']){ ?>
                    <i class="fas fa-trash"></i> <!-- Mudar para so mostar caso o poster do comment seja igual ao da session-->
                    <form action="removeComment.php" method="post"> 
                        <input type='hidden' value=<?php echo $story['story'];?> name='story'/> 
                        <input type='hidden' value=<?php echo $comment['ID'];?> name='commentId'/> 
                    </form>
                  <?php } ?>


                </div>
                <div class="comment-content">
                  <?php echo htmlspecialchars($comment['content']);?>
                </div>
              </div>
            </div>
            <!-- Comment Answers -->
            <ul class="comments-list reply-list">
            <li class="replyForm" style="display:none">
                <div class="comment-avatar"><img src=<?=get_client_picture($_SESSION['username'])['picture']?> alt="Reply Avatar"></div>
                <div class="comment-box">
                  <div class="comment-head">
                    <h6 class="comment-name by-author"><a href="../profile/profile_posts.php"></a></h6>
                    <span>Add a reply to the comment</span>
                  </div>
                  <div class="comment-content" >
                    <form action="addReply.php" method="post"> 
                      <input type="text" id="name" name="user_name"/>
                      <input type='hidden' value=<?= $_SESSION['username'] ?> name='client'/> <!-- Mudar o edu -->
                      <input type='hidden' value=<?php echo $story['story'];?> name='story'/> 
                      <input type='hidden' value=<?php echo $comment['ID'];?> name='parent'/>
                    </form>
                  </div>
                </div>
              </li>
            <?php
            foreach($commentReplies as $commentReply){
            ?>
              <li>
                <div class="comment-avatar"><img src=<?php echo $commentReply['picture'];?> alt="Comment Avatar"></div>
                <div class="comment-box">
                  <div class="comment-head">
                    <h6 class="comment-name by-author"><a href=<?="../profile/profile_posts.php?user=" . $commentReply['username']?>>
                    <?php echo htmlspecialchars($commentReply['username']);?></a></h6>
                    <span style = "margin-left:34em;"><?php echo get_comment_upvotes($commentReply['ID'])[0]?> Likes</span>
                    <?php 
                  if(get_comment_like($commentReply['ID'], $_SESSION['username'])[0] > 0){ ?>
                    <i class="fas fa-thumbs-up" style = "color:#03658c;"></i>
                    <form action="likeCommentRemoval.php" method="post"> 
                      <input type='hidden' value=<?php echo $story['story'];?> name='story'/>   
                      <input type='hidden' value=<?php echo $commentReply['ID'];?> name='comment'/> 
                      <input type='hidden' value=<?php echo $_SESSION['username'];?> name='client'/> 
                    </form>
                  <?php } ?>
                  <?php 
                  if(get_comment_like($commentReply['ID'], $_SESSION['username'])[0] == 0){ ?>
                    <i class="fas fa-thumbs-up"></i>
                    <form action="likeComment.php" method="post"> 
                      <input type='hidden' value=<?php echo $story['story'];?> name='story'/>   
                      <input type='hidden' value=<?php echo $commentReply['ID'];?> name='comment'/> 
                      <input type='hidden' value=<?php echo $_SESSION['username'];?> name='client'/> 
                    </form>
                  <?php } ?>

                  <?php 
                  if($_SESSION['username'] == $commentReply['username']){ ?>
                    <i class="fas fa-trash"></i> <!-- Mudar para so mostar caso o poster do comment seja igual ao da session-->
                      <form action="removeCommentReply.php" method="post"> 
                        <input type='hidden' value=<?php echo $story['story'];?> name='story'/>   
                        <input type='hidden' value=<?php echo $commentReply['ID'];?> name='commentId'/> 
                    </form>
                  <?php } ?>
                  </div>
                  <div class="comment-content">
                    <?php echo htmlspecialchars($commentReply['content']);?>
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
