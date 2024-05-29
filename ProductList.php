<!doctype html>
<html>
<!doctype html>
<html>
<head>
	<meta charset="UTF-8" /> 
	<link rel = "shortcut icon" href = "images/logo.jpg"/>
	<title>Product List - MyMotor</title>
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

	<?php
		// include some functions from another file.
		include('functions.php');
		
		//Task 7A
		// if the user provided a search string.
		if(isset($_GET['search']))
		{
			$searchString = $_GET['search'];
		}
		// if the user did NOT provided a search string, assume an empty string
		else
		{
			$searchString = "";
		}
				
		//$SqlSearchString = "%$searchString%"; //Task 7A
		$safeSearchString = htmlspecialchars($searchString, ENT_QUOTES,"UTF-8"); //Task 8B
		$SqlSearchString = "%$safeSearchString%"; //Task 8B

		echo "<form class = 'searchbar'>"; //Task 7
		// echo "<input name = 'search' type = 'text' />"; //Task 7
		// echo "<input name = 'search' type = 'text' value = '$searchString' />"; //Task 8
		echo "<input name = 'search' type = 'text' value = '$safeSearchString' placeholder = 'Look Up ...'/>"; //Task 8B
		echo "<button type = 'submit'>SEARCH</button>"; //Task 7
		echo "</form>"; //Task 7

		echo "<h2>PRODUCT LISTING FOR <span class = 'customizedText'>'$searchString'<span></h2>";


		// connect to the database using our function (and enable errors, etc)
		$dbh = connectToDatabase();
		
		if (isset($_POST['userSelection'])) {
			$userSelection = $_POST['userSelection'];
			//$userSelection = $_GET['userSelection'];
		} elseif (isset($_GET['userSelection'])){
			$userSelection = $_GET['userSelection'];
		} else {
			$userSelection = 'popularity';
		}

		// SELF: Sort by xyz condition
		echo "<form class = 'dropdown' method = 'POST'>";
			echo "<select name = 'userSelection' onchange = 'this.form.submit()'>";
				//echo "<option value = 'popularity'>Popularity</option>";
				if($userSelection == 'popularity' || $userSelection == '') {
					echo "<option value = 'popularity' selected>Popularity</option>";
					echo "<option value = 'nameA'>Name: Ascending</option>";
					echo "<option value = 'nameD'>Name: Descending</option>";
					echo "<option value = 'priceL'>Price: Lowest</option>";
					echo "<option value = 'priceH'>Price: Highest</option>";
				} elseif($userSelection == 'nameA') {
					echo "<option value = 'popularity' selected>Popularity</option>";
					echo "<option value = 'nameA' selected>Name: Ascending</option>";
					echo "<option value = 'nameD'>Name: Descending</option>";
					echo "<option value = 'priceL'>Price: Lowest</option>";
					echo "<option value = 'priceH'>Price: Highest</option>";
				} elseif($userSelection == 'nameD') {
					echo "<option value = 'popularity' selected>Popularity</option>";
					echo "<option value = 'nameA'>Name: Ascending</option>";
					echo "<option value = 'nameD' selected>Name: Descending</option>";
					echo "<option value = 'priceL'>Price: Lowest</option>";
					echo "<option value = 'priceH'>Price: Highest</option>";
				} elseif($userSelection == 'priceL') {
					echo "<option value = 'popularity' selected>Popularity</option>";
					echo "<option value = 'nameA'>Name: Ascending</option>";
					echo "<option value = 'nameD'>Name: Descending</option>";
					echo "<option value = 'priceL' selected>Price: Lowest</option>";
					echo "<option value = 'priceH'>Price: Highest</option>";
				} elseif($userSelection == 'priceH') {
					echo "<option value = 'popularity' selected>Popularity</option>";
					echo "<option value = 'nameA'>Name: Ascending</option>";
					echo "<option value = 'nameD'>Name: Descending</option>";
					echo "<option value = 'priceL'>Price: Lowest</option>";
					echo "<option value = 'priceH' selected>Price: Highest</option>";
				}
				
			echo "</select>";
			//echo "<input type = 'submit'>";
		echo "</form>";
		


		if ($userSelection == 'popularity') {
			$statement = $dbh->prepare('SELECT * FROM Products LEFT JOIN OrderProducts 
				ON OrderProducts.ProductID = Products.ProductID
				WHERE Products.Description LIKE ? 
				GROUP BY Products.ProductID 
				ORDER BY COUNT(OrderProducts.OrderID) DESC
				LIMIT 10 
				OFFSET ? * 10
			;');  //Task 11		
		} elseif ($userSelection == 'nameA') {
			$statement = $dbh->prepare('SELECT * FROM Products LEFT JOIN OrderProducts 
				ON OrderProducts.ProductID = Products.ProductID
				WHERE Products.Description LIKE ? 
				GROUP BY Products.ProductID 
				ORDER BY Products.Description ASC
				LIMIT 10 
				OFFSET ? * 10
			;');  //Task 11		
		} elseif ($userSelection == 'nameD') {
			$statement = $dbh->prepare('SELECT * FROM Products LEFT JOIN OrderProducts 
				ON OrderProducts.ProductID = Products.ProductID
				WHERE Products.Description LIKE ? 
				GROUP BY Products.ProductID 
				ORDER BY Products.Description DESC
				LIMIT 10 
				OFFSET ? * 10
			;');  //Task 11		
		} elseif ($userSelection == 'priceL') {
			$statement = $dbh->prepare('SELECT * FROM Products LEFT JOIN OrderProducts 
				ON OrderProducts.ProductID = Products.ProductID
				WHERE Products.Description LIKE ? 
				GROUP BY Products.ProductID 
				ORDER BY Products.Price ASC
				LIMIT 10 
				OFFSET ? * 10
			;');  //Task 11		
		} elseif ($userSelection == 'priceH') {
			$statement = $dbh->prepare('SELECT * FROM Products LEFT JOIN OrderProducts 
				ON OrderProducts.ProductID = Products.ProductID
				WHERE Products.Description LIKE ? 
				GROUP BY Products.ProductID 
				ORDER BY Products.Price DESC
				LIMIT 10 
				OFFSET ? * 10
			;');  //Task 11		
		}

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
						echo "<a style = 'text-decoration: none' href = 'ProductList.php?page=$currentPage&search=$safeSearchString&userSelection=$userSelection'> Previous Page</a>";

					} elseif ($previousPage >= 0)
					{
						echo "<a style = 'text-decoration: none' href = 'ProductList.php?page=$previousPage&search=$safeSearchString&userSelection=$userSelection'> Previous Page</a>";
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
					echo "<a style = 'text-decoration: none' href = 'ProductList.php?page=$nextPage&search=$safeSearchString&userSelection=$userSelection'>Next Page</a>"; //Task 9B
					//echo "<br/>";
				echo "</li>";
			echo "</ul>";
		echo "</div>"; // end of class navbar
		
		$statement->bindValue(1,$SqlSearchString); //Task 7A
		
		$statement->bindValue(2,$currentPage); //Task 9
			
		
		//execute the SQL.
		$statement->execute();

		// get the results
		while($row = $statement->fetch(PDO::FETCH_ASSOC))
		{
			// Remember that the data in the database could be untrusted data. 
			// so we need to escape the data to make sure its free of evil XSS code.
			$ProductID = htmlspecialchars($row['ProductID'], ENT_QUOTES, 'UTF-8'); 
			$Price = htmlspecialchars($row['Price'], ENT_QUOTES, 'UTF-8'); 
			$Price = number_format($Price, 2);
			$Description = htmlspecialchars($row['Description'], ENT_QUOTES, 'UTF-8'); 
			
			// output the data in a div with a class of 'productBox' we can apply css to this class.
			echo "<div class = 'productBox'>";
			// [Put Task 5A here]  
			//echo "<img src = '../IFU_Assets/ProductPictures/$ProductID.jpg' alt ='' / >"; //Task 5A
			//Task 10A
			echo "<a href='ViewProduct.php?ProductID=$ProductID'><img src='../IFU_Assets/ProductPictures/$ProductID.jpg' alt ='$ProductID' /></a>  ";
			echo "<p>$Description<br/></p>";
			echo "$$Price<br/>";
			echo "</div> \n";			
		}
	?>
</body>
</html>