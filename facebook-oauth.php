<?php
// Initialize the session
require "inc/init.php";
// Connect to database
$conn = require "inc/db.php";
// Update the following variables
$facebook_oauth_app_id = '299931266442106';
$facebook_oauth_app_secret = 'c268983557cabf79eb82274af9d55e47';
// Must be the direct URL to the facebook-oauth.php file
$facebook_oauth_redirect_uri = 'http://localhost/blog/doanWeb/facebook-oauth.php';
$facebook_oauth_version = 'v19.0';
// If the captured code param exists and is valid
if (isset($_GET['code']) && !empty($_GET['code'])) {
    // Execute cURL request to retrieve the access token
    
} else {
    // Define params and redirect to Facebook OAuth page
    $params = [
        'client_id' => $facebook_oauth_app_id,
        'redirect_uri' => $facebook_oauth_redirect_uri,
        'response_type' => 'code',
        'scope' => 'email'
    ];
    header('Location: https://www.facebook.com/dialog/oauth?' . http_build_query($params));
    exit;
}
$params = [
    'client_id' => $facebook_oauth_app_id,
    'client_secret' => $facebook_oauth_app_secret,
    'redirect_uri' => $facebook_oauth_redirect_uri,
    'code' => $_GET['code']
];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/oauth/access_token');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
$response = json_decode($response, true);
// Make sure access token is valid
// Execute cURL request to retrieve the user info associated with the Facebook account
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://graph.facebook.com/' . $facebook_oauth_version . '/me?fields=name,email,picture');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $response['access_token']]);
$response = curl_exec($ch);
curl_close($ch);
$profile = json_decode($response, true);
    // Make sure the profile data exists
if (isset($profile['email'])) {
    // Check if the account exists in the database
    $stmt = $conn->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$profile['email']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    // If the user does not exist in the database, insert the user into the database
    if (!$user) {
        $stmt = $conn->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
        $password = rand(1000000000, 100000000000000000);
        $stmt->execute([$profile['email'], $password ]);
        $id = $conn->lastInsertId(); 
    } else {
        $id = $user['id'];
    }
    //add UserRole
    $user = new User($profile['email'], $password);  
    $role = new Role("USER");
    $role->id = 2;
    $roleID = $role->id;
    $userID = $user->getUserID($conn,$profile['email']);
    $UserRole = new UserRole($userID, $roleID);
    $UserRole->addUserRole($conn);
    // Authenticate the account
    Auth::login($profile['email'],$conn);
    $_SESSION['facebook_loggedin'] = TRUE;
    $_SESSION['facebook_id'] = $id;
    $_SESSION['facebook_email'] = $profile['email'];
    $_SESSION['facebook_name'] = $profile['name'];
    $_SESSION['facebook_picture'] = $profile['picture']['data']['url'];
    
    // Redirect to profile page
    header('Location: profile.php');
    exit;
} else {
    exit('Could not retrieve profile information! Please try again later!');
}
?>
