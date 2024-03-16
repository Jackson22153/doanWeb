<?php 
  require "./inc/init.php";
  require "./classes/auth.php";
  
  $conn = require "./inc/db.php";
  $categories = Category::getAllCategories($conn);
  $searchDes = 'archive.php';

  if(isset($_GET['page']) && !empty($_GET['page'])){
    $page = intval($_GET['page']);
  }else $page = 0;

  if(isset($_GET['c']) && !empty($_GET['c'])){
    $requestParam = $_GET['c'];
    $state = State::getPublicState($conn);
    $postsPageable = PostInfo::getPostsByCategory($requestParam, $state->id, $page, $conn);
  
    $posts = $postsPageable->content;
    $totalPages = $postsPageable->totalPages;
  }else{
    // $repo;
    // $postPerCategory;
    // $posts = array();
    // $postsArr = PostInfo::getPostsByCategories($conn);
    // foreach($postsArr as $post){
    //   if(count($repo)>0){
    //     if($post->category != $repo[count($repo)-1]->category){
          
    //     }else{
    //       $repo[count($repo)-1][] = $post;
    //     }
    //   }
    // }
  }
  

?>
<?php require "inc/header.php"; ?>

    <!--================ Start banner Area =================-->
    <section class="banner-area relative">
        <div class="overlay overlay-bg"></div>
      <div class="banner-content text-center">
        <h1>Category Page</h1>
        <p>Elementum libero hac leo integer. Risus hac parturient feugiat litora <br /> cursus hendrerit bibendum per </p>
      </div>
    </section>
    <!--================ End banner Area =================-->

    <!--================ Start Blog Post Area =================-->
    <section class="blog-post-area section-gap relative">
      <div class="container">
        <div class="row">
            <?php if(isset($_GET['c']) && !empty($_GET['c'])):?>
            <div class="col-lg-8">
              <div class="row">
                <!-- blog card left -->
                <div class="col-lg-6 col-md-6">
                  <?php
                    $start = 0;$end= (count($posts)+1)/2;
                    $postsHalfTop = array_slice($posts, $start, $end);
                    foreach($postsHalfTop as $post){
                      require './inc/postCard.php';
                    }
                  ?>
                </div>
                <!-- blog card right -->
                <div class="col-lg-6 col-md-6">
                  <?php 
                    $start = (count($posts)+1)/2;$end= count($posts);
                    $postsHalfTop = array_slice($posts, $start, $end);
                    foreach($postsHalfTop as $post){
                      require './inc/postCard.php';
                    }
                  ?>
                </div>
              </div>
  
              <div class="row">
                <div class="col-lg-12">
                    <?php require './inc/pagination.php';?>
                </div>
              </div>
            </div>
            <?php else:?>
              <div class="col-lg-8">
                
                <div class="row">
                  <div class="col-lg-6 col-md-6">
                    
                  </div>
                </div>
              </div>
            <?php endif;?>

            <!-- Start Blog Post Siddebar -->
            <?php require './inc/postSideBar.php';?>
            <!-- End Blog Post Siddebar -->
          </div>


      </div>
    </section>
    <!--================ End Blog Post Area =================-->

    <?php require "inc/footer.php"; ?>
    <script src="js/vendor/jquery-2.2.4.min.js"></script>
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
      integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
      crossorigin="anonymous"
    ></script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.sticky.js"></script>
    <script src="js/jquery.tabs.min.js"></script>
    <script src="js/parallax.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script
      type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhOdIF3Y9382fqJYt5I_sswSrEw5eihAA"
    ></script>
    <script src="js/bootstrap-datepicker.js"></script>
    <script src="js/main.js"></script>
    <script src="js/searchDropdown.js"></script>
  </body>
</html>
