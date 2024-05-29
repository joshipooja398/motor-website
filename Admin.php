<?php // <--- do NOT put anything before this PHP tag
	include('functions.php');
	$cookieMessage = getCookieMessage();
?>
<!doctype html>
<html>
<head>
	<meta charset="UTF-8" /> 
	<link rel = "shortcut icon" href = "images/spaceshoplogo.png"/>
	<title>Admin - Spaceshop</title>
	<link rel="stylesheet" type="text/css" href="shopstyle.css" />
</head>
<body>
	<div id = "header">
		<img href = "Homepage.php" src='images/spaceshoplogo.png' alt = 'spaceshoplogo'>
		<a style = "text-decoration: none" href = "Homepage.php"><h1>SPACESHOP</h1></a>
	</div>

	<div id = "navbar">
		<ul>
			<li><a style = "text-decoration: none" href = "Homepage.php" >HOME PAGE</a></li>
			<li><a style = "text-decoration: none" href = "ProductList.php">PRODUCT LIST</a></li>
			<li><a style = "text-decoration: none" href = "ViewCart.php">VIEW CART</a></li>
			<li><a style = "text-decoration: none" href = "CustomerList.php">CUSTOMER LIST</a></li>
			<li><a style = "text-decoration: none" href = "OrderList.php">ORDER LIST</a></li>
			<li><a style = "text-decoration: none" href = "SignUp.php">SIGN UP</a></li>
            <li><a style = "text-decoration: none" href = "Admin.php">ADMIN</a></li>
		</ul>
	</div>

    <h2>ADMIN VERIFICATION</h2>

	<?php
    echo "<div id = 'error'>$cookieMessage</div>";

    echo "<form class = 'signup' method = 'POST' action = 'BusinessOwner.php'>";
		echo "<div id = 'signUpElement'>";
			echo "<label for = 'AdminPassword'>Admin Password</label>";
		echo "</div>";

		echo "<div id = 'signUpElement'>";
			echo "<input type = 'password' name = 'AdminPassword' id = 'AdminPassword'>";
		echo "</div>";

		echo "<div id = 'signUpElement'>";
			echo "<button type = 'submit'>LOG IN</button>";
		echo "</div>";
    echo "</form>";

	echo "<div class = 'printMessage'>";
    	echo "Prototype: you can enter anything to access Business Details!";
	echo "</div>";
	?>
</body>
</html>