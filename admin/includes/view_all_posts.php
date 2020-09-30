<table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Author</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Image</th>
                                        <th>Tags</th>
                                        <th>Comments</th>
                                        <th>Date</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $query = "SELECT * FROM posts";
                                        $result = mysqli_query($connection, $query);

                                        while($row = mysqli_fetch_assoc($result)) {
                                            $ID = $row["post_id"];
                                            $Author = $row["post_author"];
                                            $Title = $row["post_title"];
                                            $Category = $row["post_category_id"];

                                            // Get string Title and display it instead of displaying category_id 
                                            $Get_Dynamic_Category_Title = "SELECT * FROM categories WHERE cat_id=$Category";
                                            $Dynamic_Category_Title = mysqli_query($connection, $Get_Dynamic_Category_Title);
                                            while ($caterResult = mysqli_fetch_assoc($Dynamic_Category_Title)) {
                                                $Dynamic_Title = $caterResult['cat_title'];
                                            }

                                            $Status = $row["post_status"];
                                            $Image = $row["post_image"];
                                            $Tags = $row["post_tags"];
                                            $Comments = $row["post_comment_count"];
                                            $Date = $row["post_date"];

                                            echo "
                                            <tr>
                                                <td> $ID </td>
                                                <td> $Author </td>
                                                <td> $Title </td>
                                                <td>  $Dynamic_Title </td>
                                                <td> $Status </td>
                                                <td> <img class='img-responsive' width='100' src='$Image' alt='Image'> </td>
                                                <td> $Tags </td>
                                                <td> $Comments </td>
                                                <td> $Date </td>
                                                <td> <a href='index.php?source=edit_post&edit={$ID}'> Edit </a> </td>
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