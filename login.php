<?php

if (isset($_POST['submit'])){
	$email =$_POST['email'];
	$pwd =$_POST['pwd'];
	
	require_once "dbh.php";
	require_once "functions.php";
	
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$pwd = mysqli_real_escape_string($conn, md5($_POST['pwd']));

	$select = mysqli_query($conn, "SELECT * FROM `accounts` WHERE email = '$email' AND pwd = '$pwd'") or die('query failed');

	if(mysqli_num_rows($select) > 0){
      $row = mysqli_fetch_assoc($select);
      $_SESSION['usersid'] = $row['id'];
      header('location:home.php');
	}else{
      $message[] = 'incorrect email or password!';
	}

	if (emptyInputLogIn($email,$pwd) !== false){
		header("location: ../login.html?error=emptyinput");
		exit();
	}	
	loginUser($conn,$email,$pwd);
}
else{
	header("location:../login.html");
	exit();
}
?>