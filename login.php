<?php  include "./includes/header.php"; ?>
<?php 
	if (isset($_SESSION['username'])) {
		header('Location: ./index.php');
	}

    if(isset($_POST['login'])) {
        $Account = $_POST['username'];
        $Password = $_POST['password'];

        $Account = mysqli_real_escape_string($connection, $Account);
        $Password = mysqli_real_escape_string($connection, $Password);

        LogInUser($Account, $Password);
    }
?>

<!-- Navigation -->

<?php  include "./includes/navigation.php"; ?>


<!-- Page Content -->
<div class="container">

	<div class="form-gap"></div>
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="text-center">


							<h3><i class="fa fa-user fa-4x"></i></h3>
							<h2 class="text-center">Login</h2>
							<div class="panel-body">


								<form id="login-form" role="form" autocomplete="off" class="form" method="post">

									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>

											<input
												autocomplete="on"
                     							value="<?php echo isset($username) ? $username : '' ?>" 
												name="username" 
												type="text" 
												class="form-control" 
												placeholder="Enter Username" 
												required>
										</div>
									</div>

									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue"></i></span>
											<input 
												autocomplete="on"
                     							value="<?php echo isset($password) ? $password : '' ?>" 
												name="password" 
												type="password" 
												class="form-control" 
												placeholder="Enter Password" 
												required>
										</div>
									</div>

									<?php 
										if (isset($_SESSION['warning'])) {
											$log_in_failed_message = $_SESSION['warning'];
											echo "
											<h4 class='text-center alert alert-danger' role='alert'> $log_in_failed_message </h4>
											";
										}
									?>

									<div class="form-group">
										<a target='_blank' href='./forgot_password.php?forgot=<?php echo uniqid(true); ?>'> Forgotten password ? </a>
									</div>

									<div class="form-group">

										<input name="login" class="btn btn-lg btn-primary btn-block" value="Login" type="submit">
									</div>


								</form>

							</div><!-- Body-->

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<hr>

	<?php include "./includes/footer.php";?>

</div> <!-- /.container -->
