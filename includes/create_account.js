
function formValidation() {
	
	var $firstname = $("#firstname").val();
	var $firstnameRe = /[a-zA-Z]$/;
	var $lastname = $("#lastname").val();
	var $lastnameRe= /[a-zA-Z]$/;
	var $address = $("#address").val();
	var $addressRe = /[a-zA-Z0-9]$/;
	var $city = $("#city").val();
	var $cityRe = /[a-zA-Z]$/;
	var $province = $("#province").val();
	var $provinceRe = /[a-zA-Z]$/;
	var $country = $("#country").val();
	var $countryRe = /[a-zA-Z]$/;
	var $postal = $("#postal").val();
	var $postalRe = /^[a-zA-Z][0-9][a-zA-Z][\s]?[0-9][a-zA-Z][0-9]$/;
	var $email = $("#customer_email").val();
	var $emailRe = /^\w{1,}.?\w{1,}@[a-zA-]{2,}.?[a-zA-Z]{2,}$/;
	var $password = $("#password").val();
	var $password_repeat = $("#password_repeat").val();
	
		/* first name */
	if ($firstnameRe.test($firstname) == false) {

		alert ("Please enter your first name by using alphabetical letters.");
		$("#firstname").focus();
		return false;
	}
		
		/* last name */
	if ($lastnameRe.test($lastname) == false) {

		alert ("Please enter your last name by using alphabetical letters");
		$("#lastname").focus();
		return false;
	}
		
		/* address */
	if ($addressRe.test($address) == false) {

		alert ("Please enter your address");
		$("#address").focus();
		return false;
	}

		/* city */
	if ($cityRe.test($city) == false) {

		alert ("Please enter your city");
		$("#city").focus();
		return false;
	}
		/* province */
	if ($provinceRe.test($province) == false) {

		alert ("Please enter your province");
		$("#province").focus();
		return false;
	}
		/* country */
	if ($countryRe.test($country) == false) {

		alert ("Please enter your country");
		$("#country").focus();
		return false;
	}
		/*Postal*/
	if ($postalRe.test($postal) == false) {

		alert ("Please enter your postal code in valid format");
		$("#postal").focus();
		return false;
	}
		
		/*Email*/
	if ($emailRe.test($email) == false) {

		alert("Please enter your email address");
		$("#customer_email").focus();
		return false;
	}
		
		/*Password*/
	if ($password.length < 6) {

		alert("Please enter your password");
		$("#password").focus();
		return false;
	}
	if ($password_repeat.length < 6) {

		alert("Please type your password again");
		$("#password_repeat").focus();
		return false;
	}
		
		/*Password Repeat*/
	if ($password != $password_repeat) {
		alert("Error: Passwords don't match");
		/* $("#password_repeat").focus(); */
		return false;
	}
	
	
}; // end of submit function

