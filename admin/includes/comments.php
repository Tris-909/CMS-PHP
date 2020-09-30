<h1 class="page-header">
    View Comments 
</h1>

<table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Belong to Post</th>
                                        <th>Author</th>
                                        <th>Email</th>
                                        <th>Content</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Approve</th>
                                        <th>UnApprove</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $query = "SELECT * FROM comments";
                                        $result = mysqli_query($connection, $query);

                                        while($row = mysqli_fetch_assoc($result)) {
                                            $ID = $row["comment_id"];
                                            $Post_ID = $row["comment_post_id"];
                                            $Author = $row["comment_author"];
                                            $Email = $row["comment_email"];
                                            $Content = $row["comment_content"];
                                            $Status = $row["comment_status"];
                                            $Date = $row["comment_date"];

                                            $Find_Post_Title_Query = "SELECT post_id, post_title FROM posts WHERE post_id=$Post_ID";
                                            $FindPostTitleResult = mysqli_query($connection, $Find_Post_Title_Query);

                                            while ($RelatedPost = mysqli_fetch_assoc($FindPostTitleResult)) {
                                                $post_id = $RelatedPost['post_id'];
                                                $post_title = $RelatedPost['post_title'];

                                                echo "
                                                <tr>
                                                    <td> $ID </td>
                                                    <td> <a href='../../post.php?id={$post_id}'> $post_title </a> </td>
                                                    <td> $Author </td>
                                                    <td>  $Email </td>
                                                    <td> $Content </td>
                                                    <td> $Status </td>
                                                    <td> $Date </td>
                                                    <td> <a href='./index.php?source=view_comments&approve={$ID}'> Approve </a> </td>
                                                    <td> <a href='./index.php?source=view_comments&unapprove={$ID}'> UnApprove </a> </td>
                                                    <td> <a href='../../post.php?source=edit_comment&edit={$ID}'> Edit </a> </td>
                                                    <td> <a href='./index.php?source=view_comments&delete={$ID}&postID={$Post_ID}'> Delete </a> </td>
                                                </tr>
                                                ";
                                            } 
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