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
                                                <td> <a href='../../post.php?source=edit_comment&edit={$ID}'> Edit </a> </td>
                                                <td> <a href='./index.php?source=view_comments&delete={$ID}'> Delete </a> </td>
                                            </tr>
                                            ";
                                            
                                        }

                                        // Approve A Comment 
                                        if (isset($_GET['approve'])) {
                                            $comment_Approve_ID = $_GET['approve'];
                                            $Approve_Query = "UPDATE comments SET comment_status='approve' WHERE comment_id=$comment_Approve_ID";

                                            $ApproveResult = mysqli_query($connection, $Approve_Query);
                                            header("Location: ./index.php?source=view_comments"); //Reload the page to see changes

                                            checkQueryError($ApproveResult);
                                        }

                                        // Unapprove A Comment 
                                        if (isset($_GET['unapprove'])) {
                                            $comment_UnApprove_ID = $_GET['unapprove'];
                                            $UnApprove_Query = "UPDATE comments SET comment_status='unapprove' WHERE comment_id=$comment_UnApprove_ID";

                                            $UnApproveResult = mysqli_query($connection, $UnApprove_Query);
                                            header("Location: ./index.php?source=view_comments"); //Reload the page to see changes

                                            checkQueryError($ApproveResult);
                                        }


                                        // Delete A Comment
                                        if (isset($_GET['delete'])) {
                                            $comment_ID = $_GET['delete'];
                                            $comment_post_id = $_GET['postID'];
                                            $Delete_Comment_Query = "DELETE FROM comments WHERE comment_id=$comment_ID";
                                     
                                            //Decrease comment_count by 1 code below :
                                            $Get_Current_Count_Query = "SELECT post_id, post_comment_count FROM posts WHERE post_id=$comment_post_id";
                                            $GetCountResult = mysqli_query($connection, $Get_Current_Count_Query);
                                            checkQueryError($GetCountResult);
                                            while ($thisCount = mysqli_fetch_assoc($GetCountResult)) {
                                                $postID = $thisCount['post_id'];
                                                $currentCount = $thisCount['post_comment_count'];
                                                $newCount = $currentCount - 1; 
                                            
                                                $Update_New_Count_Query = "UPDATE posts SET post_comment_count=$newCount WHERE post_id=$postID";
                                                $UpdateResult = mysqli_query($connection, $Update_New_Count_Query);
                                                checkQueryError($UpdateResult);
                                            } 

                                            $DeleteCommentResult = mysqli_query($connection, $Delete_Comment_Query);
                                            header("Location: ./index.php?source=view_comments"); //Reload the page to see changes
                                            checkQueryError($DeleteCommentResult);
                                        }
                                    ?>
                                </tbody>
                        </table>