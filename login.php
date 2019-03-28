<html>
<head>
<title>Log In</title>
<link rel="stylesheet" href="includes/login.css" type="text/css" media="screen" />
</head>
<body >
<?php 

include("includes/head.php");

?>
<form action="index.php" method="POST" onsubmit="return validation();">

  <div class="container"> <br>
  <h2 align="center">Log In</h2>
  <br>
	
    <label for="email"><b>Email:</b></label>
    <input type="text" placeholder="Enter Email" id="email" name="customer_email" required>
	<br>
	<br>
    <label for="password"><b>Password:</b></label>
    <input type="password" placeholder="Enter Password" id="password" name="password" required>
     <br>  
	 <br>
    <button type="submit">Log In</button>
	<br>
	<br>
	<br>
	<p>Not already a member?
	<a href="create_account.php">Click here to create an account.</a>
	</p>
	</div>
</form>

<?php

include('includes/footer.html');
?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="includes/login.js"></script>
</body>
</html>