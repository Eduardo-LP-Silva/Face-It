<!-- Replace info with respective user's -->
<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title>FaceIt</title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="profile_style.css" rel="stylesheet"/>
    <link href="profile_layout.css" rel="stylesheet"/>
  </head>
  <body>
    <?php include('../templates/navbar.php'); ?>
    <section id="info">
      <h1 id="username"> 3duardo_S </h1>
      <img id="profile_image" src="../assets/profile_pic.png"/>
      <h2 id="description"> A.k.a Marinheiro Ok Ok 4Real das Streetz </h2>
    </section>
    <section id="stats">
      <div class="stat">
        <p> Karma </p>
        <p> 356 </p>
      </div>
      <div class="stat">
        <p id="posts"> Posts </p>
        <p id="post_no"> 3 </p>
      </div>
      <div class="stat">
        <p id="comments"> Comments </p>
        <p id="comment_no"> 2 </p>
      </div>
    </section>
    <section id="history">
      <div class="history_item">
        
      </div>
    </section>
  </body>
</html>