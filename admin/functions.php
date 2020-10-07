<?php 
    function checkQueryError($query) {
        global $connection;
        if (!$query) {
            die ("QUERY FAILED .". mysqli_error($connection));
        }
    }

    function escape($string) {
        global $connection;
        return mysqli_real_escape_string($connection, trim($string));
    }

    function getRecords($tablename) {
        global $connection;
        $GetRecordsQuery = "SELECT * FROM " . $tablename;
        $GetRecordsResult = mysqli_query($connection, $GetRecordsQuery);
        checkQueryError($GetRecordsResult);
        return mysqli_num_rows($GetRecordsResult);
    }

    function LogInUser($Account, $Password) {
        global $connection;
        $GetHashedPassword = "SELECT * FROM users WHERE user_account='$Account'";
        $GetHashedPasswordResult = mysqli_query($connection, $GetHashedPassword);

        while ($password = mysqli_fetch_assoc($GetHashedPasswordResult)) {
            $id = $password['user_id'];
            $db_account = $password['user_account'];
            $HashedPassword = $password['user_password'];
            $firstname = $password['user_firstname'];
            $lastname = $password['user_lastname'];
            $email = $password['user_email'];
            $role = $password['user_role'];
        }

        if (password_verify($Password, $HashedPassword)) {
            $_SESSION['userID'] =  $id;
            $_SESSION['username'] = $db_account; 
            $_SESSION['password'] = $HashedPassword;
            $_SESSION['firstname'] = $firstname;
            $_SESSION['lastname'] = $lastname;
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $role;

            header("Location: ../admin/index.php");

        } else {
            $login_failed_message = 'Wrong Username or Password, please try again !';
            
            $_SESSION['warning'] = $login_failed_message;
            
            header("Location: ../index.php");
            
        }
    }

    function Is_User_Name_Existed($Account) {
        global $connection;
        $Check_Query = "SELECT * FROM users WHERE user_account ='$Account'";
        $Result = mysqli_query($connection, $Check_Query);
        $Count = mysqli_num_rows($Result);

        if ($Count != 0) {
            return true;
        } else {
            return false;
        }
    }
?>