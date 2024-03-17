<?php
require "inc/init.php";
// Connect to database
$conn = require "inc/db.php";

$googleCredential = require "inc/googleCredential.php";
// Update the following variables
$client_id = $googleCredential->client_id;
$client_secret = $googleCredential->client_secret;
$authorization_uri = 'https://accounts.google.com/o/oauth2/auth';
$token_uri = "https://accounts.google.com/o/oauth2/token";
$redirect_uri = REDIRECT_URI_GOOGLE;
$google_oauth_version = 'v3';
$apiUrl = 'https://www.googleapis.com/oauth2/' . $google_oauth_version . '/userinfo';
// If the captured code param exists and is valid
// echo userInfo($client_id, $client_secret, $authorization_uri, $token_uri, $apiUrl, $redirect_uri, $conn);
if (isset($_GET['code']) && !empty($_GET['code'])) {
    // Execute cURL request to retrieve the access token
    $params = [
        'code' => $_GET['code'],
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'redirect_uri' => $redirect_uri,
        'grant_type' => 'authorization_code'
    ];


    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $token_uri);
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
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
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
            $user = User::getUserByUsername($profile['email'], $conn);
            // If the user does not exist in the database, insert the user into the database
            if (!$user) {
                $password = rand(1000000000, 100000000000000000);
                $newuser = new User($profile['email'], $password);
                if($newuser->addUser($conn)){
                    $id = $conn->lastInsertId();       
                    //add UserRole
                    $fetchedUser = User::getUserByUsername($profile['email'], $conn);
                    // $user = new User($profile['email'], $password);  
                    $role = Role::getRole("USER", $conn); 
                    $roleID = $role->id;
                    $UserRole = new UserRole($fetchedUser->id, $roleID);
                    $UserRole->addUserRole($conn);
                } else {
                    exit('Cannot Add User!');
                }
            }else {
                $id = $user->id;
            }
            // $_SESSION['google_loggedin'] = TRUE;
            // $_SESSION['google_name'] = implode(' ', $google_name_parts);
            // $_SESSION['google_picture'] = isset($profile['picture']) ? $profile['picture'] : '';
            
            // Authenticate the account
            Auth::login($profile['email'], $conn);
            $_SESSION['google_loggedin'] = TRUE;
            $_SESSION['google_id'] = $id;
            
            // Redirect to profile page
            header('Location: index.php');
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
        'client_id' => $client_id,
        'redirect_uri' => $redirect_uri,
        'scope' => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile',
        'access_type' => 'offline',
        'prompt' => 'consent'
    ];
    header('Location: '.$authorization_uri.'?' . http_build_query($params));
    exit;
}
?>