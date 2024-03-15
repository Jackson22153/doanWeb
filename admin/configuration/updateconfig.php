<?php
    require '../../inc/init.php';
    Auth::requireLogin();
    $user = $_SESSION['user'];
    $roles = $user->role;
    if(in_array('ADMIN', $roles)){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get form data
            $dbHost = $_POST['db-host'];
            $dbName = $_POST['db-name'];
            $dbUsername = $_POST['db-username'];
            $dbPassword = $_POST['db-password'];
            $pagesize = $_POST['pagesize'];
            // Get other form data similarly

            $configPath = '../../config.php';
            // Update config file
            $configContent = file_get_contents($configPath);
            $configContent = preg_replace("/define\('PAGE_SIZE', \d+\);/", "define('PAGE_SIZE', $pagesize);", $configContent);
            $configContent = preg_replace("/define\('DB_HOST', '[^']+'\);/", "define('DB_HOST', '$dbHost');", $configContent);
            $configContent = preg_replace("/define\('DB_NAME', '[^']+'\);/", "define('DB_NAME', '$dbName');", $configContent);
            $configContent = preg_replace("/define\('DB_USER', '[^']+'\);/", "define('DB_USER', '$dbUsername');", $configContent);
            $configContent = preg_replace("/define\('DB_PASS', '[^']+'\);/", "define('DB_PASS', '$dbPassword');", $configContent);
            // $configFile = fopen($configPath, "w") or die("Unable to open file!");
            // get file content

            // fwrite($configFile, "<?php\n");
            // fwrite($configFile, "define('PAGE_SIZE', $pagesize);\n");
            // Write other config variables similarly
            /*fwrite($configFile, "?>");*/


            file_put_contents($configPath, $configContent);
            // fclose($configContent);

            echo "Config updated successfully!";
        }
    }
    header('Location: index.php');


?>