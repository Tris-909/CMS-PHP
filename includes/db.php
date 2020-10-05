<?php 
    // Make a connection between PHP and MySQL database
    $host = getenv('DB_HOST');
    if (isset($host)) {
        $host = 'localhost';
    }

    $username = getenv('DB_USERNAME');
    if (isset($username)) {
        $username = 'root';
    }

    $password = getenv('DB_PASSWORD');
    if (isset($password)) {
        $password = 'root';
    }

    $databaseName = getenv('DB_DATABASE');
    if (isset($databaseName)) {
        $databaseName = 'cms';
    }

    $port = getenv('PORT');
    if (isset($port)) {
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