<?php // <--- do NOT put anything before this PHP tag
	include('functions.php');
	$cookieMessage = getCookieMessage();
?>
<!doctype html>
<html>
<head>
	<meta charset="UTF-8" /> 
	<link rel = "shortcut icon" href = "images/logo.jpg"/>
	<title>Business Owner - MyMotor</title>
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

    <h2>BUSINESS OWNER</h2>

	<?php

	//if($_POST['AdminPassword'] == 'admin') {
		// once logged in as admin, stay as admin.
		//echo "<form class = 'admin' method = 'POST' action = 'BusinessOwner.php'>";
			//echo "<label for = 'AdminPassword'>Admin Password</label><br>";
			//echo "<input type = 'password' name = 'AdminPassword' id = 'AdminPassword'><br>";
			//echo "<button type = 'submit'>LOG IN</button><br>";
   		//echo "</form>";
		//$adminPassword = 'admin';

		if(isset($_GET['page'])) {
			$currentPage = intval($_GET['page']);
		} else {
			$currentPage = 0;
		}

		$print_currentPage = $currentPage + 1;
		//Task 9C
		echo "<div id = 'pageBar'>";
			echo "<ul>";
				echo "<li>";
					$previousPage =  $currentPage - 1;
					if ($previousPage == -1)
					{
						echo "<a style = 'text-decoration: none' href = 'BusinessOwner.php?page=$currentPage'> Previous Page</a>";

					} elseif ($previousPage >= 0)
					{
						echo "<a style = 'text-decoration: none' href = 'BusinessOwner.php?page=$previousPage'> Previous Page</a>";
					}
				echo "</li>";

				echo "<li>";
					echo "<form class = 'pageNo'>";
						echo "<input name = 'page' type = 'text' value = '$print_currentPage' placeholder = 'Go To Page ...'/>";
					echo "</form>";
				echo "</li>";

				echo "<li>";
					$nextPage =  $currentPage + 1; //Task 9A
					//echo "<a href = 'ProductList.php?page=$nextPage'>Next Page</a>"; //Task 9A
					echo "<a style = 'text-decoration: none' href = 'BusinessOwner.php?page=$nextPage'>Next Page</a>"; //Task 9B
					//echo "<br/>";
				echo "</li>";
			echo "</ul>";
		echo "</div>"; // end of class navbar

		// display any error messages. TODO style this message so that it is noticeable.
		echo "<h2>";
			echo $cookieMessage;
		echo "<h2>";

		echo "<div class = 'productInfo'>";
		echo "<table>";
			echo "<tr>";
				echo "<th id = 'pdInfo_col1'>";
					echo "Product ID";
				echo "</th>";
				echo "<th id = 'pdInfo_col2'>";
					echo "Product Name";
				echo "</th>";
				echo "<th id = 'pdInfo_col3'>";
					echo "Brand";
				echo "</th>";
				echo "<th id = 'pdInfo_col4'>";
					echo "Price";
				echo "</th>";
				echo "<th id = 'pdInfo_col5'>";
					echo "Popularity";
				echo "</th>";
				echo "<th id = 'pdInfo_col6'>";
					echo "Total Quantity";
				echo "</th>";
				echo "<th id = 'pdInfo_col7'>";
					echo "Total Revenue";
				echo "</th>";
				//echo "<th id = 'pdInfo_col8'>";
				//	echo "City";
				//echo "</th>";
			echo "</tr>";
		echo "</table>";

		// SELF: Fetch data
		$dbh =  connectToDatabase();
		
		//$startRow = $currentPage;
		// SQL statement
		$statement = $dbh -> prepare("SELECT P.ProductID, P.Description, B.BrandName, P.Price,
					   COUNT(OP.ProductID) AS Popularity, SUM(OP.Quantity) AS TotalQuantity, 
					   (SUM(OP.Quantity)  * P.Price) AS TotalRevenue
			FROM Products P, Brands B, OrderProducts OP
			WHERE P.BrandID = B.BrandID AND P.ProductID = OP.ProductID
			GROUP BY P.ProductID, B.BrandName, P.Description, P.Price
			ORDER BY(SUM(OP.Quantity)  * P.Price) DESC
			LIMIT 15
			OFFSET ? * 15
			;");
		//$statement -> execute(array('currentPage' => $currentPage));
		//$results = $statement -> fetchAll();

		$statement->bindValue(1,$currentPage); //Task 9

		// bind the value
		$statement -> execute();

		// Print out data from Customers table
		while ($row = $statement -> fetch(PDO::FETCH_ASSOC)) {
			$ProductID = htmlspecialchars($row['ProductID'], ENT_QUOTES, 'UTF-8');
			$Description = htmlspecialchars($row['Description'], ENT_QUOTES, 'UTF-8');
			$BrandName = htmlspecialchars($row['BrandName'], ENT_QUOTES, 'UTF-8');
			$Price = htmlspecialchars($row['Price'], ENT_QUOTES, 'UTF-8');
			$Price = number_format($Price, 2);
			$Popularity = htmlspecialchars($row['Popularity'], ENT_QUOTES, 'UTF-8');
			$TotalQuantity = htmlspecialchars($row['TotalQuantity'], ENT_QUOTES, 'UTF-8');
			$TotalRevenue = htmlspecialchars($row['TotalRevenue'], ENT_QUOTES, 'UTF-8');
			$TotalRevenue = number_format($TotalRevenue, 2);
			//$city = htmlspecialchars($row['City'], ENT_QUOTES, 'UTF-8');

			echo "<table>";
			echo "<tr>";
				echo "<td id = 'pdInfo_col1'>";
					echo "<a style = 'text-decoration: none' href = 'ViewProduct.php?ProductID=$ProductID' target = '_blank'>";
					echo "$ProductID";
					echo "</a>";
				echo "</td>";
				echo "<td id = 'pdInfo_col2'>";
					echo "<p>$Description</p>";
				echo "</td>";
				echo "<td id = 'pdInfo_col3'>";
					echo "$BrandName";
				echo "</td>";
				echo "<td id = 'pdInfo_col4'>";
					echo "$$Price";
				echo "</td>";
				echo "<td id = 'pdInfo_col5'>";
					echo "$Popularity";
				echo "</td>";
				echo "<td id = 'pdInfo_col6'>";
					echo "$TotalQuantity";
				echo "</td>";
				echo "<td id = 'pdInfo_col7'>";
					echo "$$TotalRevenue";
				echo "</td>";
				//echo "<td id = 'pdInfo_col1'>";
				//	echo "$city";
				//echo "</td>";
			echo "</tr>";
		echo "</table>";
		}
		echo "</div>"; // end of productInfo		
	//} else {
	//	echo "<div class = 'printMessage'>";
	//	echo "System Error: Invalid Password.<br>Fail to grant Admin access!";
	//	echo "</div>";
	//}
	?>
</body>
</html>