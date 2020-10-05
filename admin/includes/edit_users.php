<?php 

    if(isset($_GET['edit'])) {
        $user_id = escape($_GET['edit']);
        $GetUserByIdQuery = "SELECT * FROM users WHERE user_id=$user_id";
        
        $GetUserResult = mysqli_query($connection, $GetUserByIdQuery);
        checkQueryError($GetUserResult);

        while ($row = mysqli_fetch_assoc($GetUserResult)) {
            $Account = $row['user_account'];
            $Role = $row['user_role'];
            $Password = $row['user_password'];
            $FirstName = $row['user_firstname'];
            $LastName = $row['user_lastname'];
            $Email = $row['user_email'];
        }
    } else {
        header("Location: ../index.php");
    }

    if(isset($_POST['edit_user']) && isset($_GET['edit'])) {
        $UserID = escape($_GET['edit']);
        $Account = escape($_POST['user_account']);
        $Role = escape($_POST['user_role']);
        $Password = escape($_POST['user_password']);
        $FirstName = escape($_POST['user_firstname']);
        $LastName = escape($_POST['user_lastname']);
        $Email = escape($_POST['user_email']);

        $Password = password_hash($Password, PASSWORD_BCRYPT, array('cost' => 12));

        $EditUserQuery = "UPDATE users SET user_account='{$Account}', user_password='{$Password}', user_firstname='{$FirstName}', user_lastname='{$LastName}', user_email='{$Email}', user_role='{$Role}' WHERE user_id=$UserID";
        mysqli_query($connection, $EditUserQuery);

        $GetNewInfoQuery = "SELECT * FROM users WHERE user_id=$UserID";
        $GetNewInfoResult = mysqli_query($connection, $GetNewInfoQuery);
        checkQueryError($GetNewInfoResult);

        while ($NewInfo = mysqli_fetch_assoc($GetNewInfoResult)) {
            $NewRole = $NewInfo['user_role'];

            if ($NewRole == 'subcriber') {
                header("Location: ../index.php");
            }
        }
    }
?>

<h1 class="page-header">
    Edit User
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
        <label for="title">New Password : </label>
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
        <input class="btn btn-primary" type="submit" name="edit_user" value="Edit User">
    </div>
</form>