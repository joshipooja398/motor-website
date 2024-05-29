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

	<h2>MY ORDERS</h2>

<?php

	// did the user provided an OrderID via the URL?
	if(isset($_GET['OrderID']))
	{
		$UnsafeOrderID = $_GET['OrderID'];
		
		include('functions.php');
		$dbh = connectToDatabase();
		
		// select the order details and customer details. (you need to use an INNER JOIN)
		// but only show the row WHERE the OrderID is equal to $UnsafeOrderID.
		$statement = $dbh->prepare("SELECT Orders.OrderID, datetime(TimeStamp, 'unixepoch', 'localtime') AS TimeStamp, Orders.CustomerID, 
				Customers.CustomerID, Customers.UserName, Customers.FirstName, Customers.LastName, Customers.Address, Customers.City 
			FROM Orders 
			INNER JOIN Customers ON Customers.CustomerID = Orders.CustomerID 
			WHERE OrderID = ? ; 
		");
		$statement->bindValue(1,$UnsafeOrderID);
		$statement->execute();
		
		// did we get any results?
		if($row1 = $statement->fetch(PDO::FETCH_ASSOC))
		{
			// Output the Order Details.
			$FirstName = makeOutputSafe($row1['FirstName']); 
			$LastName = makeOutputSafe($row1['LastName']); 
			$OrderID = makeOutputSafe($row1['OrderID']); 
			$UserName = makeOutputSafe($row1['UserName']); 
			$Address = makeOutputSafe($row1['Address']);
			$City = makeOutputSafe($row1['City']);
			$TimeStamp = makeOutputSafe($row1['TimeStamp']);


			// display the OrderID
			echo "<div id = 'error'>ORDER #$OrderID PLACED</div>";
			
			// its up to you how the data is displayed on the page. I have used a table as an example.
			// the first two are done for you.
		//echo "<table>";
			//TODO show the Customers Address and City.
			//TODO show the date and time of the order.

			//TODO show the Customers Address and City.
			//TODO show the date and time of the order.
			
	//echo "</table>";
			
			// TODO: select all the products that are in this order (you need to use INNER JOIN)
			// this will involve three tables: OrderProducts, Products and Brands.
			$statement2 = $dbh->prepare('
				SELECT *
				FROM OrderProducts 
				INNER JOIN Products ON OrderProducts.ProductID = Products.ProductID
				INNER JOIN Brands ON Products.BrandID = Brands.BrandID
				WHERE OrderProducts.OrderID = $OrderID;
			');
			$statement2->bindValue(1,$UnsafeOrderID);
			$statement2->execute();
			
			$totalPrice = 0;
			
		echo "<div class = 'ItemUser'>"; // begin of ItemUser, the biggest class
			echo "<div class = 'ViewITEMS'>"; // begin of ViewOrderDetails
			echo "CART LISTING<br>";
			echo "<br/>";
			// loop over the products in this order. 
			while($row2 = $statement2->fetch(PDO::FETCH_ASSOC))
			{
				//NOTE: pay close attention to the variable names.
				$ProductID = makeOutputSafe($row2['ProductID']); 
				$Description = makeOutputSafe($row2['Description']); 
				$BrandName = makeOutputSafe($row2['BrandName']); 
				$Price = makeOutputSafe($row2['Price']); 
				$Quantity = makeOutputSafe($row2['Quantity']); 
				$BrandID = makeOutputSafe($row2['BrandID']); 
				$BrandWebsite = makeOutputSafe($row2['Website']); 
				$subTotal = number_format($Price * $Quantity, 2);
				$totalPrice += $subTotal;


				echo "<div class = 'cartListingViewDetails'>";
				echo "<table>";
					echo "<tr>";
						echo "<td id = 'cart_col1'>";
							echo "<a href='ViewProduct.php?ProductID=$ProductID' target = '_blank'><img src='../IFU_Assets/ProductPictures/$ProductID.jpg' alt ='$ProductID' /></a>  ";
						echo "</td>";
						echo "<td id = 'cart_col2'>";
							echo "$Description";	
						echo "</td>";
						echo "<td id = 'cart_col3'>";
							echo "<p>$BrandName<p>";	
							echo "<a href = '$BrandWebsite' target = '_blank'><img src = '../IFU_Assets/BrandPictures/$BrandID.jpg' alt='BrandID'/></a>";
						echo "</td>";
						echo "<td id = 'cart_col4'>";
							echo "$$Price";	
						echo "</td>";
						echo "<td id = 'cart_col5'>";
							echo "$Quantity";	
						echo "</td>";
						echo "<td id = 'cart_col6'>";
							echo "$$subTotal";	
						echo "</td>";
					echo "</tr>";
				echo "</table>";
				echo "</div>"; // end of cartListing
			}		
			echo "</div>"; // end of ViewITEMS
			
			//TODO display the $totalPrice.
			$totalPrice = number_format($totalPrice, 2);

			// SELF: make it something else not table, table is hard to deal with
			echo "<div class = 'ViewUSERS'>"; // begin of ViewUSERS
				echo "CUSTOMER DETAILS<br>";
				echo "<br/>";
				echo "Username: $UserName<br>";
				echo "Customer Name: $FirstName $LastName<br>";
				echo "Placed on: $TimeStamp<br>";
				echo "Shipped to: $Address, $City<br>";
				echo "<br/>";
				echo "Total Price:<b>";
				echo "<p>$$totalPrice<p>";
			echo "</div>"; // end of ViewUSERS
		echo "</div>"; // end of ItemUser, the biggest class

		}
		else 
		{
			echo "<div id = 'error'>System Error: OrderID not found</div>";
		}
	}
	else
	{
		echo "<div id = 'error'>System Error: OrderID was not provided</div>";
	}
?>
</body>
</html>
