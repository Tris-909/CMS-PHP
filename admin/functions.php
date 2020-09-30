<?php 
    include('/Users/USER/Desktop/CMS/CMS_TEMPLATE/includes/db.php');

    function checkQueryError($query) {
        if (!$query) {
            die ("QUERY FAILED .". mysqli_error($connection));
        }
    }
?>