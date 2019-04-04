// Get the modal
var modal = document.getElementById('myModal');

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  window.location.href = 'login.php';
}

function exitbutton() {
	window.location.href = 'login.php';
}
// When the user clicks anywhere outside of the modal, close it, unsure if we want this functionality
/*window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
} */