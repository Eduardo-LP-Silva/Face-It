<?php
  include_once('../login/session.php');
  include_once('../database/channels/get_channels.php');
  include_once('../database/connection.php');
   

  if(!isset($_SESSION['username']))
    die(header("Location: ../login/login.php?error=nosession"));

?>

<form id="channels" action="../channels/channel.php" method="get"> 
  <ul>
    <li> <a href="../channels/create_channel.php"> New Channel </a> </li>
    <li> <a href="../front_page/all.php">All</a> </li>
    <li> <a href="../front_page/front_page.php">Front Page</a> </li>
    <?php 
      $user_channels = get_subscribed_channels($_SESSION['username']);

      foreach($user_channels as $channel)
      { ?>
        <li> <a href=<?= "../channels/channel.php?channel=" . htmlspecialchars($channel['channel'])?>>
          <?=htmlspecialchars($channel['channel'])?></a> </li>
        <?php 
      } ?>
  </ul>
</form>
