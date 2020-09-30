<?php 
    if (isset($_POST['create_post'])) {
        $post_category_id = $_POST['post_category_id'];
        $post_title = $_POST['title'];
        $post_author = $_POST['post_author'];
        $post_date = date('d-m-y');

        $post_image = $_FILES['image']['name'];
        $post_image_temp = $_FILES['image']['tmp_name'];

        $post_content = $_POST['post_content'];
        $post_tags = $_POST['post_tags'];
        $post_status = $_POST['post_status'];
        $post_comment_count = 1;
        
        define ('SITE_ROOT', realpath(dirname(__FILE__)));

        move_uploaded_file($post_image_temp, "C:/Users/USER/Desktop/CMS/CMS_TEMPLATE/admin/images/$post_image");
    
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
        ('{$post_category_id}',
        '{$post_title}',
        '{$post_author}',
        now(),
        './images/{$post_image}',
        '{$post_content}',
        '{$post_tags}',
        '{$post_comment_count}',
        '{$post_status}')";

        $create_post_query = mysqli_query($connection, $Add_post_query);
        
        checkQueryError($create_post_query);
    }
?>

<form action="" method="POST" enctype="multipart/form-data">
    <div class="form_group">
        <label for="title">Post Title : </label>
        <input type="text" class="form-control" name="title">
    </div>
    <br>

    <div class="form_group">
        <label for="title">Choose Category : </label>
        <select name="post_category_id"> 
            <?php 
                $get_category_query = "SELECT * FROM categories";
                $Category_Result = mysqli_query($connection, $get_category_query);

                while ($CategoryResult = mysqli_fetch_assoc($Category_Result)) {
                    $category_title = $CategoryResult["cat_title"];
                    $category_id = $CategoryResult["cat_id"];

                    echo "
                        <option value='{$category_title}'>$category_title</option>
                    ";
                }
            ?>
        </select>
    </div>
    <br>

    <div class="form_group">
        <label for="title">Post Author : </label>
        <input type="text" class="form-control" name="post_author">
    </div>
    <br>

    <div class="form_group">
        <label for="title">Post Status : </label>
        <input type="text" class="form-control" name="post_status">
    </div>
    <br>


    <div class="form_group">
        <label for="title">Post Image : </label>
        <input type="file" name="image">
    </div>
    <br>

    <div class="form_group">
        <label for="title">Post Tags : </label>
        <input type="text" class="form-control" name="post_tags">
    </div>
    <br>
    
    <div class="form_group">
        <label for="title">Post Content : </label>
        <textarea class="form-control" name="post_content" id="" cols="30" rows="10"></textarea>
    </div>
    <br>
    <div class="form_group">
        <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
    </div>
</form>