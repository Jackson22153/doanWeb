<?php
  require '../inc/init.php';
  Auth::requireLogin();
  $user = $_SESSION['user'];

  $roles = $user->role;

  if(in_array('USER', $roles)){
    $conn = require '../inc/db.php';
  
    $username = $user->username;
    $postHref = 'postEditor.php';
    $totalPosts = Post::getTotalPosts($user->id, $conn);
    $totalPostsPerState = Post::getTotalPostsPerState($user->id, $conn);
    $states = State::getAllStates($conn);
  
    $page = 0;
    if(isset($_GET['page']) && !empty($_GET['page'])){
      $page = intval($_GET['page']);
    }
  
    if(isset($_GET['filter']) && !empty($_GET['filter'])){
      // state filter
      $requestParam = $_GET['filter'];
      $state = State::getState($requestParam, $conn);
  
      
    }else{
      $state = State::getPublicState($conn);
      $requestParam = $state->id;
    }

    $filter = array('state'=>$requestParam);

    if(isset($_GET['search']) && !empty($_GET['search'])){
      $searchParam = $_GET['search'];
      $postsPageable = Post::searchPostsOfUser($searchParam, $state->id, $user->id, $page, $conn);
    }else{
      $postsPageable = Post::getPostsByUserID($user->id, $state->id, $page, $conn);
    }

    $posts = $postsPageable->content;
    $totalPages = $postsPageable->totalPages;
  }else {
    header("Location: ../index.php");
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User dashboard</title>

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
          <div class="row">
              <div class="col col-md-9 col-lg-7 col-xl-5">
                  <div class="card" style="border-radius: 15px;">
                  <div class="card-body p-4">
                      <div class="d-flex text-black">
                      <div class="flex-shrink-0">
                          <!-- <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-profiles/avatar-1.webp"
                          alt="Generic placeholder image" class="img-fluid"
                          style="width: 180px; border-radius: 10px;"> -->
                      </div>
                      <div class="flex-grow-1 ms-3">
                          <h5 class="mb-1"><?=$username?></h5>
                          <div class="d-flex justify-content-start rounded-3 p-2 mb-2"
                            style="background-color: #efefef;">
                              <div class="px-3">
                                <p class="small text-muted mb-1">Posts</p>
                                <p class="mb-0"><?=$totalPosts?></p>
                              </div>
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
          <div class="row">
            <!-- content -->
            <div class="col-lg-8">
              <div class="col-lg-6 col-md-6">
                <p class="h3 mb-2">Your Posts</p>
              </div>
              <div class="row">
                <!-- blog card left -->
                <div class="col-lg-6 col-md-6">
                  <?php
                    $start = 0;$end= (count($posts)+1)/2;
                    $postsHalfTop = array_slice($posts, $start, $end);
                    foreach($postsHalfTop as $post){
                      require '../inc/postCard.php';
                    }
                  ?>
                </div>
                <!-- blog card right -->
                <div class="col-lg-6 col-md-6">
                  <?php 
                    $start = (count($posts)+1)/2;$end= count($posts);
                    $postsHalfTop = array_slice($posts, $start, $end);
                    foreach($postsHalfTop as $post){
                      require '../inc/postCard.php';
                    }
                  ?>
                </div>
              </div>
  
              <div class="row">
                <div class="col-lg-12">
                    <?php require '../inc/pagination.php';?>
                </div>
              </div>
            </div>
            <!-- side bar -->
            <div class="col-lg-4 sidebar-widgets">
                <div class="widget-wrap">
                  <!-- search -->
                  <div class="single-sidebar-widget search-widget">
                      <h4 class="category-title">Search</h4>
                      <form class="search-form mt-20" action="index.php">
                        <search-dropdown search-path='search.php' search-condition=<?=json_encode($filter)?>
                          des-path=<?=$postHref?>>
                      </form>
                  </div>
                  <!-- categories -->
                  <div class="single-sidebar-widget post-category-widget">
                      <h4>State</h4>
                      <ul class="mt-20">
                        <?php foreach($states as $state):?>
                          <li class="filter-checkbox">
                            <input type="checkbox" class="state-checkbox" value="<?=$state->id?>" 
                              name="<?=$state->stateName?>" <?php if($requestParam==$state->id) echo 'checked'?>>
                            <label for="<?=$state->stateName?>"><?=$state->stateName?></label>
                          </li>
                        <?php endforeach;?>
                      </ul>
                  </div>
                </div>
            </div>
          </div>
      </div>
  </section>
</body>
<script src="../js/vendor/jquery-2.2.4.min.js"></script>
<script
  src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
  integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
  crossorigin="anonymous"
></script>
<script src="../js/searchDropdown.js"></script>
<script src="../js/vendor/bootstrap.min.js"></script>
<script src="../js/owl.carousel.min.js"></script>
<script src="../js/jquery.sticky.js"></script>
<script src="../js/jquery.tabs.min.js"></script>
<script src="../js/parallax.min.js"></script>
<script src="../js/jquery.nice-select.min.js"></script>
<script src="../js/jquery.ajaxchimp.min.js"></script>
<script src="../js/jquery.magnific-popup.min.js"></script>
<script src="../js/bootstrap-datepicker.js"></script>
<script src="../js/main.js"></script>

<script>
  let stateCheckBoxes = document.querySelectorAll('.state-checkbox');
  stateCheckBoxes.forEach(checkbox =>{
    checkbox.addEventListener('change', ()=>{
      // window.location.href=''
      if(checkbox.checked){
        var path = window.location.pathname;
        var requestSearchs = new URLSearchParams(window.location.search);
        requestSearchs.set('filter', checkbox.value)

        const url = `${path}?${requestSearchs.toString()}`;
        window.location.href= url;
      }
    })
  })

</script>

</html>