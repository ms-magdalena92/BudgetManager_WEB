function showPassword()
{
  var password = document.getElementById("passwordInput");
  if (password.type === "password") {
	password.type = "text";
  }
  else {
	password.type = "password";
  }
}