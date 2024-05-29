<?php // <--- do NOT put anything before this PHP tag

include('functions.php');

// get the cookieMessage, this must be done before any HTML is sent to the browser.
$cookieMessage = getCookieMessage();

?>
<!doctype html>
<html>
<head>
	<meta charset="UTF-8" /> 
	<link rel = "shortcut icon" href = "images/spaceshoplogo.png"/>
	<title>View Cart - Spaceshop</title>
	<link rel="stylesheet" type="text/css" href="shopstyle.css" />
</head>
<body>
	<div id = "header">
		<img href = "index.php" src='images/spaceshoplogo.png' alt = 'spaceshoplogo'>
		<a style = "text-decoration: none" href = "index.php"><h1>SPACESHOP</h1></a>
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

	<!-- TODO 1: a search box here and a submit button -->
	<form class = "searchbar" action = "ProductList.php">
		<input type = "text" placeholder = "Look Up ..." name = "search">
		<button type = "submit">SEARCH</button>
	</form>	

	<h2>VIEW CART</h2>

	<?php

	// does the user have items in the shopping cart?
	if(isset($_COOKIE['ShoppingCart']) && $_COOKIE['ShoppingCart'] != '')
	{
		// the shopping cart cookie contains a list of productIDs separated by commas
		// we need to split this string into an array by exploding it.
		$productID_list = explode(",", $_COOKIE['ShoppingCart']);
		
		// remove any duplicate items from the cart. although this should never happen we 
		// must make absolutely sure because if we don't we might get a primary key violation.
		$productID_list = array_unique($productID_list);
		
		$dbh = connectToDatabase();

		// create a SQL statement to select the product and brand info about a given ProductID
		// this SQL statement will be very similar to the one in ViewProduct.php
		// TODO PUT YOUR SQL HERE
		$statement = $dbh->prepare('SELECT *
			FROM Products
			INNER JOIN Brands
			ON Brands.BrandID = Products.BrandID
			WHERE Products.ProductID = ?
		');
		
		// SELF: to be deleted, is down there already
		echo "<form class = 'searchbar' action = 'EmptyCart.php' method = 'POST'>";
			echo "<button type = 'submit' name = 'EmptyCart' value = 'Empty Shopping Cart' id = 'EmptyCart'>EMPTY CART</button>\n";	
		echo "</form>";

		echo "<div class = 'cartListing'>";
		echo "<table>";
			echo "<tr>";
				echo "<th id = 'cart_col1'>";
					echo "Product";	
				echo "</th>";
				echo "<th id = 'cart_col2'>";
					echo "Name";	
				echo "</th>";
				echo "<th id = 'cart_col3'>";
					echo "Manufacturer";	
				echo "</th>";
				echo "<th id = 'cart_col4'>";
					echo "Price Per Item";
				echo "</th>";
				echo "<th id = 'cart_col5'>";
					echo "Quantity";
				echo "</th>";
				echo "<th id = 'cart_col6'>";
					echo "Subtotal";	
				echo "</th>";
			echo "</tr>";
		echo "</table>";

		$totalPrice = 0;

		$all_cart_list = explode(",", $_COOKIE['ShoppingCart']);
		$counts = array_count_values($all_cart_list);
		// loop over the productIDs that were in the shopping cart.

		//$list_product = explode(",", $_COOKIE['ProductList']);

		foreach($productID_list as $productID)
		{
			//$id_index = array_search($productID, $list_product);
			//$quantity = $list_product[$id_index + 1];
			$quantity = $counts[$productID];
			// great thing about prepared statements is that we can use them multiple times.
			// bind the first question mark to the productID in the shopping cart.
			$statement->bindValue(1,$productID);
			$statement->execute();
			// did we find a match?
			if($row = $statement->fetch(PDO::FETCH_ASSOC))
			{				
				// Products table: Price, Description, BrandName, BrandID
				$Price = htmlspecialchars($row['Price'], ENT_QUOTES, 'UTF-8'); 
				$Price = number_format($Price, 2);
				$Description = htmlspecialchars($row['Description'], ENT_QUOTES, 'UTF-8'); 
				$BrandName = htmlspecialchars($row['BrandName'], ENT_QUOTES, 'UTF-8'); 
				$BrandID = htmlspecialchars($row['BrandID'], ENT_QUOTES, 'UTF-8'); 
				$BrandWebsite = htmlspecialchars($row['Website'], ENT_QUOTES, 'UTF-8'); 
				$subTotal = $Price * $quantity;
				$subTotal = number_format($subTotal, 2);

			
				//TODO Output information about the product. including pictures, description, brand etc.			
				echo "<table>";
					echo "<tr>";
						echo "<td id = 'cart_col1'>";
							echo "<a href='ViewProduct.php?ProductID=$productID' target = '_blank'><img src='../IFU_Assets/ProductPictures/$productID.jpg' alt ='$productID' /></a>  ";
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
							echo "$quantity";	
						echo "</td>";
						echo "<td id = 'cart_col6'>";
							echo "$$subTotal";	
						echo "</td>";
					echo "</tr>";
				echo "</table>";
				
				//TODO add the price of this item to the $totalPrice
				$totalPrice += $subTotal;
				$totalPrice = number_format($totalPrice, 2);
			}
		}
		echo "</div>"; // end of cartListing

		// if we have any error messages echo them now. TODO style this message so that it is noticeable.
		echo "<div id = 'error'>$cookieMessage</div>";

			//echo "<div id = 'inputUserName'>";
		// TODO: output the $totalPrice.
		echo "<form class = 'cartTotal' method = 'POST' action = 'ProcessOrder.php'>";			
			echo "<div id = 'inputUserName'>";
				echo "<label for = 'UserName'>USERNAME</label>";
				echo "<input type = 'text' name = 'UserName' id = 'UserNameBox'>";
			echo "</div>";
			echo "<button type = 'submit'>PLACE AN ORDER</button>";	
			echo "<div id = 'cart_Total_Sum'>";
				echo "TOTAL PRICE";
				echo "<p>$$totalPrice</p>";
			echo "</div>"; // end of cart_Total_Sum
		echo "</form>"; // end of cartTotal	
	}
	else
	{
		// if we have any error messages echo them now. TODO style this message so that it is noticeable.
		echo "<div class = 'printMessage'>";
			//echo "_ $cookieMessage _ <br/>";
			echo "<p>$cookieMessage</p>You have no items in your cart!";
		echo "</div>";
	}
	?>
</body>
</html>
