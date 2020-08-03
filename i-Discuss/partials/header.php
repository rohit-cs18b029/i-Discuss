<?php

session_start();

echo '  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<a class="navbar-brand" href="index.php">iDiscuss</a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
    <li class="nav-item active">
        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="about.php">About</a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Top categories
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">';

          $q="select categoryName,categoryId from `category` limit 3 ";
          $result=mysqli_query($con,$q);
          while($row=mysqli_fetch_assoc($result)){
            $cat=$row['categoryName'];
            $catid=$row['categoryId'];
            echo '<a class="dropdown-item" href="threadsList.php?catId='. $catid .'">'. $cat .'</a>';
          }

        echo '</div>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="contact.php">Contact</a>
    </li>
    </ul>
    <form class="form-inline my-2 my-lg-0" action="search.php" method="GET">
    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="query">
    <button class="btn btn-success my-2 my-sm-0" type="submit">Search</button>
    </form>';
    if(!isset($_SESSION["flag"]) || $_SESSION["flag"]!=true){
        echo '<button class="btn btn-outline-success my-2 my-sm-0 ml-2" data-toggle="modal" data-target="#loginModal">Login</button>
              <button class="btn btn-outline-success my-2 my-sm-0 ml-2" data-toggle="modal" data-target="#signUpModal">SignUp</button>';
    }
    else{
        echo '<p class="text-light my-0 mx-2">Welcome '.$_SESSION["user_email"].'</p>';
        echo '<a role="button" href="/iDiscuss/partials/logout.php" class="btn btn-outline-success my-2 my-sm-0 ml-2">Logout</a>';
    }

    echo '</div>
          </nav>';

include "loginModal.php";
include "signUpModal.php";

if(isset($_GET['flag']) && $_GET['flag']=="true"){
    echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
            <strong>Success!</strong>Ready to Login 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>';
}
else{
    if(isset($_GET['showError'])){
        echo '<div class="alert alert-warning alert-dismissible fade show my-0" role="alert">
            <strong>Warning!</strong> '.$_GET['showError'].'
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>';
    }
}

?>