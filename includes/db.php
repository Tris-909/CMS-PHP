<?php 
    // Make a connection between PHP and MySQL database
    $connection = mysqli_connect('localhost', 'root', 'root', 'cms', 3307);

    if (!$connection) {
        echo "We are NOT connected";
    }

?>