<?php

require "db_connect.php";
$showError="false";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $email=$_POST["email"];
    $password=$_POST["password"];

    $q="select * from `users` where `user_email`='$email' ";
    $result=mysqli_query($con,$q);

    if(mysqli_num_rows($result)==1){
        $row=mysqli_fetch_assoc($result);
        $pM=password_verify($password,$row['user_password']);
        if($pM){
            session_start();
            $_SESSION['user_email']=$email;
            $_SESSION['flag']=true;
            $_SESSION['userId']=$row['sno'];
            header("location: /iDiscuss/index.php");
            exit();
        }
        else{
            $showError="Different password";
        }
    }
    else{
        $showError="Different username";
    }
    header("location: /iDiscuss/index.php?showError=$showError");
}

?>