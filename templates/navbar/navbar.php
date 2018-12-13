<?php
  include_once('../login/session.php');
  include_once('../database/client/get_client.php');

  $picture = get_client_picture($_SESSION['username'])['picture'];

  if(!$picture)
    $picture = "../assets/default_profile_photo.png";
?>

<header>
  <a id="title" href="../front_page/front_page.php">FaceIt</a>
  <a id="subtitle" href="../front_page/front_page.php"> <?=htmlspecialchars($_GET['banner'])?> </a>
  <nav>
      <a id="profile_pic" href=<?="../profile/profile_posts.php?user=" . $_SESSION['username']?>>
        <img src=<?=$picture?> alt="Profile Picture">
      </a>
      <a id="profile" href=<?="../profile/profile_posts.php?user=" . $_SESSION['username']?>> 
        <?=$_SESSION['username']?> </a>
      <a id="signout" href="../login/logout.php"> Sign out </a>
  </nav>
</header>
