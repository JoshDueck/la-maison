<html>
<title>Logout</title>
<head>
</head>
<body>
<?php
session_start();
session_destroy();

include("includes/head.php");
 echo "<br>";
echo "You have successfully logged out";
echo  "<h4>To log back in: <a href='login.php'>Click Here</a></h4>";


include('includes/footer.html');
?>
</body>
</html>