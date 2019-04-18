<html>
<link rel="stylesheet" href="includes/logout.css" type="text/css" media="screen" />
<title>Logout</title>
<head>
</head>
<body>
 <div id = "page-container">
	<div id = "content-wrap">
<?php
session_start();

//stores last login in database
/* if (isset($_SESSION['current_login_time'])){ */
	include("mysqli_connect.php"); // $dbc connection set

	$updateTimeStamp = "UPDATE CUSTOMER set customer_logintime =current_timestamp() WHERE customer_id =".$_SESSION['customer_id'].";";
	if ($result = mysqli_query($dbc, $updateTimeStamp)){
		/* echo "login time saved to database"; */
	}else {
	echo "<p>The attempted query is: ".$updateTimeStamp."</p>";
		echo "Error: ".mysqli_error($dbc);
		$desc = "desc CUSTOMER";
		echo "Fields are: ".mysqli_query($dbc, $updateTimeStamp);
	}

	mysqli_close($dbc);
/* } */


if (isset($_POST['declined_terms'])){
	include("mysqli_connect.php"); // $dbc connection set
	
	$updateTerms = "UPDATE CUSTOMER set customer_policy=false WHERE customer_id =".$_SESSION['customer_id'].";";
	
	if ($result = mysqli_query($dbc, $updateTerms)){
		$disabled = true;
	} else{
		echo "Error: ".mysqli_error($dbc);
		$disabled = true;
	}

	mysqli_close($dbc);
}



session_destroy();

include("includes/head.php");
 echo "<br>";
echo "<h1 align = 'center'>You have successfully logged out</h1><br>";
echo  "<h2 align = 'center'>To log back in: <a href='login.php'>Click Here</a></h2>";
if ($disabled){
	echo "<p>Your account has been successfully disabled. If you wish to enable it, accept the terms and conditions after logging in</p>";
} else{
	echo "<p>There has been a problem while disabling your account. Please contact us via the email: lamaison.homeinterior@gmail.com</p>";
}
?>
</div>
<footer id="footer">
<?php
include("includes/footer.html");
?>
</div>
</body>
</html>