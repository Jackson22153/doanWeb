<?php 
    require '../inc/init.php';

    Auth::requireLogin();
    $user = $_SESSION['user'];
    $roles = $user->role;
    if(in_array('ADMIN', $roles)){
        $conn = require '../inc/db.php';
        $userID = $user->id;

        $categories = Category::getAllCategories($conn);

        $postHref = 'posts.php';
        $postspageable = Post::getAllPostsByAllStates(0, $conn);
        $posts = $postspageable->content;
    }else {
        header("Location: ../index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin dashboard</title>

    <link
      href="https://fonts.googleapis.com/css?family=Open+Sans:400,600|Playfair+Display:700,700i"
      rel="stylesheet"
    />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!--============================================= -->
    <link rel="stylesheet" href="../css/linearicons.css" />
    <link rel="stylesheet" href="../css/font-awesome.min.css" />
    <link rel="stylesheet" href="../css/magnific-popup.css" />
    <link rel="stylesheet" href="../css/nice-select.css" />
    <link rel="stylesheet" href="../css/owl.carousel.css" />
    <link rel="stylesheet" href="../css/bootstrap.css" />
    <link rel="stylesheet" href="../css/bootstrap-datepicker.css" />
    <link rel="stylesheet" href="../css/themify-icons.css" />
    <link rel="stylesheet" href="../css/main.css" />
    <link rel="stylesheet" href="../css/userDashboard.css"/>
</head>
<body>
    <nav class="p-4 d-flex justify-content-center">
        <a href="../index.php"><img src="../img/logo.png" alt="logo"></a>
    </nav>
    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row flex-column align-content-center">
                <div class="col col-md-9 col-lg-7 col-xl-5 mb-3">
                    <div class="card" style="border-radius: 15px;">
                        <div class="card-body p-4">
                            <div class="d-flex text-black">
                                <div class="flex-shrink-0">
                                    <!-- <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-profiles/avatar-1.webp"
                                    alt="Generic placeholder image" class="img-fluid"
                                    style="width: 180px; border-radius: 10px;"> -->
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="mb-1"><?=$user->username?></h5>
                                    <div class="d-flex justify-content-start rounded-3 p-2 mb-2"
                                        style="background-color: #efefef;">
                                    </div>
                                    <div class="d-flex pt-1">
                                        <!-- <button type="button" class="btn btn-outline-primary me-1 flex-grow-1">Chat</button>
                                        <button type="button" class="btn btn-primary flex-grow-1">Follow</button> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-flex flex-column align-content-center">
                <div class="col-8">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <div class="d-flex text-black">
                                <a href="categories">Categories <span class="ti-arrow-right"></span></a>    
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex text-black">
                                <a href="posts">Posts <span class="ti-arrow-right"></span></a>    
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex text-black">
                                <a href="configuration">Configuration input <span class="ti-arrow-right"></span></a>    
                            </div>
                        </li>
                        <li class="list-group-item diabled">
                            <div class="d-flex text-black">
                                <a href="create-account/index.php">Create an account <span class="ti-arrow-right"></span></a>    
                            </div>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </section>
</body>
</html>