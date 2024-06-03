<?php // <--- do NOT put anything before this PHP tag
	include('functions.php');
	$cookieMessage = getCookieMessage();
?>
<!doctype html>
<html>
<head>
	<meta charset="UTF-8" /> 
	<link rel = "shortcut icon" href = "images/logo.jpg"/>
	<title>Order List - MyMotor</title>
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

	<div id="heading">ORDER LIST</div>
<?php
    $dbh = connectToDatabase();

    // SQL query to select all order and customer details
    $statement = $dbh->prepare('
            SELECT Orders.OrderID, Orders.TimeStamp, Customers.customerID, Customers.FirstName, Customers.LastName, Customers.UserName
            FROM Orders
            INNER JOIN Customers ON Customers.customerID = Orders.CustomerID;
        ');

    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Check if there are any orders
    if (count($result) > 0) {
        echo '<table>';
        echo '<tr><th>OrderID</th><th>Time Placed</th><th>Customer Name</th></tr>';

        foreach ($result as $row) {
            $OrderID = $row['OrderID'];
            $TimeStamp = date('Y-m-d H:i:s', $row['TimeStamp']); // Format the timestamp as needed
            $CustomerName = $row['FirstName'] . ' ' . $row['LastName'];
            $UserName = $row['UserName'];

            // Output order details in a table row
            echo '<tr>';
            echo '<td><a href="ViewOrderDetails.php?OrderID=' . $OrderID . '">' . $OrderID . '</a></td>';
            echo '<td>' . $TimeStamp . '</td>';
            echo '<td>' . $CustomerName . ' (' . $UserName . ')</td>';
            echo '</tr>';
        }

        echo '</table>';
    } else {
        echo 'No orders found.';
    }
    ?>
	
</body>
</html>