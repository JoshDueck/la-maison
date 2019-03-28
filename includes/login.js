function validation() {
	//alert ("validating!");
	//return false;
	if (document.getElementById('email').value == '') {
		alert ("you must include an email address");
		document.getElementById('password').value = "";
		return false;
	}

	if (document.getElementById('password').value == '') {
		alert ("You must include a password");
		return false;
	}
	if (document.getElementById('password').value.length < 6) {
		alert("Passwords are at least 6 characters long");
		document.getElementById('password').value = "";
		return false;
	}
return true;
}