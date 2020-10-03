<?php 
    if (isset($_GET['edit']) && isset($_POST['edit_post'])) {
        $post_id = $_GET['edit'];
        $post_category_id = $_POST['post_category_id'];
        $post_title = $_POST['title'];
        $post_author = $_POST['post_author'];
        $post_status = $_POST['post_status'];

        $post_image = $_FILES['image']['name'];
        $post_image_temp = $_FILES['image']['tmp_name'];

        $post_tags = $_POST['post_tags'];
        $post_content = $_POST['post_content'];

        move_uploaded_file($post_image_temp, "./images/$post_image");
        
        $Edit_Query = "UPDATE posts SET 
        post_title='{$post_title}',
        post_category_id='{$post_category_id}', 
        post_author='{$post_author}',
        post_status='{$post_status}',
        post_image='./images/{$post_image}',
        post_tags='{$post_tags}',
        post_content='{$post_content}' WHERE
        post_id='{$post_id}'
        ";

        if (empty( $post_image) ) {
            $Edit_Query = "UPDATE posts SET 
            post_title='{$post_title}',
            post_category_id='{$post_category_id}', 
            post_author='{$post_author}',
            post_status='{$post_status}',
            post_tags='{$post_tags}',
            post_content='{$post_content}' WHERE
            post_id='{$post_id}'
            ";
        }

        mysqli_query($connection, $Edit_Query);

        echo "
        <div class='alert alert-success' role='alert'>Edit post successfully ! <a href='../post.php?id={$post_id}'>View This Post</a> </div>
        ";
    }

?>

<form action="" method="POST" enctype="multipart/form-data">
    <?php 
        $id_post = $_GET['edit'];
        $Get_info_query = "SELECT * FROM posts WHERE post_id='{$id_post}'";

        $result = mysqli_query($connection, $Get_info_query);

        while($row = mysqli_fetch_assoc($result)) {
            $post_title = $row['post_title'];
            $post_category_id = $row['post_category_id'];
            $post_author = $row['post_author'];
            $post_status = $row['post_status'];
            $post_image = $row['post_image'];
            $post_tags = $row['post_tags'];
            $post_content = $row['post_content'];
        }

    ?>
    <h1> EDIT POST </h1>
    <div class="form_group">
        <label for="title">Post Title : </label>
        <input type="text" class="form-control" name="title" value="<?php echo $post_title; ?>">
    </div>
    <br>

    <div class="form_group">
        <label for="title">Post Category : </label>
        <select name="post_category_id">
            <?php  
                $Get_Category_Query = "SELECT * FROM categories";
                $Get_Category_Result = mysqli_query($connection, $Get_Category_Query);

                while ($row = mysqli_fetch_assoc($Get_Category_Result)) {
                    $Category_ID = $row["cat_id"];
                    $Category_title = $row["cat_title"];

                    if ($Category_ID == $post_category_id) {
                        echo "
                        <option value='{$Category_ID}' selected> $Category_title </option>
                      ";
                    } else {
                        echo "
                        <option value='{$Category_ID}'> $Category_title </option>
                      ";
                    }
                }
            ?>
        </select>
    </div>
    <br>

    <div class="form_group">
        <label for="title">Post Author : </label>
        <input type="text" class="form-control" name="post_author" value="<?php echo $post_author; ?>">
    </div>
    <br>

    <div class="form_group">
        <label for="title">Post Status : </label>
        <select name="post_status">
            <?php 
            $isValid = ($post_status == 'draft');
            if ($isValid == 1) {
                echo "<option value='draft' selected>draft</option>";
                echo "<option value='public'>public</option>";
            } else {
                echo "<option value='draft'>draft</option>";
                echo "<option value='public' selected>public</option>";
            }
            ?>
        </select>
    </div>
    <br>

    <img src="<?php echo $post_image; ?>" width=300 height=200 alt="img" >
    <div class="form_group">
        <label for="title">Choose New Post Image : </label>
        <input type="file" name="image" >
    </div>
    <br>

    <div class="form_group">
        <label for="title">Post Tags : </label>
        <input type="text" class="form-control" name="post_tags" value="<?php echo $post_tags; ?>">
    </div>
    <br>
    
    <div class="form_group">
        <label for="title">Post Content : </label>
        <textarea class="form-control" name="post_content" id="body" cols="30" rows="10"><?php echo $post_content; ?></textarea>
    </div>
    <br>
    <div class="form_group">
        <input class="btn btn-primary" type="submit" name="edit_post" value="Submit Edit">
    </div>
</form>