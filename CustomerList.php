<?php // <--- do NOT put anything before this PHP tag
	include('functions.php');
	$cookieMessage = getCookieMessage();
?>
<!doctype html>
<html>
<head>
	<meta charset="UTF-8" /> 
	<link rel = "shortcut icon" href = "images/spaceshoplogo.png"/>
	<title>Customer List - Spaceshop</title>
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

	<h2>CUSTOMER LIST</h2>

	<?php
		// include some functions from another file.
		//include('functions.php');
		//Task 9
		if(isset($_GET['page']))
		{
			$currentPage = intval($_GET['page']);
		}
		else
		{
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
						echo "<a style = 'text-decoration: none' href = 'CustomerList.php?page=$currentPage'> Previous Page</a>";

					} elseif ($previousPage >= 0)
					{
						echo "<a style = 'text-decoration: none' href = 'CustomerList.php?page=$previousPage'> Previous Page</a>";
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
					echo "<a style = 'text-decoration: none' href = 'CustomerList.php?page=$nextPage'>Next Page</a>"; //Task 9B
					//echo "<br/>";
				echo "</li>";
			echo "</ul>";
		echo "</div>"; // end of class navbar


		// display any error messages. 
		// TODO style this message so that it is noticeable.
		echo "<h2>";
			echo $cookieMessage;
		echo "</h2>";

		// Table
		echo "<div class = 'customerListing'>";
		echo "<table>";
			echo "<tr>";
				echo "<th id = 'cust_col1'>";
					echo "Customer ID";
				echo "</th>";
				echo "<th id = 'cust_col2'>";
					echo "Username";
				echo "</th>";
				echo "<th id = 'cust_col3'>";
					echo "First Name";
				echo "</th>";
				echo "<th id = 'cust_col4'>";
					echo "Last Name";
				echo "</th>";
				echo "<th id = 'cust_col5'>";
					echo "Address";
				echo "</th>";
				echo "<th id = 'cust_col6'>";
					echo "City";
				echo "</th>";
			echo "</tr>";
		echo "</table>";

		// SELF: Fetch data
		$dbh =  connectToDatabase();
		
		//$startRow = $currentPage;
		// SQL statement
		$statement = $dbh -> prepare('SELECT *
			FROM Customers
			LIMIT 15
			OFFSET ? * 15
			;');
		//$statement -> execute(array('currentPage' => $currentPage));
		//$results = $statement -> fetchAll();

		$statement->bindValue(1,$currentPage); //Task 9

		// bind the value
		$statement -> execute();

		// Print out data from Customers table
		while ($row = $statement -> fetch(PDO::FETCH_ASSOC)) {
			$customerID = htmlspecialchars($row['CustomerID'], ENT_QUOTES, 'UTF-8');
			$userName = htmlspecialchars($row['UserName'], ENT_QUOTES, 'UTF-8');
			$firstName = htmlspecialchars($row['FirstName'], ENT_QUOTES, 'UTF-8');
			$lastName = htmlspecialchars($row['LastName'], ENT_QUOTES, 'UTF-8');
			$address = htmlspecialchars($row['Address'], ENT_QUOTES, 'UTF-8');
			$city = htmlspecialchars($row['City'], ENT_QUOTES, 'UTF-8');

			echo "<table>";
			echo "<tr>";
				echo "<td id = 'cust_col1'>";
					echo "$customerID";
				echo "</td>";
				echo "<td id = 'cust_col2'>";
					echo "$userName";
				echo "</td>";
				echo "<td id = 'cust_col3'>";
					echo "$firstName";
				echo "</td>";
				echo "<td id = 'cust_col4'>";
					echo "$lastName";
				echo "</td>";
				echo "<td id = 'cust_col5'>";
					echo "$address";
				echo "</td>";
				echo "<td id = 'cust_col6'>";
					echo "$city";
				echo "</td>";
			echo "</tr>";
		echo "</table>";
		}
		echo "</div>"; // end of customerListing
		
	?>

	
</body>
</html>