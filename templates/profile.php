<?php
  include_once('../login/session.php');
  include_once('../database/client/get_client.php');

  if(!$_GET['user'])
    die(header('Location: ../front_page/front_page.php'));

  $picture = get_client_picture($_GET['user'])['picture'];

  if(!$picture)
    $picture = "../assets/default_profile_photo.png";

?>

<section id="info">
        <?php
          echo '<h1 id="username"> '.$_GET['user'].' </h1>';
        ?>
      <img id="profile_image" src=<?=$picture?>>
      <h2 id="description"><?= get_client_description($_GET['user'])['personal_description'] ?></h2> 
      <?php
        if($_GET['user'] == $_SESSION['username'])
          echo '<a id="edit" href="edit_profile.php"> Edit </a>';
      ?>
    </section>
    <section id="stats">
      <div class="stat">
        <p> Karma </p>
        <?php
          $karma = get_client_field($_GET['user'],'karma');
          echo '<p> '.$karma[0].' </p>'
        ?>
      </div>
      <div class="stat">
        <p id="posts"> Posts </p>
        <?php
          $posts_counter = get_client_posts_count($_GET['user']);
          echo '<p id="post_no"> '.$posts_counter[0].' </p>';
        ?>
      </div>
      <div class="stat">
        <p id="comments"> Comments </p>
        <?php
          $comments_counter = get_client_comments_count($_GET['user']);
          echo '<p id="comment_no"> '.$comments_counter[0].' </p>';
        ?>
      </div>
    </section>
    <section id="history">
      <div id="history_selection">
        <a href=<?="../profile/profile_posts.php?user=" . $_GET['user']?>> Posts </a>
        <a href=<?="../profile/profile_comments.php?user=" . $_GET['user']?>> Comments </a>
      </div>


      