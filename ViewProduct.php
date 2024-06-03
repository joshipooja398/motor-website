<!doctype html>
<html>
<head>
	<meta charset="UTF-8" /> 
	<link rel = "shortcut icon" href = "images/logo.jpg"/>
	<title>View Product - MyMotor</title>
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

	<div id="heading">VIEW PRODUCT DETAILS</div id="heading">

	<?php 
		
		// include some functions from another file.
		include('functions.php');
		
		if(isset($_GET['ProductID']))
		{		 
			$productIDURL = $_GET['ProductID'];	 // Task 10
			
			// connect to the database using our function (and enable errors, etc)
			$dbh = connectToDatabase(); 
			
			//  bind the value here
			$statement = $dbh->prepare('SELECT * FROM Products 
			WHERE Products.ProductID = ? '); //Task 10  LIMIT 10 ; //OFFSET ? * 10 
			
			$statement -> bindValue(1,$productIDURL);  // Task 10
			
			//execute the SQL.
			$statement -> execute();

			// Stament for brand details

			// get the result, there will only ever be one product with a given ID (because products ids must be unique)
			// so we can just use an if() rather than a while()
			if($row = $statement->fetch(PDO::FETCH_ASSOC))
			{
				// Products table: Price, Description, BrandName, BrandID
				$Price = htmlspecialchars($row['Price'], ENT_QUOTES, 'UTF-8'); 
				$Price = number_format($Price, 2);
				$Description = htmlspecialchars($row['Description'], ENT_QUOTES, 'UTF-8'); 
				

				echo "<div class = 'productView'>";
					echo "<div class = 'productView_picture'>";
						// echo "<a href = '$row['Image']' target = '_blank'><img src ='$row['Image']' alt= 'productID'/></a>";
					echo "</div>";

					echo "<div class = 'productView_product'>";
						echo "<p>$Description<br/></p>";
						echo "Price: <p>$$Price</p><br/>";
						echo "\n";
						
					echo "</div>";

					// change from GET to POST later
					echo "<form class = 'productView_addCart' method = 'POST' action = 'AddToCart.php?ProductID=$productIDURL'>";
					

						if((!isset($_COOKIE['ShoppingCart'])) || (stringContains($_COOKIE['ShoppingCart'], $productIDURL) == false)) {
							echo "<button name = 'BuyButton' type = 'submit'>ADD TO CART</button>";	
						} else {
							echo "<q>You have this item in cart!</q>";
						}
											
					echo "</form>";
				echo "</div>";

				echo "<div class = 'description'>";
					echo "<p>";
					
					echo "At $$Price, $Description is such a bargain and you have the option to buy new, refurbished or used. ";
					echo "You must have $Description from. It is a extraordinary! </br>";
					echo "</p>";
					echo "<p>";
					echo "You must have $Description from . It is a extraordinary! ";
					echo "At $$Price, $Description is such a bargain and you have the option to buy new, refurbished or used. ";
					echo "This is the description for $Description from . It is a very excellent product: You can either buy new, refurbished or used. ";
					echo "</p>";
					echo "<p>";
					echo "At $$Price, $Description is such a bargain and you have the option to buy new, refurbished or used. ";
					echo "You must have $Description from . It is a extraordinary! ";
					echo "At $$Price, $Description is such a bargain and you have the option to buy new, refurbished or used. ";
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