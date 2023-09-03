<?php
require_once './check_login.php';

require '../config.php';
$id = $_GET['updateid'];
$sql = "select *from product where id=$id";
$result = $con->query($sql);
$row = $result->fetch_assoc();
$name = $row['name'];
$description = $row['description'];
$price = $row['price'];
$discount = $row['discount'];
$image = $row['image'];

if (isset($_POST['submit'])) {
	$name = $_POST['pName'];
	$descrip = $_POST['pDesc'];
	$price = $_POST['pPrice'];
	$discount = $_POST['pDiscount'];
	$image = $_FILES['pFile'];
	$imagefilename = $image['name'];
	$imagefiletemp = $image['tmp_name'];
	$upload_image = "../uploads/products/" . $imagefilename;
	move_uploaded_file($imagefiletemp, $upload_image);

	$sql = "update product set name='$name', description='$descrip', price='$price', discount='$discount', image='$imagefilename' where id=$id";
	if ($con->query($sql)) {
		echo "<script>alert('Product Updated Successfully');</script>";
	} else {
		echo "error" . $con->error;
	}
}
$con->close();
?>
<!DOCTYPE html>
<html>

<head>
	<title>Add New Product</title>
	<script src="../assets/js/addproduct.js"></script>
	<link rel="stylesheet" href="../assets/css/update.css">
	<link rel="stylesheet" href="../assets/css/admin.css">
</head>

<body>
	<div class="navbar">
		<ul>
			<li><a href="addproduct.php">Manage Product</a> </li>
			<li><a href="prescription.php">Manage Prescription</a> </li>
			<li><a href="displaylogin.php">Manage Users</a></li>
			<li><a href="contactdisplay.php">Messages</a></li>
		</ul>
	</div>
	<div class="button-container">
		<button class="button2"><a href="../store.php">STORE</a></button>
		<button class="button3"><a href="addproduct.php">Add Product</a></button>
	</div>
	<h2>Update Product</h2>
	<div class="formbox">
		<form method="post" name="form1" enctype="multipart/form-data">
			<label>Enter product name</label><br>
			<input type="text" name="pName" placeholder="Enter Product name" class="tbox" value="<?php echo $name; ?>"><br><br>
			<label>Enter description</label><br>
			<textarea name="pDesc" rows="4" cols="40" placeholder="Enter Description" class="tbox"><?php echo $description; ?></textarea><br><br>
			<label>Enter product price</label><br>
			<input type="text" name="pPrice" placeholder="Enter Product price" class="tbox" value="<?php echo $price; ?>"><br><br>
			<label>Enter product discount</label><br>
			<input type="text" name="pDiscount" placeholder="Enter Product Discount" class="tbox" value="<?php echo $discount; ?>"><br><br>
			<label class="imagetxt">Upload product image</label><br><br>
			<input type="file" name="pFile" value="<?php echo $image; ?>"><br>
			<button type="submit" name="submit" class="button1" onclick="return productAdd();">Update</button>
		</form>
	</div>
	<div class="displayTable">
		<?php
		require '../config.php';
		$sql = "select *from product";
		$result = $con->query($sql);
		echo ("<table class='disTable'>");
		echo ("<tr ><td class='tablemaintxt'>Product ID</td><td class='tablemaintxt'>Product Name</td>
			<td class='tablemaintxt'>Description</td><td class='tablemaintxt'>Price</td><td class='tablemaintxt'>Discount</td>
			<td class='tablemaintxt'>Image</td>
			<td class='tablemaintxt'>Operations</td></tr>");
		if ($result->num_rows > 0) {

			while ($row = $result->fetch_assoc()) {
				$id = $row['id'];
				$name = $row['name'];
				$description = $row['description'];
				$price = $row['price'];
				$discount = $row['discount'];
				$image = $row['image'];

				echo ("<tr><td class='tabletxt'>" . $id . "</td><td class='tabletxt'>" . $name . "</td><td class='tabletxt'>
				<pre>" . $description . "</pre></td><td class='tabletxt'>" . $price . "</td><td class='tabletxt'>" . $discount . "</td><td><img src='../uploads/products/" . $image . "'/></td>");
				echo ("<td><button class=\"updatebutton\"><a class=\"updtxt\" href='updateproduct.php? updateid=" . $id . "'>Update</a></button>
				<button class=\"deletebutton\"><a class=\"deltxt\" href='deleteproduct.php? deleteid=" . $id . "'>Delete</a></button></td>");
				echo ("</tr>");
			}
		}
		echo ("</table>");
		?>

	</div>
</body>

</html>