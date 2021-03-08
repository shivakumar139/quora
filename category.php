<?php
session_start();
    require("partials/conn.php");


    function get_category_name($cat_id){
      global $conn;
      $query = "select category_name from category where category_id = $cat_id";
      $result = mysqli_query($conn,$query);
      $cat_id = mysqli_fetch_assoc($result);
      return $cat_id["category_name"];
  
  }
  $cat_name = get_category_name($_GET["cat_id"]);


  //getting user name by passing user id from question table
  function get_user_name($user_id){
    global $conn;
    $query = "select fullname from user where id = $user_id";
    $result = mysqli_query($conn,$query);
    $user_name = mysqli_fetch_assoc($result);
    return $user_name["fullname"];
  }

    
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <title>Category</title>
  </head>
  <body>
    <?php require("partials/header.php"); ?>

    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 col-md-10 bg-light text-center mt-3">
          <h1 class= "text-uppercase">
            <?php echo $cat_name;?>
          </h1>
        </div>

        <?php
        $cat_id = $_GET["cat_id"];
        $query = "select * from question where question_category_id = $cat_id order by question_id desc";
        $result = mysqli_query($conn,$query);
          while($question = mysqli_fetch_assoc($result)){
            $user_name = get_user_name($question["question_asked_by"]);

            $time = date("F j, Y, g:i a", strtotime($question["question_time"]));
            echo '<div class="col-12 col-md-10 my-3">
            <div class="card">
            <div class="card-header">Asked By- <strong class="fw-bold">'.$user_name.  '</strong> <span class="d-flex justify-content-end">'.$time.'</span></div>
            
            <div class="card-body">
              <h5 class="card-title">'.$question["question_title"].'</h5>
              <p class="card-text">'.$question["question_description"].'</p>
              <a href="discussion.php?question_id='.$question["question_id"].'" class="btn btn-primary">Start Discussion</a>
            </div>
          </div>
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