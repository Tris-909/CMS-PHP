<?php  include "includes/db.php"; ?>
 <?php  include "includes/header.php"; ?>

    <?php 
        if (isset($_POST['submit'])) {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            if (!empty($username) && !empty($email) && !empty($password) ) {
                $username = mysqli_escape_string($connection, $username);
                $email = mysqli_escape_string($connection, $email);
                $password = mysqli_escape_string($connection, $password);
    
                $hashFormat = "$2y$07$";
    
                // Get randSalt from databases
                $GetSaltQuery = "SELECT randSalt FROM users";
                $GetSaltResult = mysqli_query($connection, $GetSaltQuery);
                $row = mysqli_fetch_array($GetSaltResult);
                $randSalt = $row['randSalt'];
    
    
                $hash_and_salt = $hashFormat .  $randSalt;
                $encrypt_password = crypt($password, $hash_and_salt);
    
                $CreateUserQuery = "INSERT INTO users (user_account, user_password, user_email, user_role) VALUES ('{$username}', '{$encrypt_password}', '{$email}', 'subcriber')";
                $CreateUserResult = mysqli_query($connection, $CreateUserQuery);
    
                if(!$CreateUserResult) {
                    die("Query Failed ". mysqli_error($connection));
                }    
            } else {
                $message = "Field can't be empty";
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
                        ?>

                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username">
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
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
