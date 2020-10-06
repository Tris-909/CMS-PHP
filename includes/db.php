<?php 
    $connection = mysqli_connect('localhost', 'root', 'root', 'cms', 3307);
    // $connection = mysqli_connect('remotemysql.com', 'OTM2AB53Xq', '7pZPhm9mlw', 'OTM2AB53Xq', 3306);

    if (!$connection) {
        echo "We are NOT connected";
    }

    // git add . 
    // git commit -m "" 
    // git push -u
    // git push heroku master 
    // to make changes
?>