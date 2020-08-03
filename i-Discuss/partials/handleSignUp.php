<?php

require "db_connect.php";
$showError="false";
$flag="false";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $email=$_POST["email"];
    $password=$_POST["password"];
    $cpassword=$_POST["cpassword"];


    $q="select * from `users` where user_email='$email';";
    $result=mysqli_query($con,$q);
    if(mysqli_num_rows($result)>0){
        $showError="Email in use";
    }
    else if($password==$cpassword){
        $hash=password_hash($password,PASSWORD_DEFAULT);
        $q="INSERT INTO `users` (`user_email`, `user_password`, `timeStamp`) 
            VALUES ('$email', '$hash', current_timestamp());";
        $result=mysqli_query($con,$q);
        if($result){
            $flag="true";
        }
    }
    else{
        $showError="Not same passwords";
    }
    header("location: /iDiscuss/index.php?flag=$flag&showError=$showError");
}

?>