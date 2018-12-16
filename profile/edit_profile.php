<?php
  include_once('../login/session.php');
  include_once('../database/connection.php');

  if(!isset($_SESSION['username'])){
    die(header("Location: ../login/login.php?error=nosession"));
  }
?>

<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title>FaceIt</title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="../profile/edit_profile.css" rel="stylesheet"/>
    <link href="../templates/navbar/navbar_layout.css" rel="stylesheet"/>
    <link href="../templates/navbar/navbar_style.css" rel="stylesheet"/>
    <script src="../scripts/validate_profile_edit.js" defer> </script>
  </head>
  <body>
    <?php $_GET['banner'] = 'The Face of the Internet'?>
    <?php include('../templates/navbar/navbar.php');?>

    <div id = "content">
        <h1>Fill in the fields you want to edit</h1>
        <form action="../database/profile/update_profile.php"  method="post" onsubmit="return validate_profile_settings();">
            <div class="group">
            <input type='hidden' value=<?= $_SESSION['username'] ?> name='client'/>
            <input type="text" name='avatar'>
                <label for="avatar">Avatar</label>
            </div>
            <div class="group">
                <input type="password" name='password'>
                <label for="password">Password</label>
            </div>
            <div class="group">
                <input type="email" name='email'>
                <label for="email">Email</label>
            </div>
            <div class="group">
                <input type="text" name='description'>
                <label for="description">Description</label>
            </div>
            <button type="submit" style="color: white;">Submit</button>
        </form>
    </div>
  </body>
</html>