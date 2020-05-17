<?php
session_start();

if(isset($_SESSION['loggedUserId'])) {
	
	require_once 'database.php';
	
	$expenseCategoryQuery = $db -> prepare('SELECT ec.expense_category FROM expense_categories ec NATURAL JOIN user_expense_category uec WHERE uec.user_id = :loggedUserId');
	$expenseCategoryQuery -> execute([':loggedUserId'=> $_SESSION['loggedUserId']]);
	
	$expenseCategoriesOfLoggedUser = $expenseCategoryQuery -> fetchAll();
	
	$paymentMethodQuery = $db -> prepare('SELECT pm.payment_method FROM payment_methods pm NATURAL JOIN user_payment_method upm WHERE upm.user_id = :loggedUserId');
	$paymentMethodQuery -> execute([':loggedUserId'=> $_SESSION['loggedUserId']]);
	
	$paymentMethodsOfLoggedUser = $paymentMethodQuery -> fetchAll();
} else {
	
	header ("Location: index.php");
}
	
?>

<!DOCTYPE html>

<html lang="pl">

<head>

	<meta charset="utf-8">
	<title>MyBudget - Your Personal Finance Manager</title>
	<meta name="description" content="Track your income and expenses - avoid overspending!">
	<meta name="keywords" content="expense manager, budget planner, expense tracker, budgeting app, money manager, money management, personal finance management software, finance manager, saving planner">
	<meta name="author" content="Magdalena Słomiany">
	
	<meta http-equiv="X-Ua-Compatible" content="IE=edge">
	
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/fontello.css">
	<link href="https://fonts.googleapis.com/css2?family=Baloo+Paaji+2:wght@400;500;700&family=Fredoka+One&family=Roboto:wght@400;700;900&family=Varela+Round&display=swap" rel="stylesheet">
	
</head>

<body onload="getCurrentDate()">
	
	<header>
	
		<h1 class="mt-3 mb-1" id="title"><a id="homeButton" href="index.php" role="button">Welcome to <span id="logo">MyBudget</span>.com!</a></h1>
		<p id="subtitle">Your Personal Finance Manager</p>
		
	</header>
	
	<main>
		
		<section class="container-fluid square my-4 py-2">
			
			<nav class="navbar navbar-dark navbar-expand-lg">
			
				<button class="navbar-toggler bg-primary" type="button" data-toggle="collapse" data-target="#mainMenu" aria-controls="mainMenu" aria-expanded="false" aria-label="Navigation Toggler">
					<span class="navbar-toggler-icon"></span>
				</button>
				
				<div class="collapse navbar-collapse" id="mainMenu">
			
					<ul class="navbar-nav mx-auto">
					
						<li class="col-lg-2 nav-item">
							<a class="nav-link" href="menu.php"><i class="icon-home"></i> Home</a>
						</li>
						
						<li class="col-lg-2 nav-item">
							<a class="nav-link" href="income.php"><i class="icon-money-1"></i> Add Income</a>
						</li>
						
						<li class="col-lg-2 nav-item disabled">
							<a class="nav-link" href="expense.php"><i class="icon-dollar"></i> Add Expense</a>
						</li>
						
						<li class="col-lg-2 nav-item dropdown">
							<a class="nav-link" href="#" role="button"><i class="icon-chart-pie"></i> View Balance</a>
							<div class="dropdown-menu bg-transparent border-0 m-0 p-0">
							
								<a class="dropdown-item" href="balance.php">Current Month</a>
								<a class="dropdown-item" href="balance.php">Last Month</a>
								<a class="dropdown-item" href="balance.php">Current Year</a>
								<a class="dropdown-item" href="balance.php" data-toggle="modal" data-target="#dateModal">Custom</a>
							
							</div>
						</li>
						
						<li class="col-lg-2 nav-item dropdown">
							<a class="nav-link" href="#" role="button"><i class="icon-cog-alt"></i> Settings</a>
							<div class="dropdown-menu bg-transparent border-0 m-0 p-0">
							
								<h6 class="dropdown-header">Profile settings</h6>
								<a class="dropdown-item" href="#">Name</a>
								<a class="dropdown-item" href="#">Password</a>
								<a class="dropdown-item" href="#">E-mail Adress</a>
								<div class="dropdown-divider"></div>
								<h6 class="dropdown-header">Category settings</h6>
								<a class="dropdown-item" href="#">Income</a>
								<a class="dropdown-item" href="#">Expense</a>
								<a class="dropdown-item" href="#">Payment Methods</a>
							
							</div>
						</li>
						
						<li class="col-lg-2 nav-item">
							<a class="nav-link" href="index.php"><i class="icon-logout"></i> Sign out</a>
						</li>
						
					</ul>
					
				</div>
			
			</nav>
			
		</section>
		
		<section class="container-fluid square my-4 py-4">
		
			<form class="col-sm-10 col-md-8 col-lg-6 py-3 mx-auto">
				
				<h3>ADDING AN EXPENSE</h3>
				
				<div class="row justify-content-around">
				
					<div class="col-sm-10 col-lg-8">
					
						<div class="input-group mt-3">
							<div class="input-group-prepend px-1">
								<span class="input-group-text">Amount</span>
							</div>
							<input class="form-control userInput labeledInput" type="number" id="expenseInput" step="0.01" required>
						</div>
						
						<div class="input-group mt-3">
							<div class="input-group-prepend px-1">
								<span class="input-group-text">Date</span>
							</div>
							<input class="form-control  userInput labeledInput" type="date" id="dateInput" required>
						</div>
						
						<div class="input-group mt-3">
							<div class="input-group-prepend px-1">
								<span class="input-group-text">Payment Method</span>
							</div>
							<select class="form-control userInput labeledInput" id="paymentMethod">
								<?php
									foreach ($paymentMethodsOfLoggedUser as $payment_method) {
									echo "<option>{$payment_method['payment_method']}</option>";
									}
								?>
							</select>
						</div>
						
						<div class="input-group mt-3">
							<div class="input-group-prepend px-1">
								<span class="input-group-text">Category</span>
							</div>
							<select class="form-control userInput labeledInput" id="expenseCategory">
								<?php
									foreach ($expenseCategoriesOfLoggedUser as $category) {
									echo "<option>{$category['expense_category']}</option>";
									}
								?>
							</select>
						</div>
						
						<div class="input-group mt-3">
							<div class="input-group-prepend px-1">
								<span class="input-group-text">Commments<br />(optional)</span>
							</div>
							<textarea class="form-control userInput labeledInput" id="comment" rows="5"></textarea>
						</div>
						
					</div>
					
					<div class="col-md-11">
						<a class="btn btn-lg mt-3 mb-2 signButton bg-primary " href="#" role="button">
							<i class="icon-floppy"></i> Save
						</a>
						<a class="btn btn-lg mt-3 mb-2 bg-primary signButton" href="#" role="button">
							<i class="icon-cancel-circled"></i> Cancel
						</a>
					</div>
					
				</div>
				
			</form>
		
		</section>
		
		<div class="modal hide fade in" data-backdrop="static" id="dateModal">
			<div class="modal-dialog" role="document">
				<div class="modal-content">

					<div class="modal-header">
						<h3 class="modal-title">Selecting time period</h3>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>

					<div class="modal-body">
					
						<form class="col py-3 mx-auto">
				
							<h5>Enter a start date and an end date of period that you want to review</h5>
							
							<div class="row justify-content-around py-2">
							
								<div class="form-group my-2">
									<label for="dateInput1">Enter start date</label>
									<input class="form-control  userInput labeledInput" type="date" id="dateInput1" required>
								</div>
								
								<div class="form-group my-2">
									<label for="dateInput2">Enter end date</label>
									<input class="form-control  userInput labeledInput" type="date" id="dateInput2" required>
								</div>
								
							</div>
							
						</form>
						
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-primary" >Save</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					</div>

				</div>
			</div>
		</div>
		
	</main>
	
	<footer>
	
		<div class="col my-2 footer">
			2020 &copy; myBudget.com
		</div>
		
	</footer>
	
	<script src="js/budget.js"></script>
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="js/bootstrap.min.js"></script>
	
</body>

</html>