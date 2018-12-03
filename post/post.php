<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Post</title>
    <link rel="stylesheet" href="post.css">
  </head>
  <body>
    <?php include('../templates/navbar.php');?>
    <?php include('../templates/channels.php');?>

    <div id = "content">
      <h1>Homossexualidade ainda é motivo de preconceito?</h1>
      <img src="../assets/deslocado.jpg">
      <p id = "description">Em pleno séc. XXI ainda existem grandes problemas no que diz respeito à integração daqueles que apresentam traços diferentes relativamente aos padrões da nossa sociedade.
      Esperemos que esta imagem ajude a mudar mentalidades preconceituosas. Apresentamos por isso Joāo Alves, membro dessa espécie.</p>
      <p id = "postData"> 3duardo S posted this on 03/12/2018</p>
    </div>

    <div id="commentInput">
      <form action="/my-handling-form-page" method="post"> 
          <p id = "commentsNumber">496 Comments</p>
          <input type="text" id="name" name="user_name" placeholder="       Add a comment"/>
      </form>
    </div>

    <div id="comments">
      <div class = "comment">
        <p class = "commentData"><span class = "commentUser">FF7</span>  <span>1000 votes</span>  <span>6hours ago</span></p>
        <p class = "commentDesc">Ganda Paneleiro!</p>
      </div>
    </div>
  </body>
</html>
