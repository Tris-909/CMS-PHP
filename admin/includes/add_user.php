<?php 

    if(isset($_POST['create_user'])) {
        $connection = mysqli_connect('localhost', 'root', 'root', 'cms', 3307);

        $Account = $_POST['user_account'];
        $Role = $_POST['user_role'];
        $Password = $_POST['user_password'];
        $FirstName = $_POST['user_firstname'];
        $LastName = $_POST['user_lastname'];
        $Email = $_POST['user_email'];

        $Add_User_Query = "INSERT INTO users (user_account, 
        user_password, 
        user_firstname,
        user_lastname, 
        user_email, 
        user_image, 
        user_role) VALUES (
        '$Account', 
        '$Password',
        '$FirstName',
        '$LastName',
        '$Email',
        null,
        '$Role')";

        $AddUserResult = mysqli_query($connection, $Add_User_Query);
        if (!$AddUserResult) {
            die ("QUERY FAILED .". mysqli_error($connection));
        }

        echo "
        <div class='alert alert-success' role='alert'>You have created user successfully ! <a href='index.php?source=view_users'>View Users</a> </div>
        ";
    }
?>

<h1 class="page-header">
    Add User
</h1>
<form action="" method="POST" enctype="multipart/form-data">
    <div class="form_group">
        <label for="title">Account :</label>
        <input type="text" class="form-control" name="user_account">
    </div>
    <br>

    <div class="form_group">
        <label for="title">User Role : </label>
        <select name='user_role'>
            <?php 
                echo "
                    <option value='admin'>admin</option>
                    <option value='subcriber'>subcriber</option>
                ";
            ?>
        </select>
    </div>
    <br>

    <div class="form_group">
        <label for="title">Password : </label>
        <input type="password" class="form-control" name="user_password">
    </div>
    <br>

    <div class="form_group">
        <label for="title">First Name : </label>
        <input type="text" class="form-control" name="user_firstname">
    </div>
    <br>

    <div class="form_group">
        <label for="title">Last Name : </label>
        <input type="text" class="form-control" name="user_lastname">
    </div>
    <br>

    <div class="form_group">
        <label for="title">Email : </label>
        <input type="text" class="form-control" name="user_email">
    </div>
    <br>

    <div class="form_group">
        <input class="btn btn-primary" type="submit" name="create_user" value="Create User">
    </div>
</form>