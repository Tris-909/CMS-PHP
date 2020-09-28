<?php 
    include('./includes/header.php');
?>

    <div id="wrapper">
        <!-- Navigation -->
        <?php 
            include('./includes/navigation.php');
        ?>

        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to Admin
                            <small>Author</small>
                        </h1>

                        <div class="col-xs-6">
                            <?php 
                                if (isset($_POST["submit"])) {
                                    $category = $_POST["cat_title"];

                                    $InsertCatergoryQuery = "INSERT INTO categories (cat_title) VALUES ('$category')";
                                    mysqli_query($connection, $InsertCatergoryQuery);
                                }

                                if (isset($_POST["edit_submit"])) {
                                    $edit_content = $_POST["edit_cat_title"];
                                    $edit_ID = $_POST["ID"];

                                    $EditQuery = "UPDATE categories SET cat_title='$edit_content' WHERE cat_id='$edit_ID' ";
                                    mysqli_query($connection, $EditQuery);
                                }
                                
                            ?>
                            <form method="POST">    
                                <div class="form-group">
                                    <label for="cat_title">Add Category</label>
                                    <input type="text" class="form-control" name="cat_title" >
                                </div>
                                <div class="form-group">
                                    <input class="btn btn-primary" type="submit" name="submit" value="Add Category" required>
                                </div>  
                            </form>
                            
                            <br>

                            <form method="POST">    
                                <div class="form-group">
                                    <label for="cat_title">Edit Category</label>
                                    <input type="text" class="form-control" name="edit_cat_title" >
                                </div>
                                <div class="form-group">
                                    <input class="btn btn-primary" type="submit" name="edit_submit" value="Edit Category" required>
                                    <select name="ID">
                                        <?php 
                                            $ReadAllQuery = "SELECT * FROM categories";
                                            $ReadAllResult = mysqli_query($connection, $ReadAllQuery);

                                            while($row = mysqli_fetch_assoc($ReadAllResult)) {
                                                $ID = $row["cat_id"];
                                                echo "
                                                    <option value='$ID'> $ID </option>
                                                ";
                                            }
                                        ?>
                                    </select>
                                </div>  
                            </form>
                        </div>

                        <div class="col-xs-6">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Category Title</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $query = "SELECT * FROM categories";
                                        $result = mysqli_query($connection, $query);

                                        while($row = mysqli_fetch_assoc($result)) {
                                            $ID = $row["cat_id"];
                                            $Title = $row["cat_title"];

                                            echo "
                                            <tr>
                                                <td> $ID </td>
                                                <td> $Title </td>
                                                <td>  <a href='categories.php?delete={$ID}'> Delete </a> </td>
                                            </tr>
                                            ";
                                        }
                                    ?>
                                    
                                    <?php 
                                        if (isset($_GET['delete'])) {
                                            $deleteItemID = $_GET['delete'];
                                            $DeleteQuery = "DELETE FROM categories WHERE cat_id='$deleteItemID'"; 
                                            mysqli_query($connection, $DeleteQuery);
                                            header("Location: categories.php");
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
<?php 
    include('./includes/footer.php');
?>