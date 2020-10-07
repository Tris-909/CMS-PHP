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


                <!-- Login  -->
                <?php 
                    if (isset($_SESSION['username'])) {
                        echo "";
                    } else {
                        echo "
                        <div class='well'>
                        <h3>Login</h3>
                        <form action='./includes/login.php' method='POST'>
                        <div class='input-group'>
                            <div class='input-group'>
                                <label for='account'>Account :</label>
                                <input name='account' type='text' class='form-control' placeholder='Account' required>
                            </div>
                            <br>
                            <div class='input-group'>
                                <label for='password'>Password :</label>
                                <input name='password' type='password' class='form-control' placeholder='Password' required>
                            </div>";
                        
                        if (isset($_SESSION['warning'])) {
                            $log_in_failed_message = $_SESSION['warning'];
                            echo "
                            <h4 class='text-center alert alert-danger' role='alert'> $log_in_failed_message </h4>
                            ";
                        }
                        echo "    
                            <br>
                            <input type='submit' name='login' class='btn btn-primary'>
                        </div>
                        </form>
                        </div>
                        ";
                    }
                ?>


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
                <div class="well">
                    <h4>Side Widget Well</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, perspiciatis adipisci accusamus laudantium odit aliquam repellat tempore quos aspernatur vero.</p>
                </div>

            </div>