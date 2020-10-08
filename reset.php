<?php 
    if (isset($_GET['email']) && isset($_GET['token'])) {
        echo $_GET['email'];
        echo '<br>';
        echo $_GET['token'];
    }
?>