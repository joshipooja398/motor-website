<!doctype html>
<html>
<head>
	<meta charset="UTF-8" /> 
	<link rel = "shortcut icon" href = "images/spaceshoplogo.png"/>
	<title>View Product - Spaceshop</title>
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

	<h2>VIEW PRODUCT DETAILS</h2>

	<?php 
		
		// include some functions from another file.
		include('functions.php');
		
		if(isset($_GET['ProductID']))
		{		 
			$productIDURL = $_GET['ProductID'];	 // Task 10
			
			// connect to the database using our function (and enable errors, etc)
			$dbh = connectToDatabase(); 
			
			//  bind the value here
			$statement = $dbh->prepare('SELECT * FROM Products INNER JOIN Brands
			ON Brands.BrandID = Products.BrandID
			WHERE Products.ProductID = ? '); //Task 10  LIMIT 10 ; //OFFSET ? * 10 
			
			$statement -> bindValue(1,$productIDURL);  // Task 10
			
			//execute the SQL.
			$statement -> execute();

			// Stament for brand details
			$statement_brand = $dbh -> prepare('SELECT *
				FROM Brands
				INNER JOIN Products
				ON Brands.BrandID = Products.BrandID
				WHERE Products.ProductID = ? 
			');
			$statement_brand -> bindValue(1, $productIDURL);
			$statement_brand -> execute();

			// get the result, there will only ever be one product with a given ID (because products ids must be unique)
			// so we can just use an if() rather than a while()
			if($row = $statement->fetch(PDO::FETCH_ASSOC))
			{
				// Brands table: BrandWebsite
				if($row = $statement_brand -> fetch(PDO::FETCH_ASSOC))
				{
					$BrandWebsite = htmlspecialchars($row['Website'], ENT_QUOTES, 'UTF-8');
				}
	
				// Products table: Price, Description, BrandName, BrandID
				$Price = htmlspecialchars($row['Price'], ENT_QUOTES, 'UTF-8'); 
				$Price = number_format($Price, 2);
				$Description = htmlspecialchars($row['Description'], ENT_QUOTES, 'UTF-8'); 
				$BrandName = htmlspecialchars($row['BrandName'], ENT_QUOTES, 'UTF-8'); 
				$BrandID = htmlspecialchars($row['BrandID'], ENT_QUOTES, 'UTF-8'); 

				echo "<div class = 'productView'>";
					echo "<div class = 'productView_picture'>";
						echo "<a href = '../IFU_Assets/ProductPictures/$productIDURL.jpg' target = '_blank'><img src = '../IFU_Assets/ProductPictures/$productIDURL.jpg' alt= 'productID'/></a>";
					echo "</div>";

					echo "<div class = 'productView_product'>";
						echo "<p>$Description<br/></p>";
						echo "Price: <p>$$Price</p><br/>";
						echo "\n";
						echo "Manufacturer: <p>$BrandName<br/></p>";
						echo "<a href = '$BrandWebsite' target = '_blank'><img src = '../IFU_Assets/BrandPictures/$BrandID.jpg' alt='BrandID'/></a>";
					echo "</div>";

					// change from GET to POST later
					echo "<form class = 'productView_addCart' method = 'POST' action = 'AddToCart.php?ProductID=$productIDURL'>";
						echo "<p>BUY NEW</p>";
						echo "<p>BUY REFURBISHED</p>";
						echo "<p>BUY USED</p>";

						if((!isset($_COOKIE['ShoppingCart'])) || (stringContains($_COOKIE['ShoppingCart'], $productIDURL) == false)) {
							echo "<button name = 'BuyButton' type = 'submit'>ADD TO CART</button>";	
						} else {
							echo "<q>You have this item in cart!</q>";
						}
											
					echo "</form>";
				echo "</div>";

				echo "<div class = 'description'>";
					echo "<p>";
					echo "This is the description for $Description from $BrandName. It is a very excellent product: You can either buy new, refurbished or used. ";
					echo "Everybody loves $BrandName's products, and the new $Description from $BrandName is not going to disappoint you. ";
					echo "At $$Price, $Description is such a bargain and you have the option to buy new, refurbished or used. ";
					echo "You must have $Description from $BrandName. It is a extraordinary! </br>";
					echo "</p>";
					echo "<p>";
					echo "Everybody loves $BrandName's products, and the new $Description from $BrandName is not going to disappoint you. ";
					echo "You must have $Description from $BrandName. It is a extraordinary! ";
					echo "At $$Price, $Description is such a bargain and you have the option to buy new, refurbished or used. ";
					echo "This is the description for $Description from $BrandName. It is a very excellent product: You can either buy new, refurbished or used. ";
					echo "</p>";
					echo "<p>";
					echo "At $$Price, $Description is such a bargain and you have the option to buy new, refurbished or used. ";
					echo "This is the description for $Description from $BrandName. It is a very excellent product: You can either buy new, refurbished or used. ";
					echo "Everybody loves $BrandName's products, and the new $Description from $BrandName is not going to disappoint you. ";
					echo "You must have $Description from $BrandName. It is a extraordinary! ";
					echo "At $$Price, $Description is such a bargain and you have the option to buy new, refurbished or used. ";
					echo "This is the description for $Description from $BrandName. It is a very excellent product: You can either buy new, refurbished or used. ";
					echo "</p>";
				echo "</div>";
			}
			else
			{
				echo "Unknown Product ID";
			}
		}
		else
		{
			echo "No ProductID provided!";
		}
	?>
</body>
</html>