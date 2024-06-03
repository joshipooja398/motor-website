<?php // <--- do NOT put anything before this PHP tag
	include('functions.php');
	$cookieMessage = getCookieMessage();
?>
<!doctype html>
<html>
<head>
	<meta charset="UTF-8" /> 
	<link rel = "shortcut icon" href = "images/logo.jpg"/>
	<title>MyMotor</title>
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

	<h1 id="heading">Welcome To My Motor Store</h1>

<?php
    // Display any cookie messages. TODO style this message so that it is noticeable.
    echo $cookieMessage;
    ?>

	<div class="search-box">
	<center>
        <form action="ProductList.php" method="get">
            <input type="text" id="search" name="search" placeholder="Search products">
            <input type="submit" value="Search" class="index-button">
        </form>
		</center
    </div>

	<h3 class='p-20'><center>Recently Purchased Motor</h3>

	<div class="slider-container">
        <div class="slider-wrapper">

        
            <?php
            $dbh = connectToDatabase();

            $statement = $dbh->prepare('
                SELECT Orders.OrderID, Orders.TimeStamp, OrderProducts.ProductID, Products.Description
                FROM Orders
                INNER JOIN OrderProducts ON OrderProducts.OrderID = Orders.OrderID
                INNER JOIN Products ON Products.ProductID = OrderProducts.ProductID
                ORDER BY Orders.TimeStamp DESC
                LIMIT 10;
            ');

            $statement->execute();

            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $orderID = makeOutputSafe($row['OrderID']);
                $timestamp = makeOutputSafe($row['TimeStamp']);
                $productID = makeOutputSafe($row['ProductID']);
                $description = makeOutputSafe($row['Description']);

                // Display this information as a slider item
                echo '<div class="slider-item">';
                echo "<p>OrderID: $orderID</p>";
                echo "<p>Time: $timestamp</p>";
                echo "<p>ProductID: $productID</p>";
                echo "<p>Description: $description</p>";
                echo '</div>';
            }
            ?>
        </div>
    </div>
	
</body>
</html>