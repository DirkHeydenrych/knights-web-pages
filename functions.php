<?php
	//this function checks if there is any empty inputs in these fields
	function emptyInputRegister($name, $lastname, $email, $pwd, $pwdrepeat){
		$result;
		if (empty($name)||empty($lastname)||empty($email)||empty($pwd)||empty($pwdrepeat)){
		$result = true;	
		}
		else{
			$result = false;
		}
		return $result;
	}
	//function checks if the email is valid 
	function invalidEmail($email){
		$result;
		if (filter_var($email, FILTER_VALIDATE_EMAIL)){
		$result = true;	
		}
		else{
			$result = false;
		}
		return $result;
	}
	//function checks if the 2 passwords are the same
	function pwdMatch($pwd, $pwdrepeat){
		$result;
		if ($pwd !== $pwdrepeat){
		$result = true;	
		}
		else{
			$result = false;
		}
		return $result;
	}
	//function checks if the email already exists in database when the user wants to log into the website
	function emailExists($conn, $email){
		$sql = "SELECT * FROM accounts WHERE  email = ?;";
		$stmt = mysqli_stmt_init($conn);
		if (!mysqli_stmt_prepare($stmt, $sql)){
			header("location:../register.html?error=stmtfailed");
			exit();
		}
		mysqli_stmt_bind_param($stmt,"s",$email);
		mysqli_stmt_execute($stmt);
		
		$resultData = mysqli_stmt_get_result($stmt);
		
		if ($row = mysqli_fetch_assoc($resultData)){
			return $row;
		}
		else{
			$result = false;
			return $result;
		}
				
		mysqli_stmt_close($stmt);
	}
	//function let the user create their account and when the developer checks database the password field will be hased, by this means that the password
	//is in different letters, symbols and numebrs
	function createUser($conn, $name, $lastname, $email, $pwd)
{
		$sql = "INSERT INTO accounts (firstname,lastname,email,pwd) VALUES(?,?,?,?);";
		$stmt = mysqli_stmt_init($conn);
		if (!mysqli_stmt_prepare($stmt, $sql)){
			header("location:../register.html?error=stmtfailed");
			exit();
		}
		
		$hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
		
		mysqli_stmt_bind_param($stmt,"ssss",$name,$lastname,$email,$hashedPwd);
		mysqli_stmt_execute($stmt);		
		mysqli_stmt_close($stmt);
		header("location:../home page.html?error=none");
		exit();
	}
	//function checks if there is any empty inputs in the login page
	function emptyInputLogIn($email,$pwd){
		$result;
		if (empty($email)||empty($pwd)){
		$result = true;	
		}
		else{
			$result = false;
		}
		return $result;
	}
	//function checks if the email exists and if the password matches with the one that is on the database
	function loginUser($conn,$email,$pwd){
		$emailExists = emailExists($conn, $email);
		
		if ($emailExists === false){
			header("location:../login.html?error=wronglogin");
			exists();
		}
		$pwdHashed = $emailExists["pwd"];
		$checkPwd = password_verify($pwd, $pwdHashed);
		
		if($checkPwd === false){
			header("location:../login.php?error=wronglogin");
			exists();
		}
		else if ($checkPwd === true){
			session_start();
			$_SESSION["userid"] =  $emailExists["userid"];
			$_SESSION["useruid"] =  $emailExists["usersUid"];
			header("location:../home page.html");
			exists();
		}
		
	}
?>