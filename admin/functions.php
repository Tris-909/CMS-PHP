<?php 
    function checkQueryError($query) {
        $connection = mysqli_connect('localhost', 'root', 'root', 'cms', 3307);
        if (!$query) {
            die ("QUERY FAILED .". mysqli_error($connection));
        }
    }

    function escape($string) {
        global $connection;
        return mysqli_real_escape_string($connection, trim($string));
    }
?>