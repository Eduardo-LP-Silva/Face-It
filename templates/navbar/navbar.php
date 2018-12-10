<?php
  include_once('../login/session.php');
?>

<header>
  <a id="title" href="../front_page/front_page.php">FaceIt</a>
  <a id="subtitle" href="../front_page/front_page.php"> <?=$_GET['banner'] ?> </a>
  <nav>
      <a id="profile_pic" href="../profile/profile_posts.php"> <!-- Change to profile.html -->
        <img src="../assets/profile_pic.png" alt="Profile Picture">
      </a>
      <?php
          echo '<a id="profile" href="front_page.html"> '.$_SESSION['username'].' </a>';
      ?>
      <a id="signout" href="../login/logout.php"> Sign out </a>
  </nav>
</header>
