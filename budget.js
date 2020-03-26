function showPassword()
{
	 var password = document.getElementById("passwordInput");
	 if (password.type === "password")
		password.type = "text";
	 else
		password.type = "password";
}

function getCurrentDate()
{
	var date = new Date();

	var day = date.getDate();
	var month = date.getMonth() + 1;
	var year = date.getFullYear();

	if (month < 10)
		month = "0" + month;
	if (day < 10)
		day = "0" + day;

	var today = year + "-" + month + "-" + day;       
	document.getElementById("dateInput").value = today;
}