<?php

	$email = $_POST['email'];
	$password = $_POST['password'];

	$query = " SELECT * FROM users WHERE email = ?";
	
	$preparedStmt = $conn->prepare($query);
	$preparedStmt->bind_param("s", $email);
	$preparedStmt->execute();
	$result = $preparedStmt->get_result();

	if($result->num_rows){
		echo "User Already Exists";
		return;
	}

	$hashedPass = password_hash($password,PASSWORD_DEFAULT);
	$insertQuery = "INSERT INTO users(email,password) VALUES(?,?)";
	$prepareInsertQuery = $conn->prepare($insertQuery);
	$prepareInsertQuery->bind_param("ss", $email, $hashPass);
	
	if(!$prepareInsertQuery->execute()){
		echo "Registration Failed!";
	}



?>
