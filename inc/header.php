
<!DOCTYPE html>
<html lang="zxx" class="no-js">
  <head>
    <!-- Mobile Specific Meta -->
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/fav.png" />
    <!-- Author Meta -->
    <meta name="author" content="CodePixar" />
    <!-- Meta Description -->
    <meta name="description" content="" />
    <!-- Meta Keyword -->
    <meta name="keywords" content="" />
    <!-- meta character set -->
    <meta charset="UTF-8" />
    <!-- Site Title -->
    <title>Revive</title>

    <link
      href="https://fonts.googleapis.com/css?family=Open+Sans:400,600|Playfair+Display:700,700i"
      rel="stylesheet"
    />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!--
			CSS
			============================================= -->
    <link rel="stylesheet" href="css/linearicons.css" />
    <link rel="stylesheet" href="css/font-awesome.min.css" />
    <link rel="stylesheet" href="css/magnific-popup.css" />
    <link rel="stylesheet" href="css/nice-select.css" />
    <link rel="stylesheet" href="css/owl.carousel.css" />
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/bootstrap-datepicker.css" />
    <link rel="stylesheet" href="css/themify-icons.css" />
    <link rel="stylesheet" href="css/main.css" />
  </head>

  <body>
    <!--================ Start Header Area =================-->
      <div class="container">
        <div class="header-wrap">
          <div
            class="header-top d-flex justify-content-between align-items-lg-center navbar-expand-lg"
          >
            <div class="col menu-left">
              <a class="active" href="index.php">Home</a>
              <a href="category.php">Category</a>
              <a href="archive.php">Archive</a>
            </div>
            <div class="col-5 text-lg-center mt-2 mt-lg-0">
              <span class="logo-outer">
                <span class="logo-inner">
                  <a href="index.php"
                    ><img class="mx-auto" src="img/logo.png" alt=""
                  /></a>
                </span>
              </span>
            </div>
            <nav class="col navbar navbar-expand-lg justify-content-end">
              <!-- Toggler/collapsibe Button -->
              <button
                class="navbar-toggler"
                type="button"
                data-toggle="collapse"
                data-target="#collapsibleNavbar"
              >
                <span class="lnr lnr-menu"></span>
              </button>

              <!-- Navbar links -->
              <div
                class="collapse navbar-collapse menu-right"
                id="collapsibleNavbar"
              >
                <ul class="navbar-nav justify-content-center w-100">
                  
                  <li class="nav-item hide-lg">
                    <a class="nav-link" href="index.php">Home</a>
                  </li>
                  <li class="nav-item hide-lg">
                    <a class="nav-link" href="category.php">Category</a>
                  </li>
                  <!-- Dropdown -->
                  <!-- <li class="nav-item dropdown">
                    <a
                      class="nav-link dropdown-toggle"
                      href="#"
                      id="navbardrop"
                      data-toggle="dropdown"
                    >
                      Pages
                    </a>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="elements.php">Elements</a>
                    </div>
                  </li> -->
                  <!-- <li class="nav-item">
                    <a class="nav-link" href="elements.php">Elements</a>
                  </li> -->
                  <?php
                  if(Auth::isLoggedIn()){
                    $user = $_SESSION['user'];
                    $roles = $user->role;
                    if(in_array('USER', $roles)){
  
                      echo '<li class="nav-item">' 
                      .'<a class="nav-link" href="./textEditor/index.php">Viết bài</a>'.
                      '</li>';
                    }
                    if(in_array('ADMIN', $roles)){
                      echo '<li class="nav-item">' 
                      .'<a class="nav-link" href="./admin/index.php">Dashboard</a>'.
                      '</li>';
                    }
                  }
                 
                  ?>
                  
                  <li class="nav-item">
                    <a class="nav-link" href="blog-single.php">Blog Detail</a>
                  </li>
                  <!-- <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact</a>
                  </li> -->
                  <?php
                  if(Auth::isLoggedIn()){
                    echo '<li class="nav-item">'
                        .' <a class="nav-link" href="logout.php">Logout</a>'.
                    '</li>';
                  } else {
                      echo '<li class="nav-item">'
                          .' <a class="nav-link" href="login.php">Login</a>'.
                      '</li>';
                  }
                
                  
                  ?>
                  
                </ul>
              </div>
            </nav>
          </div>
        </div>
      </div>
    </header>
    <!--================ End Header Area =================-->