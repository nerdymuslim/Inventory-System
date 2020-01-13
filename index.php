<?php require 'app/controller.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<title>Order & Inventory System</title>
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/font-awesome/4.5.0/css/font-awesome.min.css">
</head>
<body>

	<div class="container">
		<div class="row">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<center><h3>Sample Store Name</h3></center>
					</div>
					<div class="modal-body">
						<form method="POST" autocomplete="off">
							<label>Username</label>
							<div class="input-group">
								<div class="input-group-addon">
									<span class="glyphicon glyphicon-user"></span>
								</div>							
								<input type="text" name="username" class="form-control">
							</div>

							<label>Password</label>
							<div class="input-group">
								<div class="input-group-addon">
									<span class="glyphicon glyphicon-lock"></span>
								</div>							
								<input type="password" name="password" class="form-control">
							</div>						
							<br>
							<button name="login" class="btn btn-primary">Login <span class="glyphicon glyphicon-check"></span></button>
							<!-- &nbsp;&nbsp;<a href="register.php">New User?</a> -->
							<button type="button" data-toggle="modal" data-target="#new_user" class="btn btn-success">Create new User <span class="glyphicon glyphicon-pencil"></span></button>							
						</form>						
					</div>
				</div>
			</div> <!-- modal-dialog -->

			<!-- MODAL FOR CREATING NEW USER -->
			<div class="modal fade" id="new_user" tab-index="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h3>
								<center>Create New User</center>							
							</h3>
						</div>
						<div class="modal-body">
							<form method="POST" autocomplete="off" enctype="multipart/form-data">
								<label>Firstname</label>
								<div class="input-group">
									<div class="input-group-addon">
										<span class="glyphicon glyphicon-user"></span>
									</div>							
									<input type="text" name="firstname" class="form-control">
								</div>

								<label>Lastname</label>
								<div class="input-group">
									<div class="input-group-addon">
										<span class="glyphicon glyphicon-user"></span>
									</div>							
									<input type="text" name="lastname" class="form-control">
								</div>						

								<label>Email</label>
								<div class="input-group">
									<div class="input-group-addon">
										<span class="glyphicon glyphicon-envelope"></span>
									</div>							
									<input type="email" name="email" class="form-control">
								</div>								

								<label>Username</label>
								<div class="input-group">
									<div class="input-group-addon">
										<span class="glyphicon glyphicon-pencil"></span>
									</div>							
									<input type="text" name="username" class="form-control">
								</div>

								<label>Password</label>
								<div class="input-group">
									<div class="input-group-addon">
										<span class="glyphicon glyphicon-lock"></span>
									</div>							
									<input type="password" name="password" class="form-control">
								</div>

								<label>Re-type Password</label>
								<div class="input-group">
									<div class="input-group-addon">
										<span class="glyphicon glyphicon-lock"></span>
									</div>							
									<input type="password" name="r_password" class="form-control">
								</div>

								<label>Profile Image</label>
								<div class="input-group">
									<div class="input-group-addon">
										<span class="fa fa-image"></span>
									</div>							
									<input type="file" name="profile_img" class="form-control">
								</div>																			

								<br>
								<button name="register" class="btn btn-primary">Register &nbsp;<span class="glyphicon glyphicon-pencil"></span></button>
							</form>						
						</div> <!-- modal-body -->	
					</div> <!-- modal-content -->
				</div> <!-- modal-dialog -->
			</div>			
		</div>
	</div>

	<script type="text/javascript" src="assets/js/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
</body>
</html>