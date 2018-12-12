<?php
  include_once('../login/session.php');
  include_once('../database/channels/get_channels.php');
  include_once('../database/connection.php');
   

  if(!isset($_SESSION['username']))
    die(header("Location: ../login/login.php?error=nosession"));

?>

<form id="channels" action=<?=$_POST['channel_path']?> method="get"> 
  <ul>
    <li> <a href="front_page.html"> New Channel </a> </li>
    <?php 
      $user_channels = get_subscribed_channels($_SESSION['username']); //Mudar para user

      foreach($user_channels as $channel)
      { ?>
        <li> <a href=<?=$_POST['channel_path'] . "?channel=" . htmlspecialchars($channel['channel'])?>>
          <?=htmlspecialchars($channel['channel'])?></a> </li>
        <?php 
      } ?>
  </ul>
</form>
