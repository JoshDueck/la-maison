<html>
<title>Logout</title>
<head>
</head>
<body>
<?php
session_start();

//stores last login in database
if (isset($_SESSION['current_login_time'])){
	include("mysqli_connect.php"); // $dbc connection set

	$updateTimeStamp = "UPDATE CUSTOMER set customer_logintime='".$_SESSION['current_login_time']."' WHERE customer_id =".$_SESSION['customer_id'].";";
	if ($result = mysqli_query($dbc, $updateTimeStamp)){
		echo "login time saved to database";
	}else {
	echo "<p>The attempted query is: ".$updateTimeStamp."</p>";
		echo "Error: ".mysqli_error($dbc);
		$desc = "desc CUSTOMER";
		echo "Fields are: ".mysqli_query($dbc, $updateTimeStamp);
	}
}


if (isset($_POST['declined_terms'])){
	include("mysqli_connect.php"); // $dbc connection set
	
	$updateTerms = "UPDATE CUSTOMER set customer_policy=false WHERE customer_id =".$_SESSION['customer_id'].";";
	
	if ($result = mysqli_query($dbc, $updateTerms)){
		$disabled = true;
	} else{
		echo "Error: ".mysqli_error($dbc);
		$disabled = true;
	}
}



session_destroy();

include("includes/head.php");
 echo "<br>";
echo "You have successfully logged out";
echo  "<h4>To log back in: <a href='login.php'>Click Here</a></h4>";
if ($disabled){
	echo "<p>Your account has been successfully disabled. If you wish to enable it, accept the terms and conditions after logging in</p>";
} else{
	echo "<p>There has been a problem while disabling your account. Please contact us via the email: lamaison.homeinterior@gmail.com</p>";
}

include('includes/footer.html');
?>
</body>
</html>