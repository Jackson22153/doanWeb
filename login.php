<?php
    require "inc/init.php";
    ini_set('display_errors', 'off');
    if(Auth::isLoggedIn()){
        Header("Location: index.php");
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $conn = require "inc/db.php";
        
        $email = $_POST["email"];
        $password = $_POST["password"];

        try{
            if (User::authenticate($conn, $email, $password)) {
                
                Auth::login($email, $conn);
                Header('Location: index.php');
            } 
            else {
                Dialog::show("Incorrect user or password");
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
            // Có thể gọi trang xử lí lỗi
            // Header('Location: error.php');
        }
    }
    
?>

<!DOCTYPE html>
<html lang="en">
    <!-- Head -->
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Login</title>
        <!-- Reset CSS -->
        <link rel="stylesheet" href="./css/reset.css" />


        <!-- Styles -->
        <link rel="stylesheet" href="./css/styles.css" />
    </head>

    <!-- Body -->
    <body>
        <nav>
            <a href="index.php"><img src="./img/logo.png" alt="logo"></a>
        </nav>
        <section class="container forms">
            <div class="form login">
                <div class="form-content">
                    <header>Login</header>
                    <form action="login.php" method="post">
                        <div class="field input-field">
                            <input type="Email" placeholder="Email" name="email" class="input" required>
                        </div>
                        <div class="field input-field">
                            <input type="password" placeholder="Password" name="password" class="password" required>
                            <i class='bx bx-hide eye-icon'></i>
                        </div>
                        
                        <div class="field button-field">
                            <button type="submit" value="Login" name="login">Login</button>
                        </div>
                    </form>
                    <div class="form-link">
                        <span>Don't have an account? <a href="signup.php" class="link signup-link">Signup</a></span>
                    </div>
                </div>
                <div class="line"></div>
                <div class="media-options">
                    <a href="google-oauth.php" class="google-login-btn">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 488 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z"/></svg>
                        </span>
                        <div class="desc"><p>Login with Google</p></div>
                    </a>
                </div>
                <div class="media-options">
                    <a href="facebook-oauth.php" class="facebook-login-btn">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 320 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"/></svg>
                        </span>
                        <div class="desc"><p>Login with Facebook</p></div>
                    </a>
                </div>
            </div>
            
        </section>
    </body>
</html>