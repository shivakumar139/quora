<?php

session_start();

if(isset($_SESSION["username"]) && $_SESSION["loggin"] == true){
  header("location: ../index.php");
}

require("../partials/conn.php");
$err_type = "";
$err_msg = "";
$insert_msg = "";
    
        if($_SERVER["REQUEST_METHOD"] == "POST"){
          $full_name = htmlentities(mysqli_real_escape_string($conn,$_POST["fullname"]));
          $phone_no = htmlentities(mysqli_real_escape_string($conn,$_POST["phoneno"]));
          $email = htmlentities(mysqli_real_escape_string($conn,$_POST["email"]));
          $password = htmlentities(mysqli_real_escape_string($conn,$_POST["password"]));
          $cpasword = htmlentities(mysqli_real_escape_string($conn,$_POST["cpassword"]));

          if(password_match($password,$cpasword)){
            if(!email_exist($email)){
              $password_hash = password_hash($password,PASSWORD_BCRYPT);
              $query = "INSERT INTO `user`(`fullname`, `phoneno`, `email`, `password`) VALUES ('$full_name','$phone_no','$email','$password_hash')";

              $result = mysqli_query($conn,$query);

              if($result){
                $insert_msg = "true";
              }
              else{
                $insert_msg = "false";
              }
            }
          }
        }


        function password_match($password,$cpasword){
          global $err_msg,$err_type;
          if($password === $cpasword){
            return true;
          }
          else{
            $err_type = "password";
            $err_msg = "password not equal";
            return false;
          }
        }

        function email_exist($email){
          global $err_msg,$err_type,$conn;
          $query = "select * from user where email = '$email'";

          $exist = mysqli_num_rows(mysqli_query($conn,$query));
          if($exist){
            $err_type = "email";
            $err_msg = "Email already exists";
            return true;
          }
          else{
            return false;
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

    <title>Sign Up</title>


    <style>
        .row{
            height: 100vh;
        }
    </style> 
  </head>
  <body>
  <div class="container-fluid">
  <nav class="navbar navbar-light ps-5">
  <div class="container-fluid">
  <a class="navbar-brand fw-bold fs-2" href="/quora/index.php">Quora</a>
  </div>
</nav>
  </div>

    <div class="container">
    <?php
      if($insert_msg == "true"){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Sign Up Successfull. You can now <a href="login.php" class="alert-link">login here.</a>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
      }
      if($insert_msg == "false"){
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>Error!</strong> we are facing some issue please tray again later.
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
      }
    ?>
      
        <div class="row justify-content-center align-items-center">
        <!-- <h1 class="text-center fw-bold">Sign Up Form</h1> -->
            <div class="col-md-6 shadow p-4 rounded bg-body">
            <h1 class="text-center fw-bold">Sign Up Form</h1>
              <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST">
                <div class="mb-3">
                    <label for="full name" class="form-label">Full name</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="fullname" required name="fullname">
                  </div>
                  <div class="mb-3">
                    <label for="phone no" class="form-label">Phone No. (optional)</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="phoneno" name="phoneno">
                  </div>
                  <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required name="email">
                    <?php
                    // echo $err_type.$err_msg;
                      if($err_type == "email"){
                        echo '<small class="text-danger">'.$err_msg.'</small>';
                      }
                    ?>
                  </div>
                  <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" required name="password">
                  </div>
                  <div class="mb-3">
                    <label for="confirm password" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="cpassword">
                    <?php
                      if($err_type == "password"){
                        echo '<small class="text-danger">'.$err_msg.'</small>';
                      }
                    ?>
                  </div>
                  <div class="d-grid">
                  <button type="submit" class="btn btn-primary" name="submit">Sign Up</button>
                  </div>
              </form>
              <p class="mt-4">Have an account? <a href="login.php">Log In Here</a></p>
            </div>
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

