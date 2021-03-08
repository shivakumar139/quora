<?php
session_start();

if(isset($_SESSION["username"]) && $_SESSION["loggin"] == true){
  header("location: ../index.php");
}
require("../partials/conn.php");
$err_type = "";
$err_msg = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = htmlentities(mysqli_real_escape_string($conn,$_POST["email"]));
    $password = htmlentities(mysqli_real_escape_string($conn,$_POST["password"]));

    $query = "select * from user where email = '$email'";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result)){
        $data = mysqli_fetch_assoc($result);

        if($email == $data["email"] && password_verify($password,$data["password"])){

            $_SESSION["loggin"] = true;
            $_SESSION["username"] = $data["fullname"];
            $_SESSION["userid"] = $data["id"];
            // $_SESSION["userid"] = "1";
            header("location: ../index.php");
        }
        else{
            $err_type = "password_error";
            $err_msg = "Invalid password"; 
        }
    }
    else{
        $err_type = "email_password_error";
        $err_msg = "Invalid Username and password";
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

    <title>Login</title>


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
      if($err_type == "email_password_error"){
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong>'.$err_msg.'
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
      }
      ?>    
        <div class="row justify-content-center align-items-center">
        <!-- <h1 class="text-center fw-bold">Sign Up Form</h1> -->
            <div class="col-md-6 shadow p-4 rounded bg-body">
            <h1 class="text-center fw-bold pb-3">Login Form</h1>
              <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="POST">
                  <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required name="email">
                  </div>
                  <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" required name="password">
                    <?php
                    // echo $err_type.$err_msg;
                      if($err_type == "password_error"){
                        echo '<small class="text-danger">'.$err_msg.'</small>';
                      }
                    ?>
                  </div>
                  <div class="d-grid">
                  <button type="submit" class="btn btn-primary" name="submit">Log In</button>
                  </div>
              </form>
              <p class="mt-4">Don't have an account? <a href="signup.php">Sign Up Here</a></p>
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

