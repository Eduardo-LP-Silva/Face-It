<?php
    include_once('../database/connection.php');
?>

<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title>FaceIt</title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="../templates/navbar/navbar_layout.css" rel="stylesheet"/>
    <link href="../templates/navbar/navbar_style.css" rel="stylesheet"/>
    <link href="create_channel_layout.css" rel="stylesheet"/>
    <link href="create_channel_style.css" rel="stylesheet"/>
    <script src="../scripts/validate_channel.js" defer> </script>
  </head>
  <body>
    <?php $_GET['banner'] = 'The Face of the Internet';?>
    <?php include('../templates/navbar/navbar.php');?>
    <form id="create_channel" onsubmit="return validate_channel();" action="../database/channels/insert_channel.php">
      <input id="channel_name" name="channel_name" type="text" maxlength="40" placeholder="Channel Name" required autofocus>
      <br>
      <textarea id="channel_description" name="channel_description" required maxlength="1200" placeholder="Channel Description"></textarea>
      <input id="channel_submit" type="submit" value="Create Channel"> 
    </form>
  </body>
</html>