<?php


if(isset($_POST['customer_email'])){ // user came from login page
	session_start();
	
	//$_SESSION['sessionHello']="hello world"; ---------------------------------- DEBUGGING STATEMENT
	//$_SESSION['customer_country']=$row['customer_country']; ------------------- DEBUGGING STATEMENT
	
	if (isset($_SESSION['customer_email'])) {
		include("mysqli_connect.php"); // $dbc connection set
		$username = $_SESSION['customer_email']; // Change to get first and last name from database
		
		if ($_POST['accept'] == true) {
			// Query for updating terms and conditions
			$acceptedterms = "UPDATE CUSTOMER set customer_policy=true WHERE customer_id =".$_SESSION['customer_id'].";";
			// Updating that the user has accepted terms and conditions
			$result = mysqli_query($dbc, $acceptedterms);
		}
		
	}
	else {
		if (isset($_POST['customer_email'])) {
			$username = $_POST['customer_email']; // Checking 
			$password = $_POST['password'];
			include('mysqli_connect.php');
			
			$query = "SELECT * from CUSTOMER WHERE customer_email='$username' AND customer_password = md5('$password');";
			$row = @mysqli_query ($dbc, $query);
			
			if (mysqli_num_rows($row) == 1) { // customer used valid credentials
				$prod_row=mysqli_fetch_array($row, MYSQLI_ASSOC);
				
				$_SESSION['customer_email']=$username;
				$_SESSION['customer_id']=$prod_row['customer_id'];
				$_SESSION['account_type']=$prod_row['account_type'];
				$_SESSION['customer_fname']=$prod_row['customer_fname'];
				$_SESSION['customer_lname']=$prod_row['customer_lname'];
				$_SESSION['customer_country']=$prod_row['customer_country'];
				$_SESSION['customer_province']=$prod_row['customer_province'];
				$_SESSION['customer_city']=$prod_row['customer_city'];
				$_SESSION['customer_address']=$prod_row['customer_address'];
				$_SESSION['customer_postal']=$prod_row['customer_postal'];
				$_SESSION['customer_policy']=$prod_row['customer_policy'];
				/* $_SESSION['current_login_time']=date('Y/m/d G:i'); */
				
				if ($_SESSION['customer_policy'] == 0) { // checking if they've accepted terms and conditions
				?>
				<!-- The Modal -->
				<div id="myModal" class="modal">

				  <!-- Modal content -->
				  <div class="modal-content">
					<span class="close" action="login.php">&times;</span>
					
					<p>
					<div class="scrollBox">
					<p>
					<?php include('includes/terms.html'); ?>
					</p>
					</div>
						<br>
						
						<form method="POST" action="login.php" class="formbutton" enctype="multipart/form-data">
						<button type="submit" name="decline" id="decline">I do not accept</button></form>
						
						<form method="POST" action="index.php" class="formbutton" enctype="multipart/form-data">
						<button type="submit" name="accept" id="accept" value="true">I accept</button></form>

					</p>
					<br><br>
				  </div>
				</div>
				<?php
				} // closing bracket for checking if they've accepted terms and conditions

				
				
				/* echo "You have logged in successfully";
				echo "The session id is...: ".session_id(); 
					echo '<pre>';
					var_dump($_SESSION);
					echo '</pre>'; */
			} else { // Not a match!
				echo '<script language="javascript">';
				echo 'alert("Your email/password is incorret");';
				echo 'window.location.replace("login.php")';
				echo '</script>';
				/*echo  "<h4>Invalid login credentials. Please <a href='login.php'>TRY AGAIN</a></h4>";*/
			}
			
		}
		else{
			/* echo "Not logged in"; */
		}
	}
}


/*if ($_SESSION['customer_policy'] == 0) { // checking if they've accepted terms and conditions --------------------------------------
?>
<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <p><?php include('includes/terms.php'); 
	echo "<form method=\"POST\" action=\"index.php\" enctype=\"multipart/form-data\">
	<input type=\"hidden\" id=\"accept\" name=\"accept\" value=\"true\">
	<button type=\"submit\" name=\"accept\" id=\"accept\">I accept</button></form>"; // Accept button
	
	echo "<form method=\"POST\" action=\"index.php\" enctype=\"multipart/form-data\">
	<input type=\"hidden\" id=\"decline\" name=\"decline\" value=\"true\">
	<button type=\"submit\" name=\"decline\" id=\"decline\">I do not accept</button></form>"; // Decline button
	
	?></p>
  </div>

</div>
<?php
} // closing bracket for checking if they've accepted terms and conditions


if ($_POST['accept']) {
	// Query for updating terms and conditions
	$acceptedterms = "UPDATE CUSTOMER set customer_policy=true WHERE CUSTOMER_customer_id =".$_SESSION['customer_id'].";";
	// Updating that the user has accepted terms and conditions
	$result = mysqli_query($dbc, $acceptedterms);
}
*/																								//----------------------------------------
?>
<html>
<link rel="stylesheet" href="includes/products_display.css" type="text/css" media="screen" />
<link rel="stylesheet" href="includes/index.css" type="text/css" media="screen" />
<head>
</head><body>

<?php
include("includes/head.php"); // inserts header at the top

/***** display all products regardless of where the user came from *****/

// connect to database
include("mysqli_connect.php"); // connection string is $dbc


$category_name = $_GET['category_name'];

if ($category_name == null){
	// run a query to display all products
	$all_prod_query = 
	"SELECT product_image, product_name, product_price, product_id
	FROM PRODUCT";
	$prod_rows = mysqli_query($dbc, $all_prod_query);

	echo "<br>
		<br>
		<table>
			<tr class=\"jump\">";

	// all products loop

	while($prod_row=mysqli_fetch_array($prod_rows, MYSQLI_ASSOC)){
		echo "<td class=\"shadow\">
				<a href=\"http://deepblue.cs.camosun.bc.ca/~ics19901/product_details.php?product_id=".$prod_row['product_id']."\">
				<img src=\"".$prod_row['product_image']."\"  class=\"img\" />
				</a>
				<h4 class=\"text\"><i>".$prod_row['product_name']."</i></h4>
				<h4 class=\"text\"><i>\$".$prod_row['product_price']."</i></h4>
				
		</td>
	";
	}
	echo "</tr>
		</table>
		<br>
		<br>";

	mysqli_close($dbc);
}

/***** end of displaying all products *****/




include("includes/footer.html");
?>

<script src="includes/index.js"></script>
</body>
</html>