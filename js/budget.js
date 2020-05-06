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

function generateExampleTables() {
	
	var incomeCategories = ["salary", "allegro", "bank interest"];
	var expenseCategories = ["food", "house", "transport"];

	var incomes = [{amount: 4500, date: "2019-03-11", category: "salary", comment: "-"}, {amount: 100, date: "2019-03-09", category: "allegro", comment: "shoes"}, {amount: 200, date: "2019-03-02", category: "allegro", comment: "-"}, {amount: 200, date: "2019-03-01", category: "allegro", comment: "-"}, {amount: 50, date: "2019-03-15", category: "bank interest", comment: "investment"}];

	var expenses = [{amount: 354, payment: "cash", date: "2019-03-01", category: "food", comment: "-"}, {amount: 655, payment: "debit card", date: "2019-03-08", category: "house", comment: "rent"}, {amount: 150, payment: "cash", date: "2019-03-05", category: "transport", comment: "-"}, {amount: 200, payment: "cash", date: "2019-03-29", category: "food", comment: "-"}];

	var incomesSummaryArray = [];
	var expensesSummaryArray = [];
	var totalIncomes = 0;
	var totalExpenses = 0;

	function compareDates(a, b) {
		let comparison = 0;
		if (a.date > b.date){
			comparison = 1;
		} else if (a.date < b.date) {
			comparison = -1;
		}
		return comparison;
	}

	incomes.sort(compareDates);
	expenses.sort(compareDates);

	function compareSum(a, b) {
		return (a.sum - b.sum)*(-1);
	}

	function generateSummaryArray(categories, finances, name) {
		var sumOfSingleCategory = 0;
		
		for(var y = 0; y < categories.length; y++) {
			sumOfSingleCategory = 0;
			for(var i = 0; i < finances.length; i++) {
				if(finances[i].category === categories[y])
					sumOfSingleCategory += finances[i].amount;
			}
			if(name === "Incomes") {
				totalIncomes += sumOfSingleCategory;
				incomesSummaryArray.push({category: categories[y], sum: sumOfSingleCategory});
			}
			else {
				totalExpenses += sumOfSingleCategory;
				expensesSummaryArray.push({category: categories[y], sum: sumOfSingleCategory});
			}
		}
		generateTable(name);
	}

	function generateTable(tableName) {
		var tableRows = "";

		if(tableName === "Incomes") {
			incomesSummaryArray.sort(compareSum);
			for(var i = 0; i < incomesSummaryArray.length; i++) {
				tableRows += "<tr class=\"summary\"><td class=\"category\">" + incomesSummaryArray[i].category + "</td><td class=\"sum\">" + incomesSummaryArray[i].sum + " PLN</td></tr>";
				for(var y = 0; y < incomes.length; y++){
					if(incomes[y].category === incomesSummaryArray[i].category)
						tableRows += "<tr><td class=\"date\">" + incomes[y].date + "</td><td class=\"amount\">" + incomes[y].amount + " PLN</td><td class=\"comment\">" + incomes[y].comment + "</td></tr>";
				}
			}
			tableRows += "<tr class=\"summary\"><td class=\"total\">TOTAL</td><td class=\"sum\">" + totalIncomes + " PLN</td></tr>";
		}
		
		else {
			for(var i = 0; i < expensesSummaryArray.length; i++) {
				expensesSummaryArray.sort(compareSum);
				tableRows += "<tr class=\"summary\"><td class=\"category\">" + expensesSummaryArray[i].category + "</td><td class=\"sum\">" + expensesSummaryArray[i].sum + " PLN</td></tr>";
				for(var y = 0; y < expenses.length; y++) {
					if(expenses[y].category === expensesSummaryArray[i].category)
						tableRows += "<tr><td class=\"date\">" + expenses[y].date + "</td><td class=\"amount\">" + expenses[y].amount + " PLN</td><td class=\"payment\">" + expenses[y].payment + "</td><td class=\"comment\">" + expenses[y].comment + "</td></tr>";
				}
			}
			tableRows += "<tr class=\"summary\"><td class=\"total\">TOTAL</td><td class=\"sum\">" + totalExpenses + " PLN</td></tr>";
		}
			
		var table = "<table class=\"table-sm col-lg-10 mx-auto my-2\"><tbody><thead class=\"thead-dark\"><caption>" + tableName + "</caption><tr><th class=\"category\">Category</th><th class=\"amount\">Amount</th><th></th>";
		
		if(tableName === "Expenses")
			table +="<th></th>";
		
		table +=  "</tr></thead>" + tableRows + "</tr></tbody></table>";
		
		document.querySelector("#table" + tableName).insertAdjacentHTML("beforeend", table);
	}

	generateSummaryArray(incomeCategories, incomes, "Incomes");
	generateSummaryArray(expenseCategories, expenses, "Expenses");
	
	document.querySelector("#result").insertAdjacentHTML("beforeend", totalIncomes - totalExpenses +" PLN");
	if(totalIncomes - totalExpenses >= 0) {
		$('#result').css('color', '#2eb82e');
		$('#resultText').css('color', '#1f7a1f');
		document.querySelector("#resultText").insertAdjacentHTML("beforeend", "Great!  You Manage Your Finances Very Well!");
	} else {
		$('#result').css('color', 'red');
		$('#resultText').css('color', '#cc0000');
		document.querySelector("#resultText").insertAdjacentHTML("beforeend", "Watch Out! You Are Getting Into Debt!");
	}
}

function generateExampleChart1() {
	
	google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

	var data = google.visualization.arrayToDataTable([
		['Category', 'Amount'],
		['salary',     4500],
		['allegro',      500],
		['bank interest',  50]
	]);

	var options = {
		title: 'Source of Income',
		colors: ['#00e64d', '#66ff99', '#b3ffcc'],
		backgroundColor: { fill:'transparent' },
		chartArea:{top:30,bottom:10,width:'100%',height:'100%'},
		fontSize: 16
	};

	var chart = new google.visualization.PieChart(document.getElementById('piechart1'));

	chart.draw(data, options);
	
	}
}

function generateExampleChart2() {
	
	google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

	var data = google.visualization.arrayToDataTable([
		['Category', 'Amount'],
		['house',     655],
		['food',      554],
		['transport',  150]
	]);

	var options = {
		title: 'Spendings',
		colors: ['#ff3333', '#ff6666', '#ffb3b3'],
		backgroundColor: { fill:'transparent' },
		chartArea:{top:30,bottom:10,width:'100%',height:'100%'},
		fontSize: 16
	};

	var chart = new google.visualization.PieChart(document.getElementById('piechart2'));

	chart.draw(data, options);
	
	}
}

function pageLoad() {
	
	generateExampleTables();
	generateExampleChart1();
	generateExampleChart2();
}

function pageResize() {
	
	generateExampleChart1();
	generateExampleChart2();
}