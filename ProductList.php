<?php
include('functions.php');
$cookieMessage = getCookieMessage();
$dbh = connectToDatabase();

// Define the number of products to display per page
$itemsPerPage = 10;

// Determine the current page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Define the default sort option
$sortOption = 'popularity';

// Check if a search term is provided
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';

// Define the SQL statement to select products ordered by popularity with optional search
$query = 'SELECT * FROM Products';
$searchConditions = [];

if (!empty($searchTerm)) {
    $query .= ' WHERE Name LIKE :searchTerm';
    $searchConditions[':searchTerm'] = '%' . $searchTerm . '%';
}

$query .= ' ORDER BY ';

switch ($sortOption) {
    case 'name':
        $query .= 'Name ASC';
        break;
    case 'name_desc':
        $query .= 'Name DESC';
        break;
    case 'price':
        $query .= 'Price ASC';
        break;
    case 'price_desc':
        $query .= 'Price DESC';
        break;
    case 'popularity':
    default:
        $query .= 'Popularity DESC';
        break;
}

$query .= ' LIMIT :offset, :limit';

// Calculate the offset for pagination
$offset = ($page - 1) * $itemsPerPage;

// Prepare the SQL statement
$statement = $dbh->prepare($query);
$statement->bindValue(':offset', $offset, PDO::PARAM_INT);
$statement->bindValue(':limit', $itemsPerPage, PDO::PARAM_INT);

// Bind the search condition if applicable
if (!empty($searchTerm)) {
    $statement->bindValue(':searchTerm', $searchConditions[':searchTerm'], PDO::PARAM_STR);
}

$statement->execute();

// Get the total number of products for pagination
$totalProducts = $dbh->query('SELECT COUNT(*) FROM Products')->fetchColumn();
$totalPages = ceil($totalProducts / $itemsPerPage);
?>

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

	 <h1 id="heading">Product List</h1>
    <?php
    // Display any cookie messages
    echo $cookieMessage;
    ?>

    <!-- Search and Sort Form -->
    <form method="get" id="search-sort-container">
        <div>
            <label for="search">Search:</label>
            <input type="text" id="search" name="search" value="<?php echo $searchTerm; ?>">
            <button type="submit" id="search-button">Search</button>
        </div>
    </form>


    <div class="product-container">
        <?php
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            echo '<div class="product-box">';
            echo '<a href="ViewProduct.php?ProductID=' . $row['ProductID'] . '">';
            echo '<h3>' . $row['Name'] . '</h3>';
            echo '<p>' . $row['Description'] . '</p>';
            echo '<p>Price: $' . $row['Price'] . '</p>';
            echo '</a>';
            echo '</div>';
        }
        ?>
    </div>

    <!-- Pagination links -->
    <div id="pagination">
        <?php if ($page > 1): ?>
        <a
            href="ProductList.php?page=<?php echo $page - 1; ?>&sort=<?php echo $sortOption; ?>&search=<?php echo $searchTerm; ?>">Previous</a>
        <?php endif; ?>
        <?php if ($page < $totalPages): ?>
        <a
            href="ProductList.php?page=<?php echo $page + 1; ?>&sort=<?php echo $sortOption; ?>&search=<?php echo $searchTerm; ?>">Next</a>
        <?php endif; ?>
    </div>
    </div>

</body>	
</html>