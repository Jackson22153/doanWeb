<?php
require "inc/init.php";
// Connect to database
$conn = require "inc/db.php";

// Update the following variables
$google_oauth_client_id = '729349237408-u0looh5jgfl91sriejbsinn5rqhvmphk.apps.googleusercontent.com';
$google_oauth_client_secret = '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';
$google_oauth_redirect_uri = 'http://localhost/phpdoan/doanWeb/google-oauth.php';
$google_oauth_version = 'v3';
// If the captured code param exists and is valid
if (isset($_GET['code']) && !empty($_GET['code'])) {
    // Execute cURL request to retrieve the access token
    $params = [
        'code' => $_GET['code'],
        'client_id' => $google_oauth_client_id,
        'client_secret' => $google_oauth_client_secret,
        'redirect_uri' => $google_oauth_redirect_uri,
        'grant_type' => 'authorization_code'
    ];


    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://accounts.google.com/o/oauth2/token');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    $response = json_decode($response, true);

    // Make sure access token is valid
    if (isset($response['access_token']) && !empty($response['access_token'])) {
        // Execute cURL request to retrieve the user info associated with the Google account
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/oauth2/' . $google_oauth_version . '/userinfo');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $response['access_token']]);
        $response = curl_exec($ch);
        curl_close($ch);
        $profile = json_decode($response, true);
        // Make sure the profile data exists
        if (isset($profile['email'])) {
            $google_name_parts = [];
            $google_name_parts[] = isset($profile['given_name']) ? $profile['given_name'] : '';
            $google_name_parts[] = isset($profile['family_name']) ? $profile['family_name'] : '';
            // Check if the account exists in the database
            $stmt = $conn->prepare('SELECT * FROM users WHERE username = ?');
            $stmt->execute([ $profile['email'] ]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            // If the user does not exist in the database, insert the user into the database
            if (!$user) {
                $stmt = $conn->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
                $password = rand(1000000000, 100000000000000000);
                $stmt->execute([$profile['email'], $password ]);
                $id = $conn->lastInsertId();                
            }else {
                $id = $user['id'];
            }
            $_SESSION['google_loggedin'] = TRUE;
            $_SESSION['google_name'] = implode(' ', $google_name_parts);
            $_SESSION['google_picture'] = isset($profile['picture']) ? $profile['picture'] : '';
            //add UserRole
            $user = new User($profile['email'], $password);  
            $role = new Role("USER");
            $role->id = 2;
            $roleID = $role->id;
            $userID = $user->getUserID($conn,$profile['email']);
            $UserRole = new UserRole($userID, $roleID);
            $UserRole->addUserRole($conn);
            // Authenticate the account
            Auth::login($profile['email'], $conn);
            $_SESSION['google_loggedin'] = TRUE;
            $_SESSION['google_id'] = $id;
            
            // Redirect to profile page
            header('Location: profile.php');
            exit;
            } 
        else {
            exit('Could not retrieve profile information! Please try again later!');
        }
    } else {
        exit('Invalid access token! Please try again later!');
    }
} else {
    // Define params and redirect to Google Authentication page
    $params = [
        'response_type' => 'code',
        'client_id' => $google_oauth_client_id,
        'redirect_uri' => $google_oauth_redirect_uri,
        'scope' => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile',
        'access_type' => 'offline',
        'prompt' => 'consent'
    ];
    header('Location: https://accounts.google.com/o/oauth2/auth?' . http_build_query($params));
    exit;
}
?>