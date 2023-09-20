<?php
session_start();
include "../database/env.php";
$fname = $_REQUEST['fname'];
$lname = $_REQUEST['lname'];
$email = $_REQUEST['email'];
$password = $_REQUEST['password'];
$encPassword = password_hash($password, PASSWORD_BCRYPT);
$confirmPassword = $_REQUEST['confirmPassword'];
$errors = [];

//validation

if(empty($fname)){
    $errors['fname_error'] = "First name missing!";
}
if(empty($lname)){
    $errors['lname_error'] = "Last name missing!";
}
if(empty($email)){
    $errors['email_error'] = "Email missing!";
}
else if( !filter_var($email, FILTER_VALIDATE_EMAIL)){
    $errors['email_error'] = "Please enter your valid email!";
}
if(empty($password)){
    $errors['password_error'] = "Password missing!";
}
else if(strlen($password < 8)){
    $errors['password_error'] = "Password must be 8 characters";
}
else if($password != $confirmPassword){
    $errors['password_error'] = "Password did not match";
}


// Error direction

if(count($errors) > 0){
    $_SESSION['register_errors'] = $errors;
    header("Location: ../backend/register.php");
}
else{
    $query = "INSERT INTO `users`(`fname`, `lname`, `email`, `password`) VALUES ('$fname', '$lname', '$email', '$encPassword')";

    $result = mysqli_query($conn, $query);
    if($result){
        header("Location: ../backend/login.php");
    }
}



