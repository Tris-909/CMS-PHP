<?php  include "includes/header.php"; ?>

    <?php 
        if (isset($_POST['submit'])) {
            //! take the data from FORM
            $username = escape($_POST['username']);
            $email = escape($_POST['email']);
            $password = escape($_POST['password']);
            $formpassword = $password;

            //! check if the data is empty or not
            if (!empty($username) && !empty($email) && !empty($password) ) {
                
                //! hash the current input password and get it to compare with the password in databases
                $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
    
                //! Check if the username has already existed, if yes, then refuse to create a new account
                if (Is_User_Name_Existed($username)) {
                    
                    //! Failed
                    $message = 'Username have already been taken, please choose another username';
                
                } else {
                    
                    //! Success
                    $CreateUserQuery = "INSERT INTO users (user_account, user_password, user_email, user_role) VALUES ('{$username}', '{$password}', '{$email}', 'subcriber')";
                    $CreateUserResult = mysqli_query($connection, $CreateUserQuery);
                    checkQueryError($CreateUserResult);
    
                    $success = "Your Account have been created.";
                    $success2 = "Click here";
                    $success3 = "to sign in";
                }

            } else {
                $message = "Fields can't be empty";
            }
        }
    ?>

    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        <?php 
                        if (isset($message)) {
                            echo "
                            <h3 class='text-center alert alert-danger' role='alert'>$message</h3>
                            ";
                        }

                        if (isset($success)) {
                            echo "
                            <h3 class='text-center alert alert-success' role='alert'>$success
                                <a href='index.php'>$success2</a> $success3
                            </h3>
                            ";
                        }
                        ?>

                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input 
                                autocomplete="on"
                                value="<?php echo isset($username) ? $username : '' ?>"
                                type="text" 
                                name="username" 
                                id="username" 
                                class="form-control" 
                                placeholder="Enter Desired Username">
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input 
                                autocomplete="on"
                                value="<?php echo isset($email) ? $email : '' ?>"
                                type="email" 
                                name="email" 
                                id="email" 
                                class="form-control" 
                                placeholder="somebody@example.com">
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input 
                                autocomplete="on"
                                value="<?php echo isset($formpassword) ? $formpassword : '' ?>"
                                type="password" 
                                name="password" 
                                id="key" 
                                class="form-control" 
                                placeholder="Password">
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
