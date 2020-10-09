<div class="col-md-4">

                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Blog Search</h4>
                    <form action="/index.php" method="POST">
                    <div class="input-group">
                        <input name="search" type="text" class="form-control">
                        <span class="input-group-btn">
                            <button name="submit" class="btn btn-default" type="submit">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                        </span>
                    </div>
                    </form>
                    <!-- /.input-group -->
                </div>
                
                <!-- Blog Categories Well -->

                <div class="well">
                    <h4>Blog Categories</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="list-unstyled">
                                <?php 
                                    $CategoryQuery = "SELECT * FROM categories";
                                    $result = mysqli_query($connection, $CategoryQuery);

                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $cat_id = $row['cat_id'];
                                        $cat_title = $row["cat_title"];
                                        echo "<li><a href='category.php?category_id={$cat_id}'>$cat_title</a></li>";
                                    }
                                ?>
                            </ul>
                        </div>
                        <!-- /.col-lg-6 -->
                    </div>
                    <!-- /.row -->
                </div>

                
                <!-- Side Widget Well -->
                <?php 
                    if (isset($_SESSION['username'])) {
                        $username = $_SESSION['username'];
                        
                        //! Hide the Well if the user is already on the add_post page on front-side
                        $link = $_SERVER['REQUEST_URI']; 

                        if ($link != '/add_post.php') {
                            echo "
                            <div class='well'>
                                <h4>Hi $username</h4>
                                <p>Do you want to share something ?</p>
                                <a href='add_post.php'> <div class='btn btn-info' >  Write some blogs </div> </a>
                            </div>
                            ";
                        }
                    }
                ?>


            </div>