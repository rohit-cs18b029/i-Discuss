<?php

$server="localhost";
$username="root";
$password="";
$database="iDiscuss";

$con=mysqli_connect($server,$username,$password,$database);

if(!$con){
    echo "Error : ---> ".mysqli_connect_error();
}

?>