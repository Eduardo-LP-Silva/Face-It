<?php
	
	//include_once('../connection.php');


	// Verifies if username already exists in the database
	function checkUsername($username){

		$db = new PDO('sqlite:../database/db.db');
    	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$stmt = $db->prepare("SELECT username FROM client WHERE username=?");
		$stmt->execute(array($username));

		return $stmt->fetch();
	}

	function insertClient($username, $pw, $mail){

		$db = new PDO('sqlite:../database/db.db');
    	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    	$stmt = $db->prepare("INSERT INTO client (username, pw, email, karma) VALUES(?, ?, ?, 0)");
    	$options = ['cost' => 12];
    	$stmt->execute(array($username, password_hash($pw, PASSWORD_DEFAULT, $options), $mail));
	}

	function checkClientComb($username, $pw){

		$db = new PDO('sqlite:../database/db.db');
    	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    	$stmt = $db->prepare('SELECT * FROM client WHERE username = ?');
    	$stmt->execute(array($username));

    	$user = $stmt->fetch();

    	return $user !== false && password_verify($pw, $user['pw']);
	}




?>