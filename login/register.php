<!DOCTYPE html>
<html lang="en-US">
<head>
  <title>FaceIt</title>    
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="register_style.css" rel="stylesheet">
  <link href="register_layout.css" rel="stylesheet">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" defer ></script>
  <script src="login.js" defer ></script>
</head>
<body>
  <?php 
   if(isset($_GET['error'])){
      $error = $_GET['error'];
      echo "<script type='text/javascript'>alert('".$error."')</script>"; 
    }
   ?>
  <header>
    <a id="title" href="login.php">FaceIt</a>
    <h1 id="subtitle"> Face of the Internet </h1>
  </header>
  <div class="register-page">
    <div id="form">
      <form id="register-form" action="reg.php" method="POST">
        <input type="text" name="uid" value="<?php if (isset($_GET['username'])) {echo $_GET['username'];} ?>" placeholder="name"/>
        <input type="password" name="pw" placeholder="password"/>
        <input type="text" name="mail" value="<?php if (isset($_GET['mail'])) {echo $_GET['mail'];} ?>" placeholder="email address"/>
        <button type="submit" name="register-submit">create</button>
        <p class="message">Already registered ?  <a href="login.php">Sign In</a></p>
      </form>
    </div>
  </div>
</body>
</html>