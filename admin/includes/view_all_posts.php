<?php 
    if (isset($_POST['checkBoxArray'])) {
        foreach($_POST['checkBoxArray'] as $checkBoxValue) {
            $CurPost_ID = $checkBoxValue;
            $bulk_options = $_POST['options'];

            switch($bulk_options) {
                case 'public': 
                    $Bulk_Public_Query = "UPDATE posts SET post_status='$bulk_options' WHERE post_id=$CurPost_ID";
                    mysqli_query($connection, $Bulk_Public_Query);
                break;
                case 'draft':
                    $Bulk_Draft_Query = "UPDATE posts SET post_status='$bulk_options' WHERE post_id=$CurPost_ID";
                    mysqli_query($connection, $Bulk_Draft_Query);
                break;
                case 'delete':
                    $Bulk_Delete_Query = "DELETE FROM posts WHERE post_id=$CurPost_ID";
                    mysqli_query($connection, $Bulk_Delete_Query);
                break;
                case 'clone':
                    $Get_Post_By_Id_Query = "SELECT * FROM posts WHERE post_id=$CurPost_ID";
                    $GetPostByIdResult = mysqli_query($connection, $Get_Post_By_Id_Query);

                    while ($post = mysqli_fetch_assoc($GetPostByIdResult)) {
                        $post_category_id = $post['post_category_id'];
                        $post_title = $post['post_title'];
                        $post_author = $post['post_author'];
                        $post_image = $post['post_image'];
                        $post_content = $post['post_content'];
                        $post_tags = $post['post_tags'];
                        $post_comment_count = $post['post_comment_count'];
                        $post_status = $post['post_status'];

                        $Add_post_query = "INSERT INTO posts 
                        (post_category_id, 
                        post_title, 
                        post_author, 
                        post_date, 
                        post_image, 
                        post_content, 
                        post_tags, 
                        post_comment_count, 
                        post_status) 
                        VALUES 
                        ({$post_category_id},
                        '{$post_title}',
                        '{$post_author}',
                        now(),
                        '{$post_image}',
                        '{$post_content}',
                        '{$post_tags}',
                        '{$post_comment_count}',
                        '{$post_status}')";

                        $create_post_query = mysqli_query($connection, $Add_post_query);
                        if (!$create_post_query) {
                            die ("QUERY FAILED .". mysqli_error($connection));
                        }
                    }
                break;
                case 'reset': 
                    $Reset_Views_Query = "UPDATE posts SET post_views=0 WHERE post_id=$CurPost_ID";
                    mysqli_query($connection, $Reset_Views_Query);
                break;
            }
        }
    }
?>

<h1 class="page-header">
    View All Posts
</h1>
<form method="POST">
    <table class="table table-bordered table-hover">

        <div class="bulkOptionsContainer" class="col-xs-4">
            <select class="form-control" name="options">
                <option value="public">Set Status to public</option>
                <option value="draft">Set Status to draft</option>
                <option value="delete">Delete Posts</option>
                <option value="clone">Clone Posts</option>
                <option value="reset">Reset Views</option>
                <option value="" selected>All Posts</option>
            </select>

        </div>

        <br>

        <div class="col-xs-4">
            <input type="submit" name="submit" class="btn btn-success" value="Apply">
            <a class="btn btn-primary" href="index.php?source=add_post">Add New</a>
        </div>

        <br>
        <br>
        <br>


        <thead>
            <tr>
                <th><input id="selectAllPost" type="checkbox"></th>
                <th>Id</th>
                <th>Author</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Date</th>
                <th>Views</th>
                <th>Edit</th>
                <th>View Post</th>
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
                $Views = $row["post_views"];

                echo "
                <tr>
                    <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='$ID'></td>
                    <td> $ID </td>
                    <td> $Author </td>
                    <td> $Title </td>
                    <td>  $Dynamic_Title </td>
                    <td> $Status </td>
                    <td> <img class='img-responsive' width='100' src='$Image' alt='Image'> </td>
                    <td> $Tags </td>
                    <td> $Comments </td>
                    <td> $Date </td>
                    <td> $Views </td>
                    <td> <a href='index.php?source=edit_post&edit={$ID}'> Edit </a> </td>
                    <td> <a href='../post.php?id=$ID'> View Post </a> </td>
                    <td> <a onClick=\"javascript: return confirm('Are you sure you want to delete this post ?');\" href='index.php?source=view_all_post&delete={$ID}'> Delete </a> </td>
                </tr>
                ";
            }
            ?>
            <?php 
                if (isset($_GET['delete'])) {
                    $delete_ID = $_GET['delete'];

                    $Delete_Query = "DELETE FROM posts WHERE post_id='{$delete_ID}'";
                    $delete_result = mysqli_query($connection, $Delete_Query);

                    header("Location: index.php?source=view_all_post");
                }
            ?>
        </tbody>
    </table>
</form>
