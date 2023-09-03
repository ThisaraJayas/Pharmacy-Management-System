<?php require_once "site.php" ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Store - MedSmart</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="./assets/images/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="./assets/css/storestyles.css">
	<link rel="stylesheet" href="./assets/css/main.css">

	<script src="./assets/js/store.js"></script>
</head>

<body>
	<?php renderMainMenu() ?>

	<main>
		<div class="storetitle">
			<h2>Shop Products</h2>
		</div>
		<div class="storebar">
			<form method="GET">
				<input type="text" name="search" class="searchtext" value="<?php echo isset($_GET["search"]) ? $_GET["search"] : "" ?>" placeholder="🔍 Search Products">
				<button type="submit" class="searchbutton" name="submit">Search</button>
			</form>
		</div>

		<div class="container">
			<?php
			require './config.php';
			if (isset($_GET['submit'])) {
				$search = $_GET['search'];
				$sql = "select *from product where name LIKE '%$search%'";
				$result = $con->query($sql);
				if ($result->num_rows > 0) {
					while ($row = $result->fetch_assoc()) {
						$id = $row['id'];
						$name = $row['name'];
						$desc = $row['description'];
						$price = $row['price'];
						$image = $row['image'];

						echo "<a class='product' href='productview.php?proviewid=" . $id . "'>";
						echo "<div class='productcard'>";
						echo "<img src='./uploads/products/" . $image . "' class=\"ima\"/>";
						echo "<h3 class='productname'>" . $name . "</h3>";
						echo "<div class=\"price\"><p>LKR " . $price . "</p></div>";
						echo "<button class=\"addcartbutton\" name=\"cartbutton\">Add to Cart</button>";
						echo "</div>";
						echo "</a>";
					}
				} else {
					echo "No products found.";
				}
			} else {
				$sql = "select *from product";
				$result = $con->query($sql);
				if ($result->num_rows > 0) {
					while ($row = $result->fetch_assoc()) {
						$id = $row['id'];
						$name = $row['name'];
						$desc = $row['description'];
						$price = $row['price'];
						$image = $row['image'];

						echo "<a class='product' href='productview.php?proviewid=" . $id . "'>";
						echo "<div class='productcard'>";
						echo "<img src='./uploads/products/" . $image . "' class=\"ima\"/>";
						echo "<h3 class=\"productname\">" . $name . "</h3>";
						echo "<div class=\"price\"><p>LKR " . $price . "</p></div>";
						echo "<button class=\"addcartbutton\" name=\"cartbutton\">Add to Cart</button>";
						echo "</div>";
						echo "</a>";
					}
				} else {
					echo "No products found.";
				}
			}
			?>
		</div>
	</main>

	<?php renderFooter() ?>
	<script src="./assets/js/main.js"></script>
</body>