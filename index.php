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

	<!-- TODO 1: a search box here and a submit button -->
	<!-- <form class = "searchbar" action = "ProductList.php">
		<input type = "text" placeholder = "Look Up ..." name = "search">
		<button type = "submit">SEARCH</button>
	</form>	 -->

	<!-- <marquee id = "topScroll" direction="left" scrolldelay="0">
  		<img src="images/scroll_1.png" />
  		<img src="images/scroll_2.png" />
  		<img src="images/scroll_3.png" />
		<img src="images/scroll_4.png" />
		<img src="images/scroll_1.png" />
  		<img src="images/scroll_2.png" />
  		<img src="images/scroll_3.png" />
		<img src="images/scroll_4.png" />
	</marquee> -->

		<!-- <img id = "home1" src="images/scroll_6.png" />
		<div id = "text1">NEW PRODUCTS ARE ABOUT TO BE RELEASED.</div>
		<br/>
		<img id = "home2" src="images/scroll_7.png" />
		<div id = "text2">ARE YOU EXCITED?</div>
		<br/>
		<img id = "home3" src="images/scroll_8.png" />
		<div id = "text3">WE HAVE A LOT OF DISCOUNTS.</div>
		<br/>
		<img id = "home4" src="images/scroll_9.png" />
		<div id = "text4">FROM NAM HOANG WITH LOVE!</div>
		<br/>	 -->

	<?php
		// display any cookie messages. TODO style this message so that it is noticeable.
		echo "<div id = 'error'>$cookieMessage</div>";

	?>
	
		<!-- 
		
			// TODO put a search box here and a submit button.
			
			// TODO the rest of this page is your choice, but you must not leave it blank.
			
			Possible ideas:
			•	List the 10 most recently purchased products.
			•	Use a CSS Animated Slider.
			•	Display any sales or promotions (using an image)

		-->

	<!-- TODO 2: Make the page presentable with content -->
	<!-- TODO 2.1: Slideshow for best selling products-->
	
</body>
</html>