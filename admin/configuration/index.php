<?php
    require '../../inc/init.php';
    Auth::requireLogin();
    $user = $_SESSION['user'];
    $roles = $user->role;
    if(in_array('ADMIN', $roles)){

    }else {
        header("Location: ../../index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuration</title>

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
    <div class="container my-3 bg-light p-4">
        <form class="rounded " action="updateconfig.php" method="post" enctype="multipart/form-data">
            <div>
                <div class="form-group">
                    <label for="db-host">Database host</label>
                    <input type="text" name="db-host" class="form-control" value=<?=DB_HOST?>
                        placeholder="Enter database's host">
                </div>
                <div class="form-group">
                    <label for="db-name">Database name</label>
                    <input type="text" name="db-name" class="form-control" value=<?=DB_NAME?>
                        placeholder="Database's name">
                </div>
            </div>
            <hr>
            <div>
                <div class="form-group">
                    <label for="db-username">Database username</label>
                    <input type="text" name="db-username" class="form-control" value=<?=DB_USER?>
                        placeholder="Username">
                </div>
                <div class="form-group">
                    <label for="db-password">Database password</label>
                    <input type="password" name="db-password" class="form-control" value=<?=DB_PASS?>
                        placeholder="Password">
                </div>
            </div>
            <hr>
            <div>
                <div class="form-group">
                    <label for="pagesize">Page&nbsp;size</label>
                    <input type="number" name="pagesize" class="form-control" value=<?=PAGE_SIZE?>
                        placeholder="Number of items displayed on a page">
                </div>

            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

</body>
</html>