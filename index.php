<?php  
  require 'inc/init.php';
  $conn = require "./inc/db.php";
  $categories = Category::getAllCategories($conn);
  $state = State::getPublicState($conn);
  $posts = Post::getPostsRandomly($state->id, $conn);
  $searchDes = 'archive.php';
?>
<?php require "inc/header.php"; ?>

    <!--================ Start banner Area =================-->
    <section class="home-banner-area relative">
      <div class="container-fluid">
        <div class="row">
          <div class="owl-carousel home-banner-owl">
            <div class="banner-img">
              <img class="img-fluid" src="img/banner/b1.jpg" alt="" />
              <div class="text-wrapper">
                <a href="#" class="d-flex">
                  <h1>
                    Make the world a better place <br />
                    with camera
                  </h1>
                </a>
              </div>
            </div>
            <div class="banner-img">
              <img class="img-fluid" src="img/banner/b2.jpg" alt="" />
              <div class="text-wrapper">
                <a href="#" class="d-flex">
                  <h1>
                    Make the world a better place <br />
                    with camera
                  </h1>
                </a>
              </div>
            </div>
            <div class="banner-img">
              <img class="img-fluid" src="img/banner/b1.jpg" alt="" />
              <div class="text-wrapper">
                <a href="#" class="d-flex">
                  <h1>
                    Make the world a better place <br />
                    with camera
                  </h1>
                </a>
              </div>
            </div>
            <div class="banner-img">
              <img class="img-fluid" src="img/banner/b2.jpg" alt="" />
              <div class="text-wrapper">
                <a href="#" class="d-flex">
                  <h1>
                    Make the world a better place <br />
                    with camera
                  </h1>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="social-icons">
        <ul>
          <li>
            <a href="index.php"><i class="fa fa-facebook"></i></a>
          </li>
          <li>
            <a href="index.php"><i class="fa fa-twitter"></i></a>
          </li>
          <li>
            <a href="index.php"><i class="fa fa-pinterest"></i></a>
          </li>
          <li class="diffrent">sharre now</li>
        </ul>
      </div>
    </section>
    <!--================ End banner Area =================-->

    <!--================ Start Blog Post Area =================-->
    <section class="blog-post-area section-gap relative">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">
            <div class="row">
              <div class="col-lg-6 col-md-6">
                <p class="h3 mb-2">Recommended Posts</p>
              </div>
            </div>
            <!-- blog post -->
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
            <!-- pagination -->
            <div class="row">
              <div class="col-lg-12 d-flex justify-content-center">
                <a class="btn btn-secondary" href="archive.php">More posts</a>
              </div>
            </div>
          </div>

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
    <script src="js/searchDropdown.js"></script>
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
  </body>
</html>