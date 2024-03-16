<?php
    require '../../inc/init.php';

    Auth::requireLogin();
    $user = $_SESSION['user'];
    $roles = $user->role;
    if(in_array('ADMIN', $roles)){
        $conn = require '../../inc/db.php';

        if(isset($_GET['page']) && !empty($_GET['page'])){
            $page = intval($_GET['page']);
        }else $page = 0;

        $postHref = 'postEditor.php';

        if(isset($_GET['search']) && !empty($_GET['search'])){
            $searchParam = $_GET['search'];
            $postsPageable = Post::searchAllPosts($searchParam, $page, $conn);
        }else{
            $postsPageable = Post::getAllPostsByAllStates($page, $conn);
        }


        $posts = $postsPageable->content;
        $totalPages = $postsPageable->totalPages;
    }else {
        header("Location: ../../index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts</title>

    <link
      href="https://fonts.googleapis.com/css?family=Open+Sans:400,600|Playfair+Display:700,700i"
      rel="stylesheet"
    />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!--============================================= -->
    <link rel="stylesheet" href="../../css/linearicons.css" />
    <link rel="stylesheet" href="../../css/font-awesome.min.css" />
    <link rel="stylesheet" href="../../css/magnific-popup.css" />
    <link rel="stylesheet" href="../../css/nice-select.css" />
    <link rel="stylesheet" href="../../css/owl.carousel.css" />
    <link rel="stylesheet" href="../../css/bootstrap.css" />
    <link rel="stylesheet" href="../../css/bootstrap-datepicker.css" />
    <link rel="stylesheet" href="../../css/themify-icons.css" />
    <link rel="stylesheet" href="../../css/main.css" />
    <link rel="stylesheet" href="../../css/userDashboard.css"/>
</head>
<body>
    <nav class="p-4 d-flex justify-content-center">
        
        <a href="../../index.php"><img src="../../img/logo.png" alt="logo"></a>
    </nav>
    <div class="container my-4">
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    <!-- blog card left -->
                    <div class="col-lg-6 col-md-6">
                    <?php
                        $start = 0;$end= (count($posts)+1)/2;
                        $postsHalfTop = array_slice($posts, $start, $end);
                        foreach($postsHalfTop as $post){
                        require '../../inc/postCard.php';
                        }
                    ?>
                    </div>
                    <!-- blog card right -->
                    <div class="col-lg-6 col-md-6">
                    <?php 
                        $start = (count($posts)+1)/2;$end= count($posts);
                        $postsHalfTop = array_slice($posts, $start, $end);
                        foreach($postsHalfTop as $post){
                        require '../../inc/postCard.php';
                        }
                    ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <?php require '../../inc/pagination.php';?>
                    </div>
                </div>
            </div>

            <!-- Start Blog Post Siddebar -->
            <div class="col-lg-4 sidebar-widgets">
                <div class="widget-wrap">
                    <!-- search -->
                    <div class="single-sidebar-widget search-widget">
                        <h4 class="category-title">Search</h4>
                        <form class="search-form mt-20" action="index.php">
                            <search-dropdown search-path='search.php' des-path=<?=$postHref?>>
                        </form>
                    </div>

                </div>
            </div>
            <!-- End Blog Post Siddebar -->
        </div>
    </div>
</body>
<script src="../../js/searchDropdown.js"></script>
<script src="../../js/vendor/jquery-2.2.4.min.js"></script>
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
      integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
      crossorigin="anonymous"
    ></script>
    <script src="../../js/vendor/bootstrap.min.js"></script>
    <script src="../../js/owl.carousel.min.js"></script>
    <script src="../../js/jquery.sticky.js"></script>
    <script src="../../js/jquery.tabs.min.js"></script>
    <script src="../../js/parallax.min.js"></script>
    <script src="../../js/jquery.nice-select.min.js"></script>
    <script src="../../js/jquery.ajaxchimp.min.js"></script>
    <script src="../../js/jquery.magnific-popup.min.js"></script>
    <script
      type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhOdIF3Y9382fqJYt5I_sswSrEw5eihAA"
    ></script>
    <script src="../../js/bootstrap-datepicker.js"></script>
    <script src="../../js/main.js"></script>
</html>