<?php
require_once './check_login.php';
include '../config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage users</title>
  <link rel="stylesheet" href="../assets/css/admin.css">
  <link rel="stylesheet" href="../assets/css/displaylogin.css">
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
  <table class="center">
    <thead>
      <tr>
        <th>Id</th>
        <th>FirstName</th>
        <th>LastName</th>
        <th>Email</th>
        <th>Mobile</th>
        <th>Operation</th>
      </tr>
    </thead>
    <tbody>

      <?php

      $sql = "select * from `user`";
      $result = mysqli_query($con, $sql);
      if ($result) {

        while ($row = mysqli_fetch_assoc($result)) {
          $id = $row['id'];
          $fname = $row['firstname'];
          $lname = $row['lastname'];
          $email = $row['email'];
          $mobile = $row['mobile'];
          echo '<tr>
        <td>' . $id . '</td>
        <td>' . $fname . '</td>
        <td>' . $lname . '</td>
        <td>' . $email . '</td>
        <td>' . $mobile . '</td>
        <td>
        <button><a href="updatelogin.php?updateid=' . $id . '">Update</a></button>
        <button><a href="deleteuser.php?deleteid=' . $id . '">Delete</a></button>
    </td>
      </tr>';
        }
      }


      ?>


    <tbody>
  </table>
</body>

</html>