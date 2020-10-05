<?php 
    if (isset($_SESSION['username'])) {
        $ID = $_SESSION['userID'];
        $Account = $_SESSION['username'];
        $Role = $_SESSION['role'];
        $Password = $_SESSION['password'];
        $FirstName = $_SESSION['firstname'];
        $LastName = $_SESSION['lastname'];
        $Email = $_SESSION['email'];
    }

    if (isset($_POST['update_profile'])) {
        $Updated_Account = escape($_POST['user_account']);
        $Updated_Role = escape($_POST['user_role']);
        $Updated_Password = escape($_POST['user_password']);
        $Updated_FirstName = escape($_POST['user_firstname']);
        $Updated_LastName = escape($_POST['user_lastname']);
        $Updated_Email = escape($_POST['user_email']);


        $Updated_Password = password_hash($Updated_Password, PASSWORD_BCRYPT, array('cost' => 12));

        // Get the data and push it into database    
        $Update_Query = "UPDATE users SET user_account='{$Updated_Account}', user_role='{$Updated_Role}', user_password='{$Updated_Password}', user_firstname='{$Updated_FirstName}', user_lastname='{$Updated_LastName}', user_email='{$Updated_Email}' WHERE user_id='{$ID}' "; 
        $Result = mysqli_query($connection, $Update_Query);

        checkQueryError($Result);

        // Diretly get new data and update session to render the right information 
        $Get_New_Info_Session = "SELECT * FROM users WHERE user_id='{$ID}'";
        $New_Info = mysqli_query($connection, $Get_New_Info_Session);
        checkQueryError($New_Info);

        while ($NewInfo = mysqli_fetch_assoc($New_Info)) {
            $_SESSION['username'] = $NewInfo['user_account'];
            $_SESSION['role'] = $NewInfo['user_role'];
            $_SESSION['password'] = $NewInfo['user_password'];
            $_SESSION['firstname'] = $NewInfo['user_firstname'];
            $_SESSION['lastname'] = $NewInfo['user_lastname'];
            $_SESSION['email'] = $NewInfo['user_email'];

            header("Location: index.php");
        }
    }
?>

<h1 class="page-header">
    Your Profile
</h1>
<form action="" method="POST" enctype="multipart/form-data">
    <div class="form_group">
        <label for="title">Account :</label>
        <input type="text" class="form-control" name="user_account" value="<?php echo $Account; ?>">
    </div>
    <br>

    <div class="form_group">
        <label for="title">User Role : </label>
        <select name='user_role'>
            <?php 
            if  ($Role == 'admin') {
                echo "
                    <option value='admin' selected>admin</option>
                    <option value='subcriber'>subcriber</option>
                ";
            } else {
                echo "
                    <option value='admin' selected>admin</option>
                    <option value='subcriber' selected>subcriber</option>
                ";  
            }
            ?>
        </select>
    </div>
    <br>

    <div class="form_group">
        <label for="title">Change Your Password : </label>
        <input type="password" class="form-control" name="user_password">
    </div>
    <br>

    <div class="form_group">
        <label for="title">First Name : </label>
        <input type="text" class="form-control" name="user_firstname" value="<?php echo $FirstName; ?>">
    </div>
    <br>

    <div class="form_group">
        <label for="title">Last Name : </label>
        <input type="text" class="form-control" name="user_lastname" value="<?php echo $LastName; ?>">
    </div>
    <br>

    <div class="form_group">
        <label for="title">Email : </label>
        <input type="text" class="form-control" name="user_email" value="<?php echo $Email; ?>">
    </div>
    <br>

    <div class="form_group">
        <input class="btn btn-primary" type="submit" name="update_profile" value="Update">
    </div>
</form>