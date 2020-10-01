<h1 class="page-header">
    View All Users 
</h1>

<table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Account</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $query = "SELECT * FROM users";
                                        $result = mysqli_query($connection, $query);

                                        while($row = mysqli_fetch_assoc($result)) {
                                            $ID = $row["user_id"];
                                            $Account = $row["user_account"];
                                            $Password = $row["user_password"];
                                            $FirstName = $row["user_firstname"];
                                            $LastName = $row["user_lastname"];
                                            $Email = $row["user_email"];
                                            $Image = $row["user_image"];
                                            $Role = $row["user_role"];

                                            echo "
                                            <tr>
                                                <td> $ID </td>
                                                <td> $Account </td>
                                                <td> $FirstName </td>
                                                <td>  $LastName </td>
                                                <td> $Email </td>
                                                <td> $Role </td>
                                                <td> <a href='./index.php?source=edit_users&edit={$ID}'> Edit </a> </td>
                                                <td> <a href='./index.php?source=view_users&delete={$ID}'> Delete </a> </td>
                                            </tr>
                                            ";
                                            
                                        }

                                        // Delete A User
                                        if (isset($_GET['delete'])) {
                                            $user_ID = $_GET['delete'];
                                            $Delete_Comment_Query = "DELETE FROM users WHERE user_id = $user_ID";
                                            $DeleteCommentResult = mysqli_query($connection, $Delete_Comment_Query);
                                            header("Location: ./index.php?source=view_users"); //Reload the page to see changes
                                            checkQueryError($DeleteCommentResult);
                                        }
                                    ?>
                                </tbody>
                        </table>