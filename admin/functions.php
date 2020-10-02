<?php 
    function checkQueryError($query) {
        $connection = mysqli_connect('localhost', 'root', 'root', 'cms', 3307);
        if (!$query) {
            die ("QUERY FAILED .". mysqli_error($connection));
        }
    }
?>