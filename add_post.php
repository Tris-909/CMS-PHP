    <?php 
        include('./includes/db.php');
        include('./includes/header.php');
    ?>

    <!-- Navigation -->
    <?php 
        include('./includes/navigation.php');
    ?>

    <?php 
            if (isset($_POST['create_post'])) {
                $post_category_id = escape($_POST['post_category_id']);
                $post_title = escape($_POST['title']);
                $post_author = escape($_SESSION['username']);
                $post_date = date('d-m-y');
        
                $post_image = $_FILES['image']['name'];
                $post_image_temp = $_FILES['image']['tmp_name'];
        
                $post_content = escape($_POST['post_content']);
                $post_status = 'public';
                $post_comment_count = 0;
                $likes = 0;
        
                move_uploaded_file($post_image_temp, "./admin/images/$post_image");
            
                $Add_post_query = "INSERT INTO posts 
                (post_category_id, 
                post_title, 
                post_author, 
                post_date, 
                post_image, 
                post_content, 
                post_tags, 
                post_comment_count, 
                post_status, 
                likes) 
                VALUES 
                ({$post_category_id},
                '{$post_title}',
                '{$post_author}',
                now(),
                './images/{$post_image}',
                '{$post_content}',
                '',
                {$post_comment_count},
                '{$post_status}',
                {$likes})";
        
                $create_post_query = mysqli_query($connection, $Add_post_query);
                if (!$create_post_query) {
                    die ("QUERY FAILED .". mysqli_error($connection));
                }
        
                $the_last_post_ID = mysqli_insert_id($connection);
        
                $confirm = "
                <div class='alert alert-success' role='alert'>New post has been created successfully ! <a href='../post.php?id=$the_last_post_ID'>View This Post Here</a> </div>
                ";
            }
    ?>

    <!-- Page Content -->   
    <div class="container">

        <div class="row">

            <div class="col-md-8">
            
            <?php 
                if (isset($confirm)) {
                    echo $confirm;
                } else {
                    echo "
                    <h1 class='page-header'>
                        Let's write something !
                    </h1>
                    <form action='' method='POST' enctype='multipart/form-data'>
                        <div class='form_group'>
                            <label for='title'>Post Title : </label>
                            <input type='text' class='form-control' name='title'>
                        </div>
                        <br>
                    
                        <div class='form_group'>
                            <label for='title'>Choose Category : </label>
                            <select name='post_category_id'> 
                    ";

                    $get_category_query = 'SELECT * FROM categories';
                    $Category_Result = mysqli_query($connection, $get_category_query);
                    while ($CategoryResult = mysqli_fetch_assoc($Category_Result)) {
                        $category_title = $CategoryResult["cat_title"];
                        $category_id = $CategoryResult["cat_id"];
                    
                        echo "
                            <option value='{$category_id}'>$category_title</option>
                        ";
                    }
                    echo "
                        </select>
                        </div>
                        <br>

                        <div class='form_group'>
                            <label for='title'>Post Image : </label>
                            <input type='file' name='image'>
                        </div>
                        <br>

                        <div class='form_group'>
                            <label for='title'>Post Content : </label>
                            <textarea id='body' class='form-control' name='post_content' cols='30' rows='10'></textarea>
                        </div>
                        <br>
                        <div class='form_group'>
                            <input class='btn btn-primary' type='submit' name='create_post' value='Publish Post'>
                        </div>
                    </form>
                    ";

                }
            ?>
            
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php 
                include('./includes/sidebar.php');
            ?>
        </div>
        
        <?php 
            include('./includes/footer.php');
        ?>
    </div>


