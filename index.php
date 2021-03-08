<?php

session_start();
require("partials/conn.php");

//getting the category id from category table
function get_category_id($category){
    global $conn;
    $query = "select category_id from category where category_name = '$category'";
    $result = mysqli_query($conn,$query);
    $cat_id = mysqli_fetch_assoc($result);
    return $cat_id["category_id"];

}

$server_msg = "";

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["loggin"])){
    $title = htmlentities(mysqli_real_escape_string($conn,$_POST["question_title"]));
    $category = htmlentities(mysqli_real_escape_string($conn,$_POST["category"]));
    $cat_id = get_category_id($category); 
    $desc = htmlentities(mysqli_real_escape_string($conn,$_POST["question_desc"]));

    $user_id = $_SESSION["userid"];
    $query = "INSERT INTO `question`(`question_title`, `question_description`, `question_category_id`, `question_asked_by`) VALUES ('$title','$desc','$cat_id',$user_id)";

    if(mysqli_query($conn,$query)){
        $server_msg = "true";
    }
    else{
        $server_msg = "false";
    }    

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


 
    <title>Quora -for students</title>
    
  </head>
  <body>
   
             <?php require("partials/header.php");?>
    <?php
    
        if($server_msg == "true"){
            echo '<div aria-live="polite" aria-atomic="true" class="position-relative">
            <div class="toast-container position-absolute top-0 end-0 p-3">
                <div class="toast align-items-center text-white bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-animation="true" data-bs-autohide="true" id="toast">
                    <div class="d-flex">
                      <div class="toast-body">
                        Successfully asked question.
                      </div>
                      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        </div>';
        }
        if($server_msg == "false"){
            echo '<div aria-live="polite" aria-atomic="true" class="position-relative">
            <div class="toast-container position-absolute top-0 end-0 p-3">
                <div class="toast align-items-center text-white bg-danger border-0 show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-animation="true" data-bs-autohide="true" id="toast">
                    <div class="d-flex">
                      <div class="toast-body">
                        Error! Please try again.
                      </div>
                      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        </div>';
        }
    ?>

<div class="container">
        <div class="row justify-content-center pt-4">
            <div class="col-12 col-md-8">
                <form action='<?php echo $_SERVER["PHP_SELF"];
                ?>' method="POST">
                    <div class="mb-3">
                        <label for="title" class="form-label">Question Title</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Ask your question" name="question_title" required>
                        
                    </div>

                    <div class="mb-3 mt-3">
                        <select class="form-select" aria-label="Default select example" name="category" required>
                        <option value="" selected>Category</option>
                        <?php
                            
                            $query = "select * from category";
                            
                            if($result = mysqli_query($conn,$query)){
                                while($data = mysqli_fetch_assoc($result)){
                                    echo '<option value='.$data["category_name"].'>'.$data["category_name"].'</option>';
                                }
                            }
                        
                        ?>
                        </select>
                        
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="" cols="30" rows="8" placeholder="Question Description" name="question_desc" required></textarea>
                    </div>
                    
                        <?php
                            if(isset($_SESSION["loggin"])){
                                echo '<button type="submit" class="btn btn-primary">Submit</button>';
                            }
                            else{
                                echo '<div class="mb-3">
                                    <p class="text-muted">Please log in to submit your question</p>
                                </div>';
                            }
                        ?>
                    
                </form>
            </div>
        </div>
    </div>
    

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    
    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
    -->

    <script>
        let option = {
            animation: true,
            delay: 3000
        };
        let toast = document.getElementById("toast");
        let t = new bootstrap.Toast(toast, option);
        t.show();
    </script>





  </body>
</html>