<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
    integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <style>
        #mainContainer{
            min-height:100vh;
        }
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

    <title>threads</title>
</head>

<body>

    <?php 
          include "partials/db_connect.php";
          include "partials/header.php";

          $threadId=$_GET['tid'];

          $q="select * from `threads` where `threadId`='$threadId' ";
          $result=mysqli_query($con,$q);
          $row=mysqli_fetch_assoc($result);
          $threadTitle=$row['threadTitle'];
          $threadDesc=$row['threadDesc'];
          $threadUserId=$row['threadUserId'];
          $q2="select user_email from `users` where `sno`='$threadUserId' ";
          $result2=mysqli_query($con,$q2);
          $row2=mysqli_fetch_assoc($result2);
          $postedBy=$row2['user_email'];
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
        //insert comment
        $method=$_SERVER["REQUEST_METHOD"];
        if($method=="POST"){
            $comment=$_POST["comment"];
            $comment=str_replace("<", "&lt;", $comment);
            $comment=str_replace(">", "&gt;", $comment);
            $userId=$_SESSION["userId"];
            $q="INSERT INTO `comments` (`commentContent`, `threadId`, `timeStamp`, `commentBy`) 
                VALUES ('$comment', '$threadId', current_timestamp(), '$userId');";
            $result=mysqli_query($con,$q);
            if($result){
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Your comment has been successfully added, Wait for community to respond.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>';
            }
        }
    ?>

    <div class="container my-3">
        <div class="jumbotron">
            <h1 class="display-4"> <?php echo $threadTitle; ?></h1>
            <p class="lead"> <?php echo $threadDesc; ?> </p>
            <hr class="my-4">
            <p>
                This is peer to peer forum to sharing knowledge with each other
                No Spam / Advertising / Self-promote in the forums. ...
                Do not post copyright-infringing material. ...
                Do not post “offensive” posts, links or images. ...
                Do not cross post questions. ...
                Do not PM users asking for help. ...
                Remain respectful of other members at all times.
            </p>
            <p>
                <b>Posted by - <?php echo $postedBy; ?></b>
            </p>
        </div>
    </div>

    <div class="container">
        <h2 class="py-2">Discussions</h2>
        <?php 
            $q="select * from `comments` where `threadId`='$threadId' ";
            $result=mysqli_query($con,$q);
            $noResult=true;
            while($row=mysqli_fetch_assoc($result)){
                $noResult=false;
                $cId=$row['commentId'];
                $comment=$row['commentContent'];
                $commentTime=$row['timeStamp'];
                $commentBy=$row['commentBy'];
                $q2="select user_email from `users` where `sno`='$commentBy' ";
                $result2=mysqli_query($con,$q2);
                $row2=mysqli_fetch_assoc($result2);
                $user_email=$row2['user_email'];
        ?>
        <div class="media my-3">
            <img src="imgs/defaultUser.png" width="54" class="mr-3" alt="...">
            <div class="media-body">
            <p class="font-weight-bold my-0"><?php echo $user_email.' at '.$commentTime; ?> </p>
                <?php echo $comment; ?>
            </div>
        </div>
        <?php
            }

            if($noResult){
                echo '<div class="jumbotron jumbotron-fluid">
                <div class="container">
                  <h1 class="display-4">No comment!</h1>
                  <p class="lead">Be the first commenter.</p>
                </div>
              </div>';
            }
        ?>
    </div>

    <div class="container my-5">
        <h2 class="py-2">Post a comment</h2>
        <form action="<?php echo $_SERVER["REQUEST_URI"] ?>" method="POST">
            <div class="form-group">
                <label for="desc">Write here</label>
                <input type="text" class="form-control" id="comment" name="comment" required>
            </div>
            <?php
                if($loggedIn){
                    echo '<button type="submit" class="btn btn-success">Comment</button>';
                }
            ?>
        </form>
        <?php
            if(!$loggedIn){
                echo '<button onclick="fn1()" class="btn btn-success">Comment</button>';
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