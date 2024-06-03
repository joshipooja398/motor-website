<?php
include('functions.php');

// Get the cookieMessage, this must be done before any HTML is sent to the browser.
$cookieMessage = getCookieMessage();
?>

<!doctype html>
<html>

<head>
    <meta charset="UTF-8" />
	<link rel="shortcut icon" href="images/logo.jpg" />
	<title>View Cart - MyMotor</title>
	<link rel="stylesheet" type="text/css" href="shopstyle.css" />
</head>
<body>
			<div id="header">
				<img href="index.php" src='images/logo.jpg' alt='MyMotorLogo'>
					<a style="text-decoration: none" href="index.php"><h1>MyMotor</h1></a>
			</div>
			<div id="navbar">
				<ul>
					<li><a style="text-decoration: none" href="index.php" >HOME PAGE</a></li>
					<li><a style="text-decoration: none" href="ProductList.php">PRODUCT LIST</a></li>
					<li><a style="text-decoration: none" href="ViewCart.php">VIEW CART</a></li>
					<li><a style="text-decoration: none" href="CustomerList.php">CUSTOMER LIST</a></li>
					<li><a style="text-decoration: none" href="OrderList.php">ORDER LIST</a></li>
					<li><a style="text-decoration: none" href="SignUp.php">SIGN UP</a></li>
					<li><a style="text-decoration: none" href="Admin.php">ADMIN</a></li>
				</ul>
			</div>

			<div id="heading">VIEW CART</div >
    
    <div id="viewcart-container">
        <?php
		// Check if the user has items in the shopping cart
		if (isset($_COOKIE['ShoppingCart']) && $_COOKIE['ShoppingCart'] != '') {
			// The shopping cart cookie contains a list of productIDs separated by commas
			// We need to split this string into an array by exploding it.
			$productID_list = explode(",", $_COOKIE['ShoppingCart']);

			// Remove any duplicate items from the cart to prevent primary key violations
			$productID_list = array_unique($productID_list);

			$dbh = connectToDatabase();

			// Create a SQL statement to select the product info for each product in the cart
			$statement = $dbh->prepare('
            SELECT ProductID, Name, Description, Price
            FROM Products
            WHERE ProductID = ?
        ');

			$totalPrice = 0;

			// Loop over the productIDs in the shopping cart
			foreach ($productID_list as $productID) {
				// Bind the productID and execute the statement
				$statement->bindValue(1, $productID);
				$statement->execute();

				// Check if we found a match
				if ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
					// Output information about the product, including pictures, description, brand, and more
					echo '<div id="viewcart-product-box">';
					echo '<h3>' . $row['Name'] . '</h3>';
					echo '<p>' . $row['Description'] . '</p>';
					echo '<p>Price: $' . $row['Price'] . '</p>';
					echo '</div>';

					// Add the price of this item to the total
					$totalPrice += $row['Price'];
				}
			}

			// Output the total price
			echo '<p id="viewcart-total-price">Total Price: $' . number_format($totalPrice, 2) . '</p>';

			// If we have any error messages, echo them now
			echo $cookieMessage;
			?>

        <form id="viewcart-cart-form" action="ProcessOrder.php" method="POST">
            <input id="viewcart-form-input" type="text" name="UserName" placeholder="Enter Your UserName" required>
            <input id="viewcart-confirm-button" type="submit" name="ConfirmOrder" value="Confirm Order">
        </form>

        <form id="viewcart-cart-form" action="EmptyCart.php" method="POST">
            <button id="viewcart-empty-button" type="submit" name="EmptyCart">Empty Shopping Cart</button>
        </form>
        <?php
		} else {
			// If the user has no items in the cart, show a message
			echo $cookieMessage;
			echo "You have no items in your cart!";
		}
		?>
    </div>
</body>

</html>