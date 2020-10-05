<?php 
    // Make a connection between PHP and MySQL database
    $host = getenv('DB_HOST');
    if (empty($host)) {
        $host = 'localhost';
    }

    $username = getenv('DB_USERNAME');
    if (empty($username)) {
        $username = 'root';
    }

    $password = getenv('DB_PASSWORD');
    if (empty($password)) {
        $password = 'root';
    }

    $databaseName = getenv('DB_DATABASE');
    if (empty($databaseName)) {
        $databaseName = 'cms';
    }

    $port = getenv('PORT');
    if (empty($port)) {
        $port = 3307;
    }

    $connection = mysqli_connect($host, $username, $password, $databaseName, $port);

    if (!$connection) {
        echo $host;
        echo $username;
        echo $password;
        echo $databaseName;
        echo $port;

        echo "We are NOT connected";
    }

?>