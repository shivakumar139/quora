<div class="container-fluid p-0 bg-primary">
       <div class="container">
                <nav class="navbar navbar-expand-lg w-100 navbar-dark bg-primary">
                            <div class="container-fluid">
                                <a class="navbar-brand fw-bold fs-2" href="/quora/index.php">Quora</a>
                                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                                </button>
                                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                    <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="/quora/index.php">Home</a>
                                    </li>
                                    
                                    <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Category
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <?php
                                            require("partials/conn.php");

                                            $query = "select * from category";
                                            
                                            if($result = mysqli_query($conn,$query)){
                                                while($data = mysqli_fetch_assoc($result)){
                                                    echo '<li><a class="dropdown-item" href="category.php?cat_id='.$data["category_id"].'">'.$data["category_name"].'</a></li>';
                                                }
                                            }
                                        
                                        ?>
                                        
                                    </ul>
                                    </li>
                                </ul>
                                <div class="col mx-5">
                                <form class="d-flex" action="/quora/search.php" method="GET">
                                    <input class="form-control me-2 input-lg" type="search" placeholder="Search" aria-label="Search" name="search">
                                    
                                </form>
                                </div>

                                <?php
                                    if(!isset($_SESSION["loggin"])){
                                        echo '<div class="d-flex">
                                        <a href="../quora/login/login.php" class="btn btn-outline-light mx-3">Log In</a>
                                        <a href="../quora/login/signup.php" class="btn btn-outline-light">Sign Up</a>
                                </div>
                                ';
                                      }
                                      else{
                                            echo '<div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            '.$_SESSION["username"].'
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                              <li><a class="dropdown-item" href="/quora/my_questions.php">My questions</a></li>
                                              <li><a class="dropdown-item" href="../quora/login/logout.php">Logout</a></li>
                                            </ul>
                                          </div>';
                                      }
                                ?>
                                
                                </div>
                            </div>
                </nav>
       </div>
</div>