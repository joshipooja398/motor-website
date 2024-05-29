<?php // <--- do NOT put anything before this PHP tag
	include('functions.php');
	$cookieMessage = getCookieMessage();
?>
<!doctype html>
<html>
<head>
	<meta charset="UTF-8" /> 
	<link rel = "shortcut icon" href = "images/logo.jpg"/>
	<title>Sign Up - MyMotor</title>
	<link rel="stylesheet" type="text/css" href="shopstyle.css" />
</head>
<body>
	<div id = "header">
		<img href = "index.php" src='images/logo.jpg' alt = 'MyMotorLogo'>
		<a style = "text-decoration: none" href = "index.php"><h1>MyMotor</h1></a>
	</div>

	<div id = "navbar">
		<ul>
			<li><a style = "text-decoration: none" href = "index.php" >HOME PAGE</a></li>
			<li><a style = "text-decoration: none" href = "ProductList.php">PRODUCT LIST</a></li>
			<li><a style = "text-decoration: none" href = "ViewCart.php">VIEW CART</a></li>
			<li><a style = "text-decoration: none" href = "CustomerList.php">CUSTOMER LIST</a></li>
			<li><a style = "text-decoration: none" href = "OrderList.php">ORDER LIST</a></li>
			<li><a style = "text-decoration: none" href = "SignUp.php">SIGN UP</a></li>
            <li><a style = "text-decoration: none" href = "Admin.php">ADMIN</a></li>
		</ul>
	</div>

	<h2>SIGN UP</h2>

	<?php
		// display any error messages. TODO style this message so that it is noticeable.
		echo "<div id = 'error'>$cookieMessage</div>";
	?>
	
	<form class = "signup" method = 'POST' action = 'AddNewCustomer.php'>
		<!-- 
			TODO make a sign up <form>, don't forget to use <label> tags, <fieldset> tags and placeholder text. 
			all inputs are required.

			Make sure you <input> tag names match the names in AddNewCustomer.php
			
			your form tag should use the POST method. don't forget to specify the action attribute.
		-->
		<div id = 'signUpElement'> <!-- Username -->
			<label for = 'UserName'>Username</label>
		</div> 
		<div id = 'signUpElement'> 
			<input type = 'text' name = 'UserName' id = 'UserName'>
		</div> 

		<div id = 'signUpElement'> <!-- First Name -->
			<label for = 'FirstName'>First name</label>
		</div> 
		<div id = 'signUpElement'> 
			<input type = 'text' name = 'FirstName' id = 'FirstName'>
		</div> 

		<div id = 'signUpElement'> <!-- Last Name -->
			<label for = 'LastName'>Last name</label>
		</div> 
		<div id = 'signUpElement'> 
			<input type = 'text' name = 'LastName' id = 'LastName'>
		</div> 

		<div id = 'signUpElement'> <!-- Address -->
			<label for = 'Address'>Address</label>
		</div> 
		<div id = 'signUpElement'> 
			<input type = 'text' name = 'Address' id = 'Address'>
		</div> 

		<div id = 'signUpElement'> <!-- City -->
			<label for = 'City'>City</label>
		</div>
		<div id = 'signUpElement'> <!-- City -->
			<input type = 'text' name = 'City' id = 'City'>
		</div>

		<div id = 'signUpElement'> <!-- Button -->
			<button type = "submit">CREATE ACCOUNT</button>
		</div>
	</form>
	
</body>
</html>