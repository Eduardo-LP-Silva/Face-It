<?php

function UR_exists($url){
    $headers=get_headers($url);
    return stripos($headers[0],"200 OK")?true:false;
 }

$db = new PDO('sqlite:../database/db.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$clientId = $_POST["client"];
$description = $_POST["description"];
$password = $_POST["password"];
$email = $_POST["email"];
$avatar = $_POST["avatar"];


if ($password != ""){
    $stmt = $db->prepare("UPDATE client 
    SET pw = ?
    WHERE username = ?");
    $stmt->execute(array($password, $clientId));
}

if ($email != ""){
    $stmt = $db->prepare("UPDATE client 
    SET email = ?
    WHERE username = ?");
    $stmt->execute(array($email, $clientId));
}

if ($avatar != ""){
    if (UR_exists($avatar)) {
        $stmt = $db->prepare("UPDATE user_profile 
        SET picture = ?
        WHERE client = ?");
        $stmt->execute(array($avatar, $clientId));
    }
}

if ($description != ""){
    $stmt = $db->prepare("UPDATE user_profile 
    SET personal_description = ?
    WHERE client = ?");
    $stmt->execute(array($description, $clientId));
}
header("Location: ../profile/profile_posts.php?user=". $clientId);
exit();
?>