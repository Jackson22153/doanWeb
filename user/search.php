<?php
    require '../inc/init.php';
    
    Auth::requireLogin();
    $user = $_SESSION['user'];
    
    $roles = $user->role;
    if(in_array('USER', $roles)){
        try {
            $conn = require '../inc/db.php';
            $userID = $user->id;

            $rawData = file_get_contents("php://input");
            // Decode the JSON data to PHP array
            $data = json_decode($rawData, true);

            $query = $data['query'];
            $stateID = $data['state'];

            $postsPageable = Post::searchPostsOfUser($query, $stateID, $userID, 0, $conn);
            $posts = $postsPageable->content;
            echo json_encode($posts);
        } catch (Exception $e) {
            $e->getMessage();
            $error = array("error"=> "Missing query data!");
            echo json_encode($error);
        }
        
    }else{
        header("Location: ../index.php");
    }
?>