<?php

class Model{

	public function Model($db){
		$this->connect = $db;
	}

	// Create User
	public function CreateUser(){

		$fname = $this-> fname;
		$lname = $this-> lname;
		$email = $this-> email;
		$username = $this-> username;
		$password = $this-> password;
		$profile_img = $this -> profile_img;


		$sql = "INSERT INTO users (fname,lname,email,username,password,image) VALUES ('$fname','$lname','$email','$username','$password','$profile_img')" or die(mysqli_error());
		$query = $this-> connect -> query($sql);

		if($query){
			return TRUE;
		}
		else{
			return FALSE;
		}

	}

	//****************************************//
	//*** VALIDATION ON CREATING NEW USER ***//
	//**************************************//

	public function CheckUserName(){

		$uname = $this-> username;

		$sql = "SELECT * FROM users WHERE username = '$uname'" or die(mysql_error());
		$query = $this -> connect -> query($sql);

		if($query){
			return $query;
		}
		else{
			return FALSE;
		}
	}

	public function CheckEmail(){

		$email = $this-> email;

		$sql = "SELECT * FROM users WHERE email = '$email'" or die(mysql_error());
		$query = $this -> connect -> query($sql);

		if($query){
			return $query;
		}
		else{
			return FALSE;
		}

	}

	//***********************************************//
	//*** END OF VALIDATION ON CREATING NEW USER ***//
	//*********************************************//

	// Login
	public function Login(){

		$uname = $this -> uname;
		$pwd = $this -> pwd;

		$sql = "SELECT * FROM users WHERE username = '$uname' && password = '$pwd'" or die(mysqli_error());
		$query = $this -> connect -> query($sql);

		if($query){
			return $query;
		}
		else{
			return FALSE;
		}

	}

	//***********************************************//
	//*** ADDING PRODUCTS **************************//
	//*********************************************//

	public function AddProducts(){

		$prod_name = $this -> prod_name;
		$prod_price = $this -> prod_price;
		$prod_quantity = $this -> prod_quantity;
		$image = $this -> prod_image;

		$sql = "INSERT INTO products (prod_name,prod_price,quantity,image) VALUES ('$prod_name','$prod_price','$prod_quantity','$image')" or die(mysqli_error());
		$query = $this -> connect -> query($sql);

		if($query){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

	//***********************************************//
	//*** VALIDATION ON ADDING PRODUCTS ************//
	//*********************************************//

	public function ValidateProduct(){

		$name = $this -> prod_name;

		$sql = "SELECT * FROM products WHERE prod_name = '$name'"or die(mysqli_error());
		$query = $this -> connect -> query($sql);

		if ($query) {
			return $query;
		}
		else{
			return FALSE;
		}

	}


	//*****************************************//
	//*** VIEW ALL PRODUCTS ******************//
	//***************************************//

	public function ViewAllProducts(){

		$sql = "SELECT * FROM products" or die(mysqli_error());
		$query = $this -> connect -> query($sql);

		if ($query) {
			return $query;
		}
		else{
			return FALSE;
		}
	}

	//*****************************************//
	//*** VIEW SPECIFIC PRODUCTS *************//
	//***************************************//

	public function ViewSingleProduct(){

		$id = $this -> id;

		$sql = "SELECT * FROM products WHERE prod_id = '$id'" or die(mysqli_error());
		$query = $this -> connect -> query($sql);

		if ($query) {
			return $query;
		}
		else{
			return FALSE;
		}

	}

	//****************************************************//
	//*** UPDATE TOTAL QUANTITY OF A SPECIFIC PRODUCT ***//
	//**************************************************//

	public function UpdateProductQuantity(){
		$id = $this -> id;
		$new = $this -> new_quantity;

		$sql = "UPDATE products SET quantity = '$new' WHERE prod_id = '$id'" or die(mysqli_error());
		$query = $this -> connect -> query($sql);

		if($query){
			return $query;
		}
		else{
			return FALSE;
		}
	}


	//******************************************//
	//*** UPDATE INFO OF A SPECIFIC PRODUCT ***//
	//****************************************//

	// Image is also update
	public function UpdateProductInfo(){
		$id = $this -> id;
		$new_name = $this -> new_name;
		$new_price = $this -> new_price;
		$new_img = $this -> new_img;

		$sql = "UPDATE products SET prod_name = '$new_name', prod_price = '$new_price', image = '$new_img' WHERE prod_id = '$id'" or die(mysqli_error());
		$query = $this -> connect -> query($sql);

		if($query){
			return $query;
		}
		else{
			return FALSE;
		}
	}

	// Image is not updated
	public function UpdateProductInfoNoImg(){
		$id = $this -> id;
		$new_name = $this -> new_name;
		$new_price = $this -> new_price;

		$sql = "UPDATE products SET prod_name = '$new_name', prod_price = '$new_price' WHERE prod_id = '$id'" or die(mysqli_error());
		$query = $this -> connect -> query($sql);

		if($query){
			return $query;
		}
		else{
			return FALSE;
		}
	}


	//******************************************//
	//*** ADD PRODUCT TO INVENTORY ************//
	//****************************************//

	public function AddToInventory(){

		$id = $this -> id;
		$quantity = $this -> quantity;
		$status = $this-> status;
		$fullname = $this -> fullname;
		$date = $this -> date_added;

		$sql = "INSERT INTO inventory (prod_id,quantity,status,admin_name,date_added) VALUES ('$id','$quantity','$status', '$fullname', '$date')" or die(mysqli_error());
		$query = $this -> connect -> query($sql);

		if ($query){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

	//******************************************//
	//*** DEDUCT PRODUCT TO INVENTORY ************//
	//****************************************//

	public function DeductToInventory(){

		$id = $this -> prod_id;
		$quantity = $this -> quantity;
		$status = $this-> status;
		$fullname = $this -> fullname;
		$date = $this -> date_added;

		$sql = "INSERT INTO inventory (prod_id,quantity,status,admin_name,date_added) VALUES ('$id','$quantity','$status', '$fullname', '$date')" or die(mysqli_error());
		$query = $this -> connect -> query($sql);

		if ($query){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}


	//******************************************//
	//*** VIEW INVENTORY **********************//
	//****************************************//

	public function ViewInventory(){

		$sql =
		"
		SELECT * , inventory.quantity as inv_qty FROM inventory
		LEFT JOIN products ON products.prod_id = inventory.prod_id
		"
		or die(mysqli_error());
		$query = $this -> connect -> query($sql);

		if ($query){
			return $query;
		}
		else{
			return FALSE;
		}
	}

	//******************************************//
	//*** SEARCH INVENTORY DATE ***************//
	//****************************************//

	public function SearchInventoryDate(){

		$date = $this -> date;

		$sql =
		"
		SELECT * , inventory.quantity as inv_qty FROM inventory
		LEFT JOIN products ON products.prod_id = inventory.prod_id
		WHERE date_added LIKE '%'.'$date'.'%'
		"
		or die(mysqli_error());
		$query = $this -> connect -> query($sql);

		if ($query){
			return $query;
		}
		else{
			return FALSE;
		}
	}


	//******************************************//
	//*** PURCHASE ORDER **********************//
	//****************************************//

	public function Purchase(){

		$id = $this -> id;
		$order_qty = $this -> order_qty;
		$customer_name = $this -> customer_name;
		$customer_address = $this -> customer_address;
		$status = $this -> status;
		$delivery_date = $this -> delivery_date;

		$sql = "INSERT INTO orders (prod_id,order_qty,customer_name,customer_address,status,delivery_date) VALUES ('$id','$order_qty','$customer_name','$customer_address','$status','$delivery_date') " or die(mysqli_error());
		$query = $this -> connect -> query($sql);

		if($query){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}


	//******************************************//
	//*** VIEW ALL PENDING ORDERS *************//
	//****************************************//

	public function ViewAllPendings(){

		$sql = "SELECT * FROM orders
		LEFT JOIN products ON products.prod_id = orders.prod_id
		WHERE status = 'Pending'" or die(mysqli_error());
		$query = $this -> connect -> query($sql);

		if($query){
			return $query;
		}
		else{
			return FALSE;
		}
	}

	//******************************************//
	//*** VIEW ALL SUCCESSFUL ORDERS **********//
	//****************************************//

	public function ViewAllSuccess(){

		$sql = "SELECT * , prod_price * order_qty as total_price FROM orders
		LEFT JOIN products ON products.prod_id = orders.prod_id
		WHERE status = 'Delivered'" or die(mysqli_error());
		$query = $this -> connect -> query($sql);

		if($query){
			return $query;
		}
		else{
			return FALSE;
		}
	}


	//******************************************//
	//*** SUM ALL SUCCESSFUL ORDERS ***********//
	//****************************************//

	public function TotalSales(){

		$sql = "SELECT * , sum(prod_price * order_qty) as total_sales FROM orders
		LEFT JOIN products ON products.prod_id = orders.prod_id
		WHERE status = 'Delivered'" or die(mysqli_error());
		$query = $this -> connect -> query($sql);

		if($query){
			return $query;
		}
		else{
			return FALSE;
		}
	}


	//******************************************//
	//*** VIEW ALL CANCELLED ORDERS ***********//
	//****************************************//

	public function ViewAllCancelled(){

		$sql = "SELECT * FROM orders
		LEFT JOIN products ON products.prod_id = orders.prod_id
		WHERE status = 'Cancelled'" or die(mysqli_error());
		$query = $this -> connect -> query($sql);

		if($query){
			return $query;
		}
		else{
			return FALSE;
		}
	}


	//*****************************************//
	//*** VIEW SPECIFIC PRODUCT TO CONFIRM ***//
	//***************************************//

	public function ViewProductToConfirm(){

		$id = $this -> id;

		$sql = "SELECT * FROM orders
		LEFT JOIN  products ON products.prod_id = orders.prod_id
		WHERE order_id = '$id'" or die(mysqli_error());
		$query = $this -> connect -> query($sql);

		if ($query) {
			return $query;
		}
		else{
			return FALSE;
		}

	}


	//*****************************************//
	//*** CONFIRM ORDER **********************//
	//***************************************//

	public function ConfirmOrder(){

		$id = $this -> id;
		$order_qty = $this -> order_qty;
		$name = $this -> name;
		$status = $this -> status;
		$delivery_date = $this-> delivery_date;
		$admin = $this -> admin;
		$confirmed_date = $this -> confirmed_date;

		$sql = "UPDATE orders SET order_qty = '$order_qty', customer_name = '$name', status = '$status', delivery_date = '$delivery_date', confirmed_by = '$admin', confirmed_date = '$confirmed_date' WHERE order_id = '$id'" or die(mysqli_error());
		$query = $this -> connect -> query($sql);

		if($query){
			return $query;
		}
		else{
			return FALSE;
		}
	}


	//*****************************************//
	//*** VIEW SALES *************************//
	//***************************************//

	public function ViewSales(){

		$sql =
		"
		SELECT *, products.quantity as prod_qty, sum(inventory.quantity) as sold_stock,
		products.quantity * products.prod_price as total_price_remaining_stock,
		sum(inventory.quantity * products.prod_price) as total_price_sold_stock
		FROM products
		LEFT JOIN inventory ON inventory.prod_id = products.prod_id
		WHERE inventory.status = 'Deduct Stocks'
		GROUP BY inventory.prod_id
		"
		or die(mysqli_error());
		$query = $this -> connect -> query($sql);

		if ($query){
			return $query;
		}
		else{
			return FALSE;
		}

	}

	// INSERT TO LOST/DAMAGE TABLE
	public function addLostDamage(){
		$id = $this-> id;
		$no_of_lost = $this-> no_of_lost;
		$type = $this-> type;

		$sql = "INSERT INTO lost_damage (prod_id,no_of_lost,type) VALUES ('$id','$no_of_lost','$type')" or die(mysqli_error());
		$query = $this-> connect -> query($sql);

		if($query){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

	// VIEW ALL LOST/DAMAGE PRODUCTS
	public function viewAllLost(){
		$sql = "SELECT *, products.quantity as remaining_quantity, products.quantity * products.prod_price as total_price_remaining, sum(lost_damage.no_of_lost) as total_lost,
			sum(lost_damage.no_of_lost) * products.prod_price as total_price_of_lost
			FROM lost_damage
		LEFT JOIN products ON lost_damage.prod_id = products.prod_id
		GROUP BY lost_damage.prod_id" or die(mysqli_error());
		$query = $this-> connect -> query($sql);

		if($query){
			return $query;
		}
		else{
			return FALSE;
		}
	}

}

?>
