<?php
	require 'dbconn.php';
	require 'model.php';

	$db = new Database();
	$connect = new Model($db);

	date_default_timezone_set('Asia/Manila');

	// For Creating New User
	if(isset($_POST['register'])){

		$target = "assets/images/".basename($_FILES['profile_img']['name']);
		$pwd = $_POST['password'];
		$rpwd = $_POST['r_password'];
		$uname = $_POST['username'];

		$connect-> fname = $_POST['firstname'];
		$connect-> lname = $_POST['lastname'];
		$connect-> email = $_POST['email'];
		$connect-> username = $_POST['username'];
		$connect-> password = $_POST['password'];
		$connect -> profile_img = $_FILES['profile_img']['name'];

		$row = $connect -> CheckUserName();
		$validate_uname = mysqli_num_rows($row);

		$row2 = $connect -> CheckEmail();
		$validate_email = mysqli_num_rows($row2);

		// Validation Here
		if($validate_uname > 0){
			echo '<script>alert("Username is already taken! Please Choose Another")</script>';
		}
		elseif($validate_email > 0){
			echo '<script>alert("Email is already in use!")</script>';
		}
		elseif(strlen($uname) > 15){
			echo '<script>alert("Username is too long! It must contain 15 characters only")</script>';
		}
		elseif(strlen($uname) <= 5){
			echo '<script>alert("Username is too short! It must contain atleast 6 characters")</script>';
		}
		elseif(strlen($pwd) > 11){
			echo '<script>alert("Password is too long! It must contain 11 characters only")</script>';
		}
		elseif(strlen($pwd) <= 5){
			echo '<script>alert("Password is too short! It must contain atleast 6 characters")</script>';
		}
		elseif($pwd != $rpwd){
			echo '<script>alert("Password did not match")</script>';
		}
		else{
			$newUser = $connect -> CreateUser();

			if($newUser && move_uploaded_file($_FILES['profile_img']['tmp_name'], $target)){
				echo '<script>alert("User Successfully Created!")</script>';
				echo "<meta http-equiv='refresh' content='0;url=index.php'>";
			}
			else{
				echo '<script>alert("Connection Error!")</script>';
			}
		}

	} // End of Creating New User


	// For Login
	if(isset($_POST['login'])){
		$username = $_POST['username'];
		$password = $_POST['password'];

		$connect -> uname = $username;
		$connect -> pwd = $password;

		$check = $connect -> Login();
		$result = mysqli_fetch_assoc($check);

		$user_id = $result['user_id'];
		$fname = $result['fname'];
		$lname = $result['lname'];
		$uname = $result['username'];
		$pwd = $result['password'];
		$img = $result['image'];
		$status = "active";

		if(!empty($username) && !empty($password)){
			if(($username == $result['username']) && ($password == $result['password'])){
				session_start();
				$_SESSION['user_id'] = $user_id;
				$_SESSION['fname'] = $fname;
				$_SESSION['lname'] = $lname;
				$_SESSION['username'] = $uname;
				$_SESSION['password'] = $pwd;
				$_SESSION['profile_img'] = $img;
				$_SESSION['logged_in'] = $status;

				echo "<meta http-equiv='refresh' content='0;url=home.php'";
			}
			else{
				echo '<script>alert("Incorrect Credentials")</script>';
			}
		}
		else{
			echo '<script>alert("Please don\'t leave the textbox blank!")</script>';
		}

	}


	// For Adding Product
	if (isset($_POST['add_prod'])) {

		$target = "assets/images/".basename($_FILES['prod_img']['name']);

		$connect -> prod_name = $_POST['prod_name'];
		$connect -> prod_price = $_POST['prod_price'];
		$connect -> prod_quantity = 0;
		$connect -> prod_image = $_FILES['prod_img']['name'];

		$checkProd = $connect -> ValidateProduct();
		$validProd = mysqli_num_rows($checkProd);

		if($validProd > 0 ){
			echo '<script>alert("Product is already on the list")</script>';
			echo "<meta http-equiv='refresh' content='0;url=products.php'>";
		}
		else if(empty($_POST['prod_name']) || empty($_POST['prod_price']) || empty($_FILES['prod_img']['name'])){
			echo '<script>alert("Please don\'t leave blank the box")</script>';
			echo "<meta http-equiv='refresh' content='0;url=products.php'>";
		}
		else{

			$insert_product = $connect -> AddProducts();

			if ($insert_product && move_uploaded_file($_FILES['prod_img']['tmp_name'], $target)) {
				echo '<script>alert("Product Successfully Added")</script>';
				echo "<meta http-equiv='refresh' content='0;url=products.php'>";
			}
			else{
				echo '<script>alert("Something is wrong")</script>';
				echo "<meta http-equiv='refresh' content='0;url=products.php'>";
			}
		}
	}


	// For Purchasing Order
	if(isset($_POST['order'])) {

		$id2 = $_POST['prod_id'];

		$connect -> id =  $_POST['prod_id'];
		$connect -> order_qty = $_POST['order_quantity'];
		$connect -> customer_name = $_POST['customer_name'];
		$connect -> customer_address = $_POST['customer_address'];
		$connect -> status = "Pending";
		$connect -> delivery_date = $_POST['delivery_date'];

		$row = $connect -> ViewSingleProduct();
		$check_quantity = mysqli_fetch_assoc($row);
		echo "<pre>";
		var_dump($check_quantity);

		if ($_POST['order_quantity'] > $check_quantity['quantity']) {
			echo '<script>alert("Insufficient Stock")</script>';
			echo "<meta http-equiv='refresh' content='0;url=order.php?prod_id=$id2'>";
		}
		else{

			if(!empty($_POST['order_quantity']) || !empty($_POST['customer_name']) || $_POST['delivery_date']) {

				$purchase = $connect -> Purchase();

				if($purchase){
					echo '<script>alert("Purchase Success")</script>';
					echo "<meta http-equiv='refresh' content='0;url=products.php'>";
				}
				else{
					echo '<script>alert("Something is wrong")</script>';
					echo "<meta http-equiv='refresh' content='0;url=products.php'>";
				}
			}
			else{
					echo '<script>alert("Please complete the information")</script>';
					echo "<meta http-equiv='refresh' content='0;url=order.php?prod_id=$id2'>";
			}
		}

	}

	//**************************************************//
	//*********** FUNCTION IN EXPORTING DATA **********//
	//************************************************//

	// Export Successful Orders Delivered to CSV
	if(isset($_POST['export_success'])){

		header("Content-type: text/csv");
		header('Content-Disposition:attachment;filename="success_orders.csv"');

		$fp = fopen("php://output", 'w');
		fputcsv($fp, array('SUCCESSFUL ORDERS Report'));
		fputcsv($fp, array(''));
		fputcsv($fp, array('Product','Price','Quantity','Total Price','Customer Name','Address','Status','Delivery Date','Confirmed By', 'Date Confirmed'));
		$pendings = $connect -> ViewAllSuccess();
		while ($data = mysqli_fetch_assoc($pendings)){
			fputcsv($fp,
				array(
					$data['prod_name'],
					$data['prod_price'],
					$data['order_qty'],
					$data['total_price'],
					$data['customer_name'],
					$data['customer_address'],
					$data['status'],
					$data['delivery_date'],
					$data['confirmed_by'],
					$data['confirmed_date']
				)
			);
		}

		fclose($fp);
		exit();
	}

	// Export Inventory
	if(isset($_POST['export_inventory'])){

		header("Content-type: text/csv");
		header('Content-Disposition:attachment;filename="inventory.csv"');

		$fp = fopen("php://output", 'w');
		fputcsv($fp, array('INVENTORY Report'));
		fputcsv($fp, array(''));
		fputcsv($fp, array('Product','Price','Quantity Added/Deducted','Status','Confirmed By', 'Date/Time Updated'));
		$pendings = $connect -> ViewInventory();
		while ($data = mysqli_fetch_assoc($pendings)){
			fputcsv($fp,
				array(
					$data['prod_name'],
					$data['prod_price'],
					$data['inv_qty'],
					$data['status'],
					$data['admin_name'],
					$data['date_added']
				)
			);
		}

		fclose($fp);
		exit();
	}

	// Export Sales
	if(isset($_POST['export_sales'])){

		header("Content-type: text/csv");
		header('Content-Disposition:attachment;filename="total_sales.csv"');

		$fp = fopen("php://output", 'w');
		fputcsv($fp, array('SALES Report'));
		fputcsv($fp, array(''));
		fputcsv($fp, array('Product','Price','No. of Remaining Stocks','Total Price of Remaining Stocks','No. of Sold Stocks', 'Total Price of Sold Stocks'));
		$sales = $connect -> ViewSales();
		while($data = mysqli_fetch_assoc($sales)){
			$total_price_of_remaining_stocks = $data['prod_qty'] * $data['prod_price'];
			$total_price_of_sold_stocks = $data['sold_stock'] * $data['prod_price'];
			fputcsv($fp,
				array(
					$data['prod_name'],
					$data['prod_price'],
					$data['prod_qty'] ,
					$data['total_price_remaining_stock'],
					$data['sold_stock'],
					$data['total_price_sold_stock']
				)
			);
		}
		fclose($fp);
		exit();
	}

	// Export Lost
	if(isset($_POST['export_lost'])){

		header("Content-type: text/csv");
		header('Content-Disposition:attachment;filename="lost/damage.csv"');

		$fp = fopen("php://output", 'w');
		fputcsv($fp, array('LOST and DAMAGE Report'));
		fputcsv($fp, array(''));
		fputcsv($fp, array('Product','Price','No. of Remaining Stocks','Total Price of Remaining Stocks','No. of Lost/Damaged Stocks', 'Total Price of Lost/Damaged Stocks'));
		$lost = $connect -> viewAllLost();
		while($data = mysqli_fetch_assoc($lost)){
			fputcsv($fp,
				array(
					$data['prod_name'],
					$data['prod_price'],
					$data['remaining_quantity'] ,
					$data['total_price_remaining'],
					$data['total_lost'],
					$data['total_price_of_lost']
				)
			);
		}
		fclose($fp);
		exit();
	}

?>
