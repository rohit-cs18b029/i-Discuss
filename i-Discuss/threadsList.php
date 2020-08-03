<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>threadsList</title>
    <style>
        #hide{
            display:none;
        }
    </style>
    <script>
        function fn1() {
            var x = document.getElementById("hide");
            x.style.display = "block";
        }
    </script>
</head>

<body>

    <?php 

    include "partials/db_connect.php";
    include "partials/header.php";
          
    ?>

    <?php

          $catId=$_GET['catId'];
          $q="select * from `category` where `categoryId`='$catId' ";
          $result=mysqli_query($con,$q);
          $row=mysqli_fetch_assoc($result);
          $cat=$row['categoryName'];
          $desc=$row['categoryDesc'];
    ?>

    <?php
        $loggedIn=false;
        $userId="";
        if(isset($_SESSION["flag"]) && $_SESSION["flag"]==true){
            $loggedIn=true;
            $userId=$_SESSION["userId"];
        }        
    ?>

    <?php
        //insert thread
        $method=$_SERVER["REQUEST_METHOD"];
        if($method=="POST"){
            $threadTitle=$_POST["title"];
            $threadTitle=str_replace("<", "&lt;", $threadTitle);
            $threadTitle=str_replace(">", "&gt;", $threadTitle);
            $threadDesc=$_POST["desc"];
            $threadDesc=str_replace("<", "&lt;", $threadDesc);
            $threadDesc=str_replace(">", "&gt;", $threadDesc);
            $q="INSERT INTO `threads` (`threadTitle`, `threadDesc`, `threadCatId`, `threadUserId`, `timestamp`) 
                VALUES ('$threadTitle', '$threadDesc', '$catId', '$userId', current_timestamp());";
            $result=mysqli_query($con,$q);
            if($result){
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Your thread has been successfully added, Wait for community to respond.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
            }
        }
    ?>

    <div class="container my-3">
        <div class="jumbotron">
            <h1 class="display-4">Wecome to <?php echo $cat; ?> Forums</h1>
            <p class="lead"> <?php echo $desc; ?> </p>
            <hr class="my-4">
            <p>This is peer to peer forum to sharing knowledge with each other
                No Spam / Advertising / Self-promote in the forums. ...
                Do not post copyright-infringing material. ...
                Do not post “offensive” posts, links or images. ...
                Do not cross post questions. ...
                Do not PM users asking for help. ...
                Remain respectful of other members at all times.</p>
            <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a>
        </div>
    </div>

    <div class="container">
        <h2 class="py-2">Browse Questions</h2>
        <?php 
            $q="select * from `threads` where `threadCatId`='$catId' ";
            $result=mysqli_query($con,$q);
            $noResult=true;
            while($row=mysqli_fetch_assoc($result)){
                $noResult=false;
                $id=$row['threadId'];
                $title=$row['threadTitle'];
                $desc=$row['threadDesc'];
                $threadTime=$row['timeStamp'];
                $threadUserId=$row['threadUserId'];
                $q2="select user_email from `users` where `sno`='$threadUserId' ";
                $result2=mysqli_query($con,$q2);
                $row2=mysqli_fetch_assoc($result2);
                $user_email=$row2['user_email'];
        ?>
        <div class="media my-3">
            <img src="imgs/defaultUser.png" width="54" class="mr-3" alt="...">
            <div class="media-body">
                <p class="font-weight-bold my-0"><?php echo $user_email.' at '.$threadTime; ?> </p>
                <?php echo'<h5 class="mt-0"><a href="threads.php?tid='.$id.'" class="text-dark">'.$title.'</a></h5>'; ?>
                <?php echo $desc; ?>
            </div>
        </div>
        <?php
            }

            if($noResult){
                echo '<div class="jumbotron jumbotron-fluid">
                <div class="container">
                  <h1 class="display-4">No Threads found!</h1>
                  <p class="lead">Be the first person to ask a question.</p>
                </div>
              </div>';
            }
        ?>
    </div>

    <div class="container my-5">
        <h1>Start a Discussion</h1>
        <form action="<?php echo $_SERVER["REQUEST_URI"] ?>" method="POST">
            <div class="form-group">
                <label for="title">Problem Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp" required>
                <small id="emailHelp" class="form-text text-muted">Keep your title as short and crisp as
                    possible.</small>
            </div>
            <div class="form-group">
                <label for="desc">Ellaborate your Concern</label>
                <input type="text" class="form-control" id="desc" name="desc" required>
            </div>
            <?php
                if($loggedIn){
                    echo '<button type="submit" class="btn btn-success">Submit</button>';
                }
            ?>
        </form>
        <?php
            if(!$loggedIn){
                echo '<button onclick="fn1()" class="btn btn-success">Submit</button>';
                echo '<br>';
                echo '<div id="hide" class="alert alert-warning" role="alert">
                           Login first!
                      </div>';
            }
        ?>
    </div>

    <?php  include "partials/footer.php" ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
    </script>
</body>

</html>