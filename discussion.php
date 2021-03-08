<?php
session_start();
    require("partials/conn.php");

    // upload comments in the data base
    if(isset($_POST["submit"]) && $_SERVER["REQUEST_METHOD"] == "POST"){
        $comment = htmlentities(mysqli_real_escape_string($conn,$_POST["comment"]));
        
        $question_id = $_SESSION["question_id"];
        $user_id = $_SESSION["userid"];
        $query = "INSERT INTO `comment`(`description`, `question_id`, `comment_by`) VALUES ('$comment','$question_id','$user_id')";

        mysqli_query($conn,$query);

    }







    function get_category_name($cat_id){
        global $conn;
        $query = "select category_name from category where category_id = $cat_id";
        $result = mysqli_query($conn,$query);
        $cat_id = mysqli_fetch_assoc($result);
        return $cat_id["category_name"];
    
    }


    function get_user_name($user_id){
        global $conn;
        $query = "select fullname from user where id = $user_id";
        $result = mysqli_query($conn,$query);
        $user_name = mysqli_fetch_assoc($result);
        return $user_name["fullname"];
      }


      //getting question information
      $_SESSION["question_id"] = $_GET["question_id"];
      $question_id = $_GET["question_id"];
      $query = "select * from question where question_id = $question_id";
      $result = mysqli_query($conn,$query);
    $question = mysqli_fetch_assoc($result);

?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <!-- jquery cdn -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <title>Discussion</title>
  </head>
  <body>
    <?php require("partials/header.php");?>


    <div class="container">
      <div class="row justify-content-center">

      
        <div class="col-12 col-md-10 bg-light text-center mt-3">
          <h1 class= "text-uppercase">
            <?php echo get_category_name($question["question_category_id"]);
               
            ?>
          </h1>
        </div>
        

        <?php
       
            $user_name = get_user_name($question["question_asked_by"]);

            $time = date("F j, Y, g:i a", strtotime($question["question_time"]));

            if(isset($_SESSION["loggin"])){

              echo '<div class="col-12 col-md-10 my-3 p-0">
              <div class="card">
              <div class="card-header">Asked By- <strong class="fw-bold">'.$user_name.  '</strong> <span class="d-flex justify-content-end">'.$time.'</span></div>
              
              <div class="card-body">
              <h5 class="card-title">'.$question["question_title"].'</h5>
              <p class="card-text">'.$question["question_description"].'</p>
              
              </div>
              <div class="card-footer text-muted">
              
              <form action '.$_SERVER["REQUEST_URI"].' method="POST">
              <div class="input-group my-3">
              
              <input type="text" name="comment" id="comment" class="form-control" placeholder="Add a comment..." required>
              <button type="submit" class="btn btn-primary mx-3 rounded" id="addComment" name="submit">Add comment</button>
              </div>
              </form>
              </div>
              </div>
              </div>';
            }
            else{
              echo '<div class="col-12 col-md-10 my-3 p-0">
              <div class="card">
              <div class="card-header">Asked By- <strong class="fw-bold">'.$user_name.  '</strong> <span class="d-flex justify-content-end">'.$time.'</span></div>
              
              <div class="card-body">
              <h5 class="card-title">'.$question["question_title"].'</h5>
              <p class="card-text">'.$question["question_description"].'</p>
              
              </div>
              <div class="card-footer text-muted">
              
              <div class="mb-3">
              <p class="text-muted">Please log in to submit your comment</p>
          </div>
              </div>
              </div>
              </div>';

            }
        
        ?>


        
    <?php
      

      //comments
      $query = "select * from comment where question_id = $question_id";
      $result = mysqli_query($conn,$query);
      if(mysqli_num_rows($result)){
        echo '<div class="col-12 col-md-10 bg-light text-center mt-3">
        <h3>comments</h3>
      </div>';
        while($comment = mysqli_fetch_assoc($result)){
            $time = date("F j, Y, g:i a", strtotime($comment["time"]));
            $user_name = get_user_name($comment["comment_by"]);
            echo '<div class="col-12 col-md-10 my-3 p-0">
            <div class="card">
            <div class="card-header"><strong class="fw-bold">'.$user_name.  '</strong> <span class="d-flex justify-content-end">'.$time.'</span></div>
            
            <div class="card-body">
              <p class="card-text">'.$comment["description"].'</p>
              
            </div>
          </div>
          </div>';
        }

      }else{
          echo '<div class="col-12 col-md-10 my-3 bg-light">
          <h2>
              Be the first to add comment
          </h2>
          </div>';
      }

    
    ?>
      </div>  


    </div>





    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
    -->
    
  </body>
</html>