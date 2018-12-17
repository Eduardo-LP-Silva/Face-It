<?php
  include_once('../login/session.php');
  include_once('../database/connection.php');
  include_once('../database/client/get_client.php');

  $picture = get_client_picture($_SESSION['username'])['picture'];
?>

<header>
  <a id="title" href="../front_page/front_page.php">FaceIt</a>
  <a id="subtitle" href="../front_page/front_page.php"> <?=htmlspecialchars($_GET['banner'])?> </a>
  <nav>
      <a id="profile_pic" href=<?="../profile/profile_posts.php?user=" . $_SESSION['username']?>>
        <img style="margin-left:35em;"src=<?=$picture?> alt="Profile Picture">
      </a>
      <a id="profile" href=<?="../profile/profile_posts.php?user=" . $_SESSION['username']?>> 
        <?=$_SESSION['username']?> </a>
      <a id="signout" href="../login/logout.php"> Sign out </a>
  </nav>
</header>
