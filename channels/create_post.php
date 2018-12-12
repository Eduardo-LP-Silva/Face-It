<!DOCTYPE html>
<html lang="en-US">
  <head>
    <title>FaceIt</title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="../templates/navbar/navbar_layout.css" rel="stylesheet"/>
    <link href="../templates/navbar/navbar_style.css" rel="stylesheet"/>
    <link href="create_post_layout.css" rel="stylesheet"/>
    <link href="create_post_style.css" rel="stylesheet"/>
    <script src="../scripts/validate_post.js" defer> </script>
  </head>
  <body>
    <?php $_GET['banner'] = $_GET['channel'];?>
    <?php include('../templates/navbar/navbar.php');?>
    <form id="create_post" onsubmit="return validate_post(); window.location.href = window.location.href" 
      action="../database/stories/insert_stories.php" 
      method="POST">
      <input id="post_title" name="post_title" type="text" maxlength="100" placeholder="Title" required autofocus>
      <br>
      <input id="post_image" name="post_image" type="url" maxlength="300" placeholder="Image link (optional)">
      <br>
      <textarea id="post_text" name="post_text" maxlength="1200" placeholder="Text (optional)"></textarea>
      <input type="hidden" name="post_channel" value=<?=htmlspecialchars($_GET['channel'])?>>
      <input id="post_submit" type="submit" value="Post"> 
    </form>
  </body>
</html>