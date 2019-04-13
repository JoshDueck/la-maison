function validation() {
	//alert ("validating!");
	//return false;
	if (document.getElementById('email').value == '') {
		alert ("Enter your e-mail address");
		/*document.getElementById('password').value = "";*/
		return false;
	}

	if (document.getElementById('password').value == '') {
		alert ("Enter your password");
		return false;
	}

	/* if (document.getElementById('password').value.length < 6) {
		alert("Passwords are at least 6 characters long");
		document.getElementById('password').value = "";
		return false;
	} */
return true;
}