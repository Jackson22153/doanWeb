<?php
    // github credential's path
    $githubCredentialPath = 'credential/github-credential.json';
    // get github ingo
    $githubCredentialString = file_get_contents($githubCredentialPath);
    $githubCredential = json_decode($githubCredentialString);
    // $webCredential = $githubCredential->web;
    return $githubCredential;
?>