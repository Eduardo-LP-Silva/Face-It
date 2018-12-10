<?php
  include_once('../login/session.php');
  include_once('../database/client/get_client.php');
?>

<section id="info">
        <?php
          echo '<h1 id="username"> '.$_SESSION['username'].' </h1>';
        ?>
      <img id="profile_image" src="../assets/profile_pic.png"/>
      <h2 id="description"> A.k.a Marinheiro Ok Ok 4Real das Streetz </h2>
      <a id="edit" href="../front_page/front_page.php"> Edit </a>
    </section>
    <section id="stats">
      <div class="stat">
        <p> Karma </p>
        <?php
          $karma = get_client_field('karma');
          echo '<p> '.$karma[0].' </p>'
        ?>
      </div>
      <div class="stat">
        <p id="posts"> Posts </p>
        <?php
          $posts_counter = get_client_posts_cnt();
          echo '<p id="post_no"> '.$posts_counter[0].' </p>';
        ?>
      </div>
      <div class="stat">
        <p id="comments"> Comments </p>
        <?php
          $comments_counter = get_client_comments_cnt();
          echo '<p id="comment_no"> '.$comments_counter[0].' </p>';
        ?>
      </div>
    </section>
    <section id="history">
      <div id="history_selection">
        <a href="../profile/profile_posts.php"> Posts </a>
        <a href="../profile/profile_comments.php"> Comments </a>
      </div>


      