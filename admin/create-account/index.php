<?php
    require '../../inc/init.php';
    Auth::requireLogin();
    $user = $_SESSION['user'];
    $roles = $user->role;
    if(in_array('ADMIN', $roles)){
        $conn = require '../../inc/db.php';
        $roles = Role::getAllRoles($conn);

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $email = $_POST['email'];
            $password = $_POST['password'];
            $passwordRepeat = $_POST["repeat_password"];
            $role = $_POST["role"];
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
                $user = new User($email, $password);      
                try{
                    if($user->addUser($conn)){
                        Dialog::show("Add User Successfully! redirect to Login...");

                        $userID = $user->getUserID($conn,$email);
                        $UserRole = new UserRole($userID, $role);
                        $UserRole->addUserRole($conn);
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




    }else {
        header("Location: ../../index.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create account</title>

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
    <div class="container">
        <nav class="p-4 d-flex justify-content-center">
            <a href="../../index.php"><img src="../../img/logo.png" alt="logo"></a>
        </nav>
        <div class="row justify-content-center">
            <form accept="index.php" class="col-lg-5 col-md-8 col-sm-10 rounded bg-light p-3" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input name="password" type="password" class="form-control" placeholder="Password">
                </div>
                <div class="form-group">
                    <label for="repeat_password">Confirm password</label>
                    <input name="repeat_password" type="password" class="form-control" placeholder="Repeat Password">
                </div>
                <div class="form-group d-flex">
                    <label for="role" class="col-2">Role</label>
                    <div class="col-10 p-0">
                        <select class="form-control" name="role">
                            <?php foreach($roles as $role):?>
                                <option value=<?=$role->id?>><?=$role->role?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <a href="../index.php" class="btn btn-light border-secondary-subtle toggle-button">Back</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>