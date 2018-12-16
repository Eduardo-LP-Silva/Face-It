<!-- Coisas a editar: Geral - Nickname, Avatar | Personal - email, password -->

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
    <link href="../front_page/front_page_style.css" rel="stylesheet"/>
    <link href="../front_page/front_page_layout.css" rel="stylesheet"/>
    <link href="../profile/edit_profile.css" rel="stylesheet"/>
    <link href="../templates/navbar/navbar_layout.css" rel="stylesheet"/>
    <link href="../templates/navbar/navbar_style.css" rel="stylesheet"/>
  </head>
  <body>
    <?php $_GET['banner'] = 'The Face of the Internet'?>
    <?php include('../templates/navbar/navbar.php');?>

    <div id = "content">
        <h1>Fulfill the fields which you want to edit</h1>
        <form action="updateProfile.php"  method="post">
            <div class="group">
            <input type='hidden' value=<?= $_SESSION['username'] ?> name='client'/>
            <input type="text" name='avatar'>
                <label for="">Avatar</label>
            </div>
            <div class="group">
                <input type="password" name='password'>
                <label for="">Password</label>
            </div>
            <div class="group">
                <input type="email" name='email'>
                <label for="">Email</label>
            </div>
            <div class="group">
                <input type="text" name='description'>
                <label for="">Description</label>
            </div>
            <button type="submit" style="color: white;">Submit</button>
        </form>
    </div>
  </body>
</html>