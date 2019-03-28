
/*validation*/

$("#submit").on("click", function(){
	
	var $postal = $("#postal").val();
	var $postalRe = /^[a-zA-Z][0-9][a-zA-Z][\s]?[0-9][a-zA-Z][0-9]$/;
	var $email = $("#customer_email").val();
	var $emailRe = /^\S+@\S+\.\S+[\.]?[\S]*$/;
	var $psw = $("#password").val();
	var $psw_rep = $("#password-repeat").val();
	
		/*Postal*/
	if ($postalRe.test($postal) == false) {

		alert ("Error: Provide your postal code in valid format");
		$("#postal").focus();
		}
		
		/*Email*/
	if ($emailRe.test($email) == false) {

		alert("Error: Email couldn't be verified");
		$("#customer_email").focus();
		}
		
		/*Password*/
	if (psw.length == 0 || psw == null || psw < 7) {

		alert("Error: Enter a password of at least 6 digits");
		$("#password").focus();
	}
	if (psw_rep.length == 0 || psw_rep == null || psw_rep < 7) {

		alert("Error: Enter a password of at least 6 digits");
		$("#password").focus();
	}
		
		/*Password Repeat*/
	if ($psw != $psw_rep) {
		alert("Error: Passwords don't match");
		$("#password_repeat").focus();
	}

}); // end of submit function

