<?php require_once './check_login.php' ?>
<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" href="../assets/css/admin.css">
	<link rel="stylesheet" href="../assets/css/contactdisplay.css">
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
	<div class="table">
		<?php
		require '../config.php';
		$sql = "select *from contact";
		$result = $con->query($sql);
		echo ("<table class='displayTable'>");
		echo ("<tr ><td class='tableheading'>ID</td><td class='tableheading'>First Name</td>
			<td class='tableheading'>Last Name</td><td class='tableheading'>Email</td><td class='tableheading'>Tele No</td>
			<td class='tableheading'>Message</td></tr>");
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$id = $row['id'];
				$fname = $row['fname'];
				$lname = $row['lname'];
				$email = $row['email'];
				$telno = $row['telno'];
				$message = $row['message'];

				echo ("<tr><td class='contxt'>" . $id . "</td><td class='contxt'>" . $fname . "</td><td class='contxt'>
				<pre>" . $lname . "</pre></td><td class='contxt'>" . $email . "</td><td class='contxt'>" . $telno . "</td>
				<td class='contxt'>" . $message . "</td></tr>");
			}
		}
		echo ("</table>");
		?>

	</div>
</body>

</html>