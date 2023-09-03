<?php
require_once './check_login.php';
include '../config.php';
if (isset($_REQUEST["action"])) {
    $action = $_REQUEST["action"];
    $id = $_REQUEST["id"];

    if ($action === "reject") {
        $sql = "UPDATE `Prescription` SET Pharmacist_ID ={$_SESSION['admin_id']} WHERE Prescription_ID=$id";
    } else if ($action === "accept") {
        $price = $_REQUEST["price"];
        $sql = "UPDATE `Prescription` SET Pharmacist_ID ={$_SESSION['admin_id']}, Approved=1, Price=$price WHERE Prescription_ID=$id";
    } else {
        die("Invalid action");
    }

    $result = mysqli_query($con, $sql);
    if ($result) {
        header('location:prescription.php');
    } else {
        die(mysqli_error($con));
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Prescriptions</title>
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
                <th>User</th>
                <th>Remarks</th>
                <th>Image</th>
                <th>Status</th>
                <th>Price</th>
                <th>Operation</th>
            </tr>
        </thead>
        <tbody>

            <?php

            $sql = "select * from `Prescription`";
            $result = mysqli_query($con, $sql);
            if ($result) {

                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['Prescription_ID'];
                    $user_id = $row['User_ID'];
                    $remarks = $row['Remarks'];
                    $image = $row['Image'];
                    $approved = $row['Approved'];
                    $price = $row['Price'];
                    echo '<tr>
                            <td>' . $id . '</td>
                            <td>' . $user_id . '</td>
                            <td>' . $remarks . '</td>
                            <td> <a href="../uploads/prescriptions/' . $image . '" target="_blank">View</a></td>
                            <td>' . ($approved ? "Approved" : ($row["Pharmacist_ID"] ? "Rejected" : "Pending"))  . '</td>
                            <td>' . $price . '</td>';
                    if (is_null($row["Pharmacist_ID"])) {
                        echo '<td>
                                <button onclick="updatePrescription(' . $id . ', true)">Approve</button>
                                <button onclick="updatePrescription(' . $id . ', false)">Reject</button>   
                            </td>';
                    } else {
                        echo '<td></td>';
                    }

                    echo ' </tr>';
                }
            }


            ?>


        <tbody>
    </table>
    <script src="../assets/js/adminPrescription.js"></script>
</body>

</html>