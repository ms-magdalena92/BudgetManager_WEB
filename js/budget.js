function showPassword() {
	
	var password1 = document.getElementById("password1");
	var passwor2 = document.getElementById("password2");
	if (password1.type === "password") {
		password1.type = "text";
		password2.type = "text";
	}
	else {
		password1.type = "password";
		password2.type = "password";
	}
}

function getCurrentDate() {
	
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