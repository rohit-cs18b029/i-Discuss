<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>iDiscuss - Search</title>
    <style>
        #mainContainer{
            min-height:100vh;
        }
    </style>
</head>

<body>

    <?php 
          include "partials/db_connect.php";
          include "partials/header.php";
    ?>

    <div class="container my-3" id="mainContainer">
        <h1 class="py-3">Search result for <em>" <?php echo $_GET['query'] ?> "</em></h1>
        <?php
            $noResult=true;
            $query=$_GET['query'];
            $q="select * from `threads` where match(`threadTitle`,`threadDesc`) against('$query')";
            $result=mysqli_query($con,$q);
            while($row=mysqli_fetch_assoc($result)){
                $title=$row['threadTitle'];
                $desc=$row['threadDesc'];
                $id=$row['threadId'];
                $url="threads.php?tid=".$id;
                $noResult=false;

                echo '<div class="result">
                        <h3><a href="'. $url .'">'. $title .'</a></h3>
                        <p>'. $desc .'</p>
                      </div>';
            }

            if($noResult){
                echo '<div class="jumbotron jumbotron-fluid">
                <div class="container">
                  <h1 class="display-4">No Result Found!</h1>
                  <p class="lead">
                    <ul>
                      <li>
                          Make sure that all words are spelled correctly.
                      </li>
                      <li>
                          Try different keywords.
                      </li>
                      <li>
                          Try more general keywords.
                      </li>
                    </ul>
                  </p>
                </div>
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