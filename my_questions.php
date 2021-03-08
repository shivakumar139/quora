<?php
    session_start();
    require("partials/conn.php");
    if(!isset($_SESSION["loggin"])){
        header("location: index.php");
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

    <title>My questions</title>
    <style>
        a{
            text-decoration: none;
        }
    </style>
  </head>
  <body>
    <?php require("partials/header.php");?>


    <div class="container">
        <table class="table table-striped table-hover mt-3 text-center">
                <thead>
                    <tr>
                    <th scope="col">Sr no</th>
                    <th scope="col">Question</th>
                    <th scope="col">Time</th>

                    <th scope="col" colspan="2">Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                        $user_id = $_SESSION["userid"];
                    
                        $query = "select * from question where question_asked_by = $user_id order by question_time desc";
                        $result = mysqli_query($conn,$query);
                        $sr_no = 1;
                        while($question = mysqli_fetch_assoc($result)){
                            $time = date("F j, Y, g:i a", strtotime($question["question_time"]));

                            echo '<tr>

                                <th scope="row">'.$sr_no++.'</th>
                                <td> <a href="/quora/discussion.php?question_id='.$question["question_id"].'" class="link-dark" id="title">'.$question["question_title"].'</a></td>

                                <td>'.$time.'</td>
                                <td><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" id="'.$question["question_id"].'" onclick="edit_question(this.id)">Edit</button> <a href="/quora/delete.php?question_id='.$question["question_id"].'" class="btn btn-danger mx-2" >Delete</a></td>

                                <td hidden>'.$question["question_description"].'</td>
                            </tr>';
                        }
                    ?>
                    
                </tbody>
        </table>
    </div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="/quora/partials/update_question.php" method="POST">
        <div class="mb-3 my-4">
        <input type="text" name="id" id="usno" hidden>
            <label for="exampleInputEmail1" class="form-label">Title</label>
            <input type="text" class="form-control" id="updatequestion" aria-describedby="title" name="title">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Description</label>
            <textarea name="desc" class="form-control" id="udesc" rows="3"></textarea>
        </div>
  <button type="submit" class="btn btn-primary" id="addNote">Update Now</button>
</form>
      </div>
    </div>
  </div>
</div>


<script>
        function edit_question(id){
            let card = document.getElementById(id).parentElement.parentElement;
            let title = card.children[1].innerText;
            let desc = card.children[4].innerText;
            
            document.getElementById("usno").value = id;
            document.getElementById("updatequestion").value = title;
            document.getElementById("udesc").value = desc;
        }
    </script>

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