<?php
    require '../inc/init.php';

    Auth::requireLogin();

    $user = $_SESSION['user'];
    $roles = $user->role;
    if(in_array('USER', $roles)){
        $conn = require '../inc/db.php';
        $postImg = $_POST['postImg'];
        $postContent = $_POST['postContent'];
        $postTitle = $_POST['postTitle'];
        $stateID = $_POST['state'];
        $categories = $_POST['categories'];
        $userID = $user->id;
        $categoriesArray = explode(',', $categories);
        date_default_timezone_set('Asia/Ho_Chi_Minh'); // Set the timezone
        $currentDate = date('Y-m-d H:i:s'); // Output the current date and time in the 'Y-m-d H:i:s' format  

        // save post infomation
        $categoryIDs = array();
        $fetchedCategories = Category::getCategories($categoriesArray, $conn);
        foreach($fetchedCategories as $fetchedCategory){
            $categoryIDs[] = $fetchedCategory->id;
        }

        $categoryIDsStr = array_map('strval', $categoryIDs);
        $postDetail = new PostDetail($postTitle, $postContent, $categoryIDsStr, $stateID, $userID, $currentDate, $postImg);
        $state = $postDetail->addPostDetail($conn);
    }else {
        header("Location: ../index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post saving</title>

    <link rel="stylesheet" href="../css/bootstrap.css" />
    <link rel="stylesheet" href="../css/bootstrap-datepicker.css" />
</head>
<body>
    <div class="vh-100 d-flex justify-content-center align-items-center">
        <div class="container">
            <div class="mb-4 text-center">
            <?php if($state):?>
                <svg xmlns="http://www.w3.org/2000/svg" class="text-success" width="75" height="75"
                    fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                    <path
                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                </svg>
            <?php else:?>
                <svg xmlns="http://www.w3.org/2000/svg" width="75" height="75" fill="red" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
                <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.15.15 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.2.2 0 0 1-.054.06.1.1 0 0 1-.066.017H1.146a.1.1 0 0 1-.066-.017.2.2 0 0 1-.054-.06.18.18 0 0 1 .002-.183L7.884 2.073a.15.15 0 0 1 .054-.057m1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767z"/>
                <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z"/>
                </svg>
            <?php endif;?>
            </div>
            <div class="text-center">
                <?php if($state):?>
                    <h1>Thank You !</h1>
                    <p>Your post has been uploaded </p>
                <?php else:?>
                    <h1>Error !</h1>
                    <p>Your post can not be uploaded </p>
                <?php endif;?>
                <a href="index.php" class="btn btn-primary">Back Home</a>
            </div>
        </div>
    </div>
</body>
</html>