<?php
    require "inc/init.php";
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordRepeat = $_POST["repeat_password"];
        $errors = array();
        if (empty($email) OR empty($password) OR empty($passwordRepeat)) {
            array_push($errors,"All fields are required");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Email is not valid");
        }
        if (strlen($password)<8) {
            array_push($errors,"Password must be at least 8 character long");
        }
        if ($password!==$passwordRepeat) {
            array_push($errors,"Password does not match");
        }
        if (count($errors)>0) {
            foreach ($errors as  $error){
                Dialog::show($error);
            }
        }
        else{
            $conn = require "inc/db.php";
            $user = new User($email, $password);      
            try{
                if($user->addUser($conn)){
                    Dialog::show("Add User Successfully!");
                }
                else{
                    Dialog::show("Cannot Add User!");
                }
            }
            catch(PDOException $e){
                Dialog::show("Something wrong!!! Try again");
                // echo $e->getMessage();
                // Có thể gọi trang xử lí lỗi
                // Header('Location: error.php');
            }
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
<body>
    <nav>
            <a href="index.php"><img src="./img/logo.png" alt="logo"></a>
        </nav>
    <section class="container forms">
        <div class="form login">
            <div class="form-content">
                <header>Sign Up</header>
                <form action="signup.php" method="post">
                    <div class="field input-field">
                        <input type="email" placeholder="Email" name="email" class="input" required>
                    </div>
                    <div class="field input-field">
                        <input type="password" placeholder="Password" name="password" class="password"  required>
                    </div>
                    <div class="field input-field">
                        <input type="password" placeholder="Repeat Password" name="repeat_password" class="password" required>
                    </div>
                    <div class="field button-field">
                        <button type="submit" value="Sign up" name="submit">Sign Up</button>
                    </div>
                </form>
                <div class="form-link">
                    <span>Already have an account? <a href="login.php" class="link signup-link">Login</a></span>
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