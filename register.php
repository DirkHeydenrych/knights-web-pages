<?php

if (isset($_POST['submit'])){

    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];
    $pwdrepeat = $_POST['pwdrepeat'];

    require_once 'dhb.php';
    require_once 'functions.php';

    if (emptyInputRegister($name, $lastname, $email, $pwd, $pwdrepeat) !== false) {
        header("location: register.html?error=emptyinput" );
        exit();
    }
    if (invalidEmail($email) !== false) {
        header("location: register.html?error=invalidEmail" );
        exit();
    }
    if (pwdMatch($pwd, $pwdrepeat) !== false) {
        header("location: register.html?error=passwordsdon'tmatch" );
        exit();
    }
    if (emailExists($conn,$email) !== false) {
        header("location: register.html?error=emailExists" );
        exit();
    }

    createUser($conn,$name,$surname,$email,$pwd);
}
else {
    header("location:register.html");
    exit();
}
?>