<!DOCTYPE html>
<html lang="en-US">
<head>
  <title>FaceIt</title>    
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="login_style.css" rel="stylesheet">
  <link href="login_layout.css" rel="stylesheet">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" defer ></script>
  <script src="login.js" defer ></script>
</head>
<body>
  <header>
    <a id="title" href="login.php">FaceIt</a>
    <h1 id="subtitle"> Face of the Internet </h1>
  </header>
  <div class="login-page">
    <div id="form">
      <form id="login-form" action="log.php" method="POST"> <!-- Add action-->
        <input id="username" type="text" name="uid" placeholder="username"/>
        <input id="password" type="password" name="pw" placeholder="password"/>
        <button type="submit" name="login-submit">login</button>
        <p class="message">Don't have an account ? <a href="#">Register now</a></p>
      </form>
      <form id="register-form" action="reg.php" method="POST">
        <input type="text" name="uid" placeholder="name"/>
        <input type="password" name="pw" placeholder="password"/>
        <input type="text" name="mail" placeholder="email address"/>
        <button type="submit" name="register-submit">create</button>
        <p class="message">Already registered ?  <a href="#">Sign In</a></p>
      </form>
    </div>
  </div>
</body>
</html>
