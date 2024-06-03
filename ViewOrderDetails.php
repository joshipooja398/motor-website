<!doctype html>
<html>
<head>
	<meta charset="UTF-8" /> 
	<link rel = "shortcut icon" href = "images/logo.jpg"/>
	<title>My Order - MyMotor</title>
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

	<h1 id="heading">MY ORDERS</h1>

<div id='vieworderdetails-cont'>
        <?php
		// Did the user provide an OrderID via the URL?
		if (isset($_GET['OrderID'])) {
			$UnsafeOrderID = $_GET['OrderID'];

			include('functions.php');
			$dbh = connectToDatabase();

			// Select the order details using INNER JOIN.
			$statement = $dbh->prepare('
            SELECT Orders.OrderID, Orders.TimeStamp, Customers.FirstName, Customers.LastName, Customers.UserName
            FROM Orders
            INNER JOIN Customers ON Customers.customerID = Orders.CustomerID
            WHERE OrderID = ?;
        ');
			$statement->bindValue(1, $UnsafeOrderID);
			$statement->execute();

			// Did we get any results?
			if ($row1 = $statement->fetch(PDO::FETCH_ASSOC)) {
				// Output the Order Details.
				$OrderID = makeOutputSafe($row1['OrderID']);
				$TimeStamp = makeOutputSafe($row1['TimeStamp']);
				$FirstName = makeOutputSafe($row1['FirstName']);
				$LastName = makeOutputSafe($row1['LastName']);
				$UserName = makeOutputSafe($row1['UserName']);

				// Display the OrderID and Time placed.
				echo "<h1 id='heading vieworderdetails-header'>OrderID: $OrderID</h1>";
				echo "<p id='vieworderdetails-text'>Time Placed: $TimeStamp</p>";

				// Display customer information.
				echo "<h1 id='heading vieworderdetails-header'>Customer Details:</h1>";
				echo "<p id='vieworderdetails-text'>Customer Name: $FirstName $LastName</p>";
				echo "<p id='vieworderdetails-text'>UserName: $UserName</p>";

				// Select all the products that are in this order.
				$statement2 = $dbh->prepare('
                SELECT OrderProducts.ProductID, Products.Name, Products.Description, Products.Price, OrderProducts.Quantity
                FROM OrderProducts
                INNER JOIN Products ON Products.ProductID = OrderProducts.ProductID
                WHERE OrderID = ?;
            ');
				$statement2->bindValue(1, $UnsafeOrderID);
				$statement2->execute();

				$totalPrice = 0;

				// Loop over the products in this order.
				echo "<h1 id='heading vieworderdetails-header'>Order Details:</h1>";
				echo "<table id='vieworderdetails-table'>";
				echo "<tr><th>Name</th><th>Description</th><th>Price</th><th>Quantity</th></tr>";

				while ($row2 = $statement2->fetch(PDO::FETCH_ASSOC)) {
					$ProductID = makeOutputSafe($row2['ProductID']);
					$Name = makeOutputSafe($row2['Name']);
					$Description = makeOutputSafe($row2['Description']);
					# $Brand = makeOutputSafe($row2['Brand']);
					$Price = makeOutputSafe($row2['Price']);
					$Quantity = makeOutputSafe($row2['Quantity']);

					// Display product details.
					echo "<tr>";
					echo "<td id='vieworderdetails-text'>$Name</td>";
					echo "<td id='vieworderdetails-text'>$Description</td>";
					echo "<td id='vieworderdetails-text'>$Price</td>";
					echo "<td id='vieworderdetails-text'>$Quantity</td>";
					echo "</tr>";

					// Add the price to the totalPrice variable.
					$totalPrice += ($Price * $Quantity);
				}

				echo "</table>";

				// Display the total price.
				echo "<h1 id='heading vieworderdetails-total'>Total Price: $totalPrice</h1>";
			} else {
				echo "System Error: OrderID not found";
			}
		} else {
			echo "System Error: OrderID was not provided";
		}
		?>
    </div>
</body>
</html>
