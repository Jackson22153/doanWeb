<?php 
	require './inc/init.php';

	$requestParam = $_GET['p'];
	$conn = require './inc/db.php';
	$state = State::getPublicState($conn);
	$postDetail = PostDetail::getPostDetail($requestParam, $state->id, $conn);
	$user = User::getUser($conn, $postDetail->userID);
    $username = $user->username;
	$categories = Category::getAllCategories($conn);

	require "inc/header.php"; 
?>
    <!--================ Start banner Area =================-->
    <section class="banner-area relative">
        <div class="overlay overlay-bg"></div>
      <div class="banner-content text-center">
        <h1>Blog Details</h1>
        <p>Elementum libero hac leo integer. Risus hac parturient feugiat litora <br /> cursus hendrerit bibendum per </p>
      </div>
    </section>
    <!--================ End banner Area =================-->
        
        <!--================Blog Area =================-->
        <section class="blog_area section-gap single-post-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
       					<div class="main_blog_details">
       						<!-- <img class="img-fluid" src=<?=$postDetail->img?> alt=""> -->
       						<!-- <a href="#"><h4><?=$postDetail->title?></h4></a> -->
       						<div class="user_details">
       							<div class="float-left">
									<?php foreach($postDetail->category as $category):?>
       									<a href="category.php?c=<?=$category?>"><?=$category?></a>
									<?php endforeach;?>
       							</div>
								<!-- user -->
       							<div class="float-right mt-sm-0 mt-3">
       								<div class="media">
       									<div class="media-body">
       										<h5><?=$username?></h5>
       										<p><?=$postDetail->date?></p>
       									</div>
       									<!-- <div class="d-flex">
       										<img src="img/blog/user-img.jpg" alt="">
       									</div> -->
       								</div>
       							</div>
       						</div>
							
							<!-- content -->
							<div class="blog-details-content">
								<?php
									echo $postDetail->content;
								?>
							</div>
       					</div>

       					<div class="navigation-area">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-12 nav-left flex-row d-flex justify-content-start align-items-center">
                                    <!-- <div class="thumb">
                                        <a href="#"><img class="img-fluid" src="img/blog/prev.jpg" alt=""></a>
                                    </div>
                                    <div class="arrow">
                                        <a href="#"><span class="lnr text-white lnr-arrow-left"></span></a>
                                    </div>
                                    <div class="detials">
                                        <p>Prev Post</p>
                                        <a href="#"><h4>A Discount Toner</h4></a>
                                    </div> -->
                                </div>
                                <div class="col-lg-6 col-md-6 col-12 nav-right flex-row d-flex justify-content-end align-items-center">
                                    <!-- <div class="detials">
                                        <p>Next Post</p>
                                        <a href="#"><h4>Cartridge Is Better</h4></a>
                                    </div>
                                    <div class="arrow">
                                        <a href="#"><span class="lnr text-white lnr-arrow-right"></span></a>
                                    </div>
                                    <div class="thumb">
                                        <a href="#"><img class="img-fluid" src="img/blog/next.jpg" alt=""></a>
                                    </div>										 -->
                                </div>									
                            </div>
                        </div>
                        <!-- <div class="comments-area">
                            <h4>05 Comments</h4>
                            <div class="comment-list">
                                <div class="single-comment justify-content-between d-flex">
                                    <div class="user justify-content-between d-flex">
                                        <div class="thumb">
                                            <img src="img/blog/c1.jpg" alt="">
                                        </div>
                                        <div class="desc">
                                            <h5><a href="#">Emilly Blunt</a></h5>
                                            <p class="date">December 4, 2017 at 3:12 pm </p>
                                            <p class="comment">
                                                Never say goodbye till the end comes!
                                            </p>
                                        </div>
                                    </div>
                                    <div class="reply-btn">
                                           <a href="" class="btn-reply text-uppercase">reply</a> 
                                    </div>
                                </div>
                            </div>	
                            <div class="comment-list left-padding">
                                <div class="single-comment justify-content-between d-flex">
                                    <div class="user justify-content-between d-flex">
                                        <div class="thumb">
                                            <img src="img/blog/c2.jpg" alt="">
                                        </div>
                                        <div class="desc">
                                            <h5><a href="#">Elsie Cunningham</a></h5>
                                            <p class="date">December 4, 2017 at 3:12 pm </p>
                                            <p class="comment">
                                                Never say goodbye till the end comes!
                                            </p>
                                        </div>
                                    </div>
                                    <div class="reply-btn">
                                           <a href="" class="btn-reply text-uppercase">reply</a> 
                                    </div>
                                </div>
                            </div>	
                            <div class="comment-list left-padding">
                                <div class="single-comment justify-content-between d-flex">
                                    <div class="user justify-content-between d-flex">
                                        <div class="thumb">
                                            <img src="img/blog/c3.jpg" alt="">
                                        </div>
                                        <div class="desc">
                                            <h5><a href="#">Annie Stephens</a></h5>
                                            <p class="date">December 4, 2017 at 3:12 pm </p>
                                            <p class="comment">
                                                Never say goodbye till the end comes!
                                            </p>
                                        </div>
                                    </div>
                                    <div class="reply-btn">
                                           <a href="" class="btn-reply text-uppercase">reply</a> 
                                    </div>
                                </div>
                            </div>	
                            <div class="comment-list">
                                <div class="single-comment justify-content-between d-flex">
                                    <div class="user justify-content-between d-flex">
                                        <div class="thumb">
                                            <img src="img/blog/c4.jpg" alt="">
                                        </div>
                                        <div class="desc">
                                            <h5><a href="#">Maria Luna</a></h5>
                                            <p class="date">December 4, 2017 at 3:12 pm </p>
                                            <p class="comment">
                                                Never say goodbye till the end comes!
                                            </p>
                                        </div>
                                    </div>
                                    <div class="reply-btn">
                                           <a href="" class="btn-reply text-uppercase">reply</a> 
                                    </div>
                                </div>
                            </div>	
                            <div class="comment-list">
                                <div class="single-comment justify-content-between d-flex">
                                    <div class="user justify-content-between d-flex">
                                        <div class="thumb">
                                            <img src="img/blog/c5.jpg" alt="">
                                        </div>
                                        <div class="desc">
                                            <h5><a href="#">Ina Hayes</a></h5>
                                            <p class="date">December 4, 2017 at 3:12 pm </p>
                                            <p class="comment">
                                                Never say goodbye till the end comes!
                                            </p>
                                        </div>
                                    </div>
                                    <div class="reply-btn">
                                           <a href="" class="btn-reply text-uppercase">reply</a> 
                                    </div>
                                </div>
                            </div>	                                             				
                        </div>
                        <div class="comment-form">
                            <h4>Leave a Reply</h4>
                            <form>
                                <div class="form-group form-inline">
                                  <div class="form-group col-lg-6 col-md-6 name">
                                    <input type="text" class="form-control" id="name" placeholder="Enter Name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Name'">
                                  </div>
                                  <div class="form-group col-lg-6 col-md-6 email">
                                    <input type="email" class="form-control" id="email" placeholder="Enter email address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email address'">
                                  </div>										
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="subject" placeholder="Subject" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Subject'">
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control mb-10" rows="5" name="message" placeholder="Messege" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Messege'" required=""></textarea>
                                </div>
                                <a href="#" class="primary-btn submit_btn">Post Comment</a>	
                            </form>
                        </div> -->
					</div>
					<!-- sidebar -->
                    <?php require './inc/postSideBar.php';?>
                </div>
            </div>
        </section>
        <!--================Blog Area =================-->
        
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