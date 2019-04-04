<html>
<link rel="stylesheet" href="includes/create_account.css" type="text/css" media="screen" />
<body class="bckg">
<?php 
include('includes/head.php');
?>
  <form class="modal-content" action="index.php" method="POST">

	<div class="container">
      <h1>Create Account</h1>
     
      <hr>
	  <label for="firstname"><b>First Name:</b></label>
      <input type="text" placeholder="Charles" class="search" id="firstname" name="firstname" required>
	  
	  <label for="lastname"><b>Last Name:</b></label>
      <input type="text" placeholder="Smith" class="search" name="lastname" required>
	  
	  <label for="streer"><b>Street Address:</b></label>
      <input type="text" placeholder="78 Lampton Street" class="search" name="address" required>
	  
	  <label for="city"><b>City:</b></label>
      <input type="text" placeholder="Victoria" class="search" name="city" required>
	  
	   <label for="province"><b>Province:</b></label>
      <input type="text" placeholder="BC" class="search" name="province" required>
	  
	   <label for="country"><b>Country:</b></label>
      <input type="text" placeholder="Canada"  class="search"name="country" required>
	  
	   <label for="postal"><b>Postal Code:</b></label>
      <input type="text" placeholder="V9K1L3" class="search" id="postal" name="postal" required>
	  
      <label for="customer_email"><b>Email:</b></label>
      <input type="text" placeholder="abc@gmail.com" class="search" id="customer_email" name="customer_email" required>

      <label for="password"><b>Password:</b></label>
      <input type="password" placeholder="password" class="search" id="password" name="password" required>

      <label for="password-repeat"><b>Confirm password:</b></label>
      <input type="password" placeholder="Re-type password" class="search" id="password_repeat" name="password_repeat" required>
      <br>
	  <br><input type="hidden" id="create_account" name="create_account" value="true">
	      <button type="submit" class= "btn" name="submit" id="submit"> Create Account </button>
		 
	<br>
	<br>
	<button type="button" class="cancelbtn" id="cancel">Cancel</button> 
	<br>
	<br>
		<p><input type="checkbox" id="customer_policy" name="customer_policy" value="1" required>To create an account you must agree to the <a href="includes/terms.php">Terms and Conditions</a></p>
<br>	 
    </div>
  </form>

<?php

include("mysqli_connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$address = $_POST['address'];
		$city = $_POST['city'];
		$province = $_POST['province'];
		$country = $_POST['country'];
		$postal = $_POST['postal'];
		$customer_email = $_POST['customer_email'];
		$password = $_POST['password'];
		$password_repeat = $_POST['password_repeat'];
//checking email

		
		$q = "select customer_email from CUSTOMER where customer_email='$customer_email'";
		
		
		
		$array = array();
		
		// look through query
		$row = mysqli_fetch_array($query, MYSQLI_NUM);
		
		
		if(empty($row)) {
						
			$query = "insert into CUSTOMER (account_type, customer_fname, customer_lname, customer_country, 
			customer_province, customer_city, customer_address, customer_postal, customer_email, customer_password) 
			values ('user', '$firstname', '$lastname', '$country', '$province', '$city', '$address', '$postal', '$customer_email', md5('$password'))";
			mysqli_query($dbc, $query);
			 
		}
		else {
			echo "Email is already in use";
		}
}
include('includes/footer.html');

?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="includes/create_account.js"></script>
</body>
</html>