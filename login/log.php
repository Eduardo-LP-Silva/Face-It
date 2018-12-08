<?php

	include_once('../database/client/get_client.php');
	include_once('session.php');

	if(isset($_POST['login-submit'])){

		$username = $_POST['uid'];
		$password = $_POST['pw'];

		if(empty($username) || empty($password)){
			header("Location: login.php?error=emptyfields");
			exit();
		}

		else {
			if(checkClientComb($username, $password)){
				$_SESSION['username'] = $username;
				header("Location: ../front_page/front_page.php");
				
			}
			else {
				header("Location: login.php?error=nouser");
				exit();
			}
		}

	}

	else {
		header("Location: login.php");
		exit();
	}



?>