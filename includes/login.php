<?php include "./db.php"; ?>
<?php session_start(); ?>
<?php 
    include('./db.php');

    if(isset($_POST['login'])) {
        $Account = $_POST['account'];
        $Password = $_POST['password'];

        $Account = mysqli_real_escape_string($connection, $Account);
        $Password = mysqli_real_escape_string($connection, $Password);

        $query = "SELECT * FROM users WHERE user_account='{$Account}' AND user_password='{$Password}' ";
        $Result = mysqli_query($connection, $query);

        if (!$Result) {
            die("Query Failed" . mysqli_error($connection));
        }

        while ($user = mysqli_fetch_assoc($Result)) {
            $id = $user['user_id'];
            $db_account = $user['user_account'];
            $db_password = $user['user_password'];
            $firstname = $user['user_firstname'];
            $lastname = $user['user_lastname'];
            $email = $user['user_email'];
            $role = $user['user_role'];
        }

        if($Account !== $db_account && $Password !== $db_password) {
            header("Location: ../index.php");
        } else {
            $_SESSION['username'] = $db_account; 
            $_SESSION['firstname'] = $firstname;
            $_SESSION['lastname'] = $lastname;
            $_SESSION['role'] = $role;

            header("Location: ../admin/index.php");
        }
    }
?>