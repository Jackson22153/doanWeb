<?php
    require "inc/init.php";
    // Connect to database
    $conn = require "inc/db.php";
    
    $githubCredential = require "inc/githubCredential.php";
    // Update the following variables
    $client_id = $githubCredential->client_id;
    $client_secret = $githubCredential->client_secret;
    $authorization_uri = 'https://github.com/login/oauth/authorize';
    $token_uri = "https://github.com/login/oauth/access_token";
    $redirect_uri = REDIRECT_URI_GITHUB;
    $apiUrl = 'https://api.github.com/user';


    if (isset($_GET['code']) && !empty($_GET['code'])) {
        // Execute cURL request to retrieve the access token
        $params = [
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'redirect_uri' => $redirect_uri,
            'code' => $_GET['code'],
        ];
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $token_uri);
        // curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);
        // $response = curl_exec($ch);
        // curl_close($ch);
        // $response = json_decode($response, true);
        

        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n". 
                            "Accept: application/json",
                'method' => 'POST',
                'content' => http_build_query($params),
            ],
        ];
        $context = stream_context_create($options);
        $result = file_get_contents($token_uri, false, $context);
        $response = json_decode($result, true);
        $accessToken = $response['access_token'];
        if (isset($response['access_token']) && !empty($response['access_token'])) {
            // Make sure access token is valid
            // Execute cURL request to retrieve the user info associated with the Facebook account
            // $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, $apiUrl);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($ch, CURLOPT_HTTPHEADER, [
            //     'Authorization: Bearer ' . $response["access_token"],
            //     "User-Agent: webblog-php"
            // ]);

            // $response = curl_exec($ch);
            // curl_close($ch);

            $options = [
                'http' => [
                    'header' => "Content-type: application/x-www-form-urlencoded\r\n". 
                                "Authorization: Bearer ".$accessToken."\r\n".
                                "User-Agent: webblog-php",
                    'method' => 'GET',
                ],
            ];
            $context = stream_context_create($options);
            $result = file_get_contents($apiUrl, false, $context);
            $response = $result;


            $profile = json_decode($response, true);
            //     // Make sure the profile data exists
            if (isset($profile['email']) || isset($profile['login'])) {
                $username = $profile["email"] ?? $profile['login'];
                // Check if the account exists in the database
                $user = User::getUserByUsername($username, $conn);
                // If the user does not exist in the database, insert the user into the database
                if (!$user) {
                    $password = rand(1000000000, 100000000000000000);
                    $newUser = new User($username, $password);
                    if($newUser->addUser($conn)){
                        $id = $conn->lastInsertId(); 
                        //add UserRole
                        $fetchedUser = User::getUserByUsername($username, $conn);
                        // $user = new User($profile['email'], $password);  
                        $role = Role::getRole("USER", $conn); 
                        $roleID = $role->id;
                        $UserRole = new UserRole($fetchedUser->id, $roleID);
                        $UserRole->addUserRole($conn);
                    }else {
                        exit('Cannot Add User!');
                    }
                } else {
                    $id = $user->id;
                }
                // Authenticate the account
                Auth::login($username, $conn);
                $_SESSION['github_loggedin'] = TRUE;
                $_SESSION['github_id'] = $id;
                // $_SESSION['facebook_email'] = $profile['email'];
                // $_SESSION['facebook_name'] = $profile['name'];
                // $_SESSION['facebook_picture'] = $profile['picture']['data']['url'];
                
                // Redirect to profile page
                header('Location: index.php');
                exit;
            } else {
                exit('Could not retrieve profile information! Please try again later!');
            }
        }else {
            exit('Invalid access token! Please try again later!');
        }
    } else {
        // Define params and redirect to OAuth page
        $params = [
            'client_id' => $client_id,
            'redirect_uri' => $redirect_uri,
            'response_type' => 'code',
            'scope' => 'email'
        ];
        header("Location: $authorization_uri?" . http_build_query($params));
        exit;
    }
?>