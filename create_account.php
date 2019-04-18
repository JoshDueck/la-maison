<?php 
if (isset($_POST['firstname'])){
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$address = $_POST['address'];
	$city = $_POST['city'];
	$province = $_POST['province'];
	$country = $_POST['country'];
	$postal = $_POST['postal'];
	$customer_email = $_POST['customer_email'];

	// get all the post variables
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
	$customer_policy = $_POST['customer_policy'];
	
	
	include('mysqli_connect.php');
	
	$q = "select customer_email from CUSTOMER where customer_email='$customer_email'";
	$query = mysqli_query($dbc, $q);
	
	// look through query
	$row=mysqli_num_rows($query);
	
	// insert them into the database
	if($row == 0) {
		/* echo "Email is valid, ready to insert"; */
		$query = "insert into CUSTOMER (account_type, customer_fname, customer_lname, customer_country, 
		customer_province, customer_city, customer_address, customer_postal, customer_email, customer_password, customer_policy) 
		values ('user', '$firstname', '$lastname', '$country', '$province', '$city', '$address', '$postal', '$customer_email', md5('$password'), $customer_policy)";
		if (mysqli_query($dbc, $query)){
		/*	echo "inserted successfully"; */
			session_start();
			$_SESSION['customer_fname'] = $_POST['firstname'];
			$_SESSION['customer_lname'] = $_POST['lastname'];
			$_SESSION['customer_address'] = $_POST['address'];
			$_SESSION['customer_city'] = $_POST['city'];
			$_SESSION['customer_province'] = $_POST['province'];
			$_SESSION['customer_country'] = $_POST['country'];
			$_SESSION['customer_postal'] = $_POST['postal'];
			$_SESSION['customer_email'] = $_POST['customer_email'];
			
			// get remaining data
				
			$q2 = "select customer_id, account_type from CUSTOMER where customer_email='$customer_email'";
			$query2 = mysqli_query($dbc, $q2);
			$row2 = mysqli_fetch_array($query2, MYSQLI_NUM);
			$_SESSION['customer_id'] = $row2[0]; // stores id as a session variable
			$_SESSION['account_type'] = $row2[1];
			
			
			header("Location: index.php");
			die();
		}else{
			echo "Error: ".mysqli_error($dbc);
		}
	}
	else {
		//header("Location: index.php");
		//die();
		$email_in_use = true;
	}

}
include('includes/head.php');
/*
					echo '<pre>';
					var_dump($_POST);
					echo '</pre>';
*/
echo "

<link rel=\"stylesheet\" href=\"includes/create_account.css\" type=\"text/css\" media=\"screen\" />";

	if ($email_in_use == true){
		echo "<p>Email is already in use. Try <a href=\"login.php\">logging in.</a></p>";
	}
	
	echo "
	

  <form class=\"modal-content\" action=\"create_account.php\" method=\"POST\" onSubmit=\"return formValidation()\">

	<div class=\"container\">
      <h1>Create Account</h1>
	
      <hr>
	  <label for=\"firstname\"><b>First Name:</b></label>
      <input type=\"text\" placeholder=\"Charles\" class=\"search\" id=\"firstname\" name=\"firstname\" value='$firstname'>
	  
	  <label for=\"lastname\"><b>Last Name:</b></label>
      <input type=\"text\" placeholder=\"Smith\" class=\"search\" id=\"lastname\" name=\"lastname\" value='$lastname'>
	  
	  <label for=\"address\"><b>Street Address:</b></label>
      <input type=\"text\" placeholder=\"78 Lampton Street\" class=\"search\" id=\"address\" name=\"address\" value='$address'>
	  
	  <label for=\"city\"><b>City:</b></label>
      <input type=\"text\" placeholder=\"Victoria\" class=\"search\" id=\"city\" name=\"city\" value='$city'>
	  
	   <label for=\"province\"><b>Province:</b></label>
      <input type=\"text\" placeholder=\"BC\" class=\"search\" id=\"province\" name=\"province\" value='$province'>
	  
	   <label for=\"country\"><b>Country:</b></label>
      <input type=\"text\" placeholder=\"Canada\"  class=\"search\" id=\"country\" name=\"country\" value='$country'>
	  
	   <label for=\"postal\"><b>Postal Code:</b></label>
      <input type=\"text\" placeholder=\"V9K1L3\" class=\"search\" id=\"postal\" name=\"postal\" value='$postal'>
	  
      <label for=\"customer_email\"><b>Email:</b></label>
      <input type=\"text\" placeholder=\"abc@gmail.com\" class=\"search\" id=\"customer_email\" name=\"customer_email\" value='$customer_email'>

      <label for=\"password\"><b>Password:</b></label>
      <input type=\"password\" placeholder=\"password\" class=\"search\" id=\"password\" name=\"password\">

      <label for=\"password-repeat\"><b>Confirm password:</b></label>
      <input type=\"password\" placeholder=\"Re-type password\" class=\"search\" id=\"password_repeat\" name=\"password_repeat\">
	  
	  <input type=\"checkbox\" id=\"customer_policy\" name=\"customer_policy\" value=\"1\" required>To create an account you must agree to the <a href=\"includes/terms.php\">Terms and Conditions</a>
	  
	  <br><input type=\"hidden\" id=\"create_account\" name=\"create_account\" value=\"true\">
	  
	  <button type=\"submit\" class= \"btn\" name=\"submit\" id=\"submit\"> Create Account </button>
	  <br>
	  <button type=\"button\" class=\"cancelbtn\" id=\"cancel\">Cancel</button> 
		<br>
		<br>
		<br>	 
    </div>
  </form>";
	
		
include('includes/footer.html');

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="includes/create_account.js"></script>
</body>
</html>