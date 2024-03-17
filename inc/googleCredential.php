<?php
    // google credential's path
    $googleCredentialPath = 'credential/google-credential.json';
    // get google ingo
    $googleCredentialString = file_get_contents($googleCredentialPath);
    $googleCredential = json_decode($googleCredentialString);
    // $webCredential = $googleCredential->web;
    return $googleCredential;
?>