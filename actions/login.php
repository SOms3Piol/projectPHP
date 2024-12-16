<?php
	include("../connection.php");
	
	$email  = $_POST['email'];
	$password  = $_POST['password'];

	$query = "SELECT password FROM users WHERE email = ?";
	
	$prepare = $conn->prepare($query);
	$prepare->bind_param("s", $email);
	$prepare->execute();
	$result = $prepare->get_result();
	
	if(!password_verify($password , $result['password']){
		echo "Email or Password Invalid!";
		return;
	}

	setcookie("id", $result['id'] );
	header("Location: ../dashboard/dashboard.php?action=READ");


?>
