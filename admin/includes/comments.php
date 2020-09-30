<h1 class="page-header">
    View Comments 
</h1>

<table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Post_Id</th>
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

                                            echo "
                                            <tr>
                                                <td> $ID </td>
                                                <td> $Post_ID </td>
                                                <td> $Author </td>
                                                <td>  $Email </td>
                                                <td> $Content </td>
                                                <td> $Status </td>
                                                <td> $Date </td>
                                                <td> <a href='index.php?source=approve_comment&approve={$ID}'> Approve </a> </td>
                                                <td> <a href='index.php?source=unapprove_comment&unapprove={$ID}'> UnApprove </a> </td>
                                                <td> <a href='index.php?source=edit_comment&edit={$ID}'> Edit </a> </td>
                                                <td> <a href='index.php?delete={$ID}'> Delete </a> </td>
                                            </tr>
                                            ";
                                        }
                                    ?>
                                    <?php 
                                        if (isset($_GET['delete'])) {
                                            $delete_ID = $_GET['delete'];

                                            $Delete_Query = "DELETE FROM posts WHERE post_id='{$delete_ID}'";
                                            $delete_result = mysqli_query($connection, $Delete_Query);
                                            
                                            header("Location: index.php"); //Reload the page to see changes

                                            checkQueryError($delete_result);
                                        }
                                    ?>
                                </tbody>
                        </table>