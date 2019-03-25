<html>
<link rel="stylesheet" href="includes/create account.css" type="text/css" media="screen" />
<body class="bg">
  <form class="modal-content" action="/action_page.php">
    <div class="container">
      <h1>Create Account</h1>
     
      <hr>
	  <label for="firstname"><b>First Name:</b></label>
      <input type="text" placeholder="Charles" name="first name" required>
	  
	  <label for="lastname"><b>Last Name:</b></label>
      <input type="text" placeholder="Smith" name="lastname" required>
	  
	  <label for="streer"><b>Street Address:</b></label>
      <input type="text" placeholder="78 Lampton Street" name="street address" required>
	  
	  <label for="city"><b>City:</b></label>
      <input type="text" placeholder="Victoria" name="city" required>
	  
	   <label for="province"><b>Province:</b></label>
      <input type="text" placeholder="BC" name="province" required>
	  
	   <label for="country"><b>Country:</b></label>
      <input type="text" placeholder="Canada" name="country" required>
	  
	   <label for="postal"><b>Postal Code:</b></label>
      <input type="text" placeholder="V9K1L3" name="postal" required>
	  
      <label for="email"><b>Email:</b></label>
      <input type="text" placeholder="abc@gmail.com" name="email" required>

      <label for="psw"><b>Password:</b></label>
      <input type="password" placeholder="Password" name="psw" required>

      <label for="psw-repeat"><b>Re-type Password:</b></label>
      <input type="password" placeholder="Re-type Password" name="psw-repeat" required>
      <br>
	  <br>
	      <button type="submit">Create Account</button>
	<br>
	<br>
    <label>
      <input type="checkbox" checked="checked" name="remember"> Remember me
    </label>
	<br>
	<br>
	<button type="button" class="cancelbtn">Cancel</button> 
<br>
<br>
<br>	 
    </div>
  </form>
</body>
</html>