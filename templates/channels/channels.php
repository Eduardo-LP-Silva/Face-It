<form id="channels" action=<?=$_POST['channel_path']?> method="get"> 
  <ul>
    <li> <a href="front_page.html"> New Channel </a> </li>
    <?php 
      include_once('../database/channels/get_channels.php');
      include_once('../database/connection.php');
   
      $user_channels = get_subscribed_channels('Des_locado'); //Mudar para user

      foreach($user_channels as $channel)
      { ?>
        <li> <a href=<?=$_POST['channel_path'] . "?channel=" . $channel['channel']?>> <?=$channel['channel']?> </a> </li>
        <?php 
      } ?>
  </ul>
</form>
