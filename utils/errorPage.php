<?php
  include_once('../login/session.php');
  $error = $_SESSION['error_message'];

?>

<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title>FaceIt</title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="errorPage_layout.css" rel="stylesheet"/>
    <link href="errorPage_style.css" rel="stylesheet"/>
  </head>
  <body>
    <div id="errorBox">
      <p><?php  echo $error ?></p>
      <a id="btn" href="../front_page/front_page.php">CONTINUE</a>
    </div>
  </body>
</html>