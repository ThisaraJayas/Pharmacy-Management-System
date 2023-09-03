<?php
require_once "./site.php";

checkLogin();

$error_msg = null;

function uploadPrescription()
{
    global $error_msg;

    $supported_types = ['image/jpeg', 'image/png', 'application/pdf'];
    $supported_types_ext = ['image/jpeg' => '.jpeg', 'image/png' => '.png', 'application/pdf' => '.pdf'];

    $remarks = $_POST["pres-remarks"];
    $image = $_FILES["pres-image"];

    // check if the file size is valid
    if ($image["size"] > 1 << 20 or $image["size"] == 0) {
        http_response_code(413);
        $error_msg = "Failed to upload prescription: Invalid file size";
        return;
    }

    // check if the file type is allowed
    $upload_mime_type = mime_content_type($image["tmp_name"]);
    if (!in_array($upload_mime_type, $supported_types, true)) {
        http_response_code(415);
        $error_msg = "Failed to upload prescription: Unsupported file type";
        return;
    }

    $pres_dir = './uploads/prescriptions/';

    // create upload dir if it does not exist
    if (!is_dir($pres_dir)) {
        mkdir($pres_dir, 0777, true);
    }

    // pick a random name for the file
    do {
        $file_name =   date("Ymd");
        $file_name .= "-" . bin2hex(random_bytes(32));
        $file_name .= ($supported_types_ext[$upload_mime_type]);
    } while (is_file($pres_dir . $file_name));

    // move the uploaded file to the upload directory
    if (!move_uploaded_file($image["tmp_name"], $pres_dir . $file_name)) {
        http_response_code(500);
        $error_msg = "Failed to upload prescription: Internal error while uploading file";
        return;
    }

    $con = connectDB();

    $remarks = $con->real_escape_string($remarks);

    $sql = "INSERT INTO `Prescription` (User_ID, Image, Remarks) VALUES ('{$_SESSION['user_id']}', '$file_name', '$remarks')";
    if (!$con->query($sql)) {
        $con->close();
        http_response_code(500);
        $error_msg = "Failed to upload prescription: Internal error while adding data to db";
        return;
    }
    $con->close();
}

function deletePrescription()
{
    global $error_msg;
    $pres_id = $_GET["id"];
    if (is_numeric($pres_id)) {
        $con = connectDB();

        // get the uploaded image path
        $sql = "SELECT Image FROM `Prescription` WHERE Prescription_ID=$pres_id AND User_ID={$_SESSION['user_id']}";
        $result = $con->query($sql);
        if (!$result || $result->num_rows !== 1) {
            $error_msg = "Failed to delete prescription";
            $con->close();
            return;
        }
        $pres_image = $result->fetch_assoc()["Image"];

        // delete prescription from user cart
        $sql = "DELETE FROM `cart` WHERE prescription_id=$pres_id AND user_id={$_SESSION['user_id']}";
        $result = $con->query($sql);
        if (!$result || $con->affected_rows !== 1) {
            $error_msg = "Failed to delete prescription";
        }

        // delete prescription from database
        $sql = "DELETE FROM `Prescription` WHERE Prescription_ID=$pres_id AND User_ID={$_SESSION['user_id']}";
        $result = $con->query($sql);

        if (!$result || $con->affected_rows !== 1) {
            $error_msg = "Failed to delete prescription";
        }

        // delete the image
        $pres_image  = './uploads/prescriptions/' . $pres_image;
        if (is_file($pres_image)) {
            unlink($pres_image);
        }

        $con->close();
    }
}

if (isset($_REQUEST["action"])) {
    $action = $_REQUEST["action"];
    if ($action == "upload" && $_SERVER['REQUEST_METHOD'] === "POST") {
        uploadPrescription();
    } else if ($action == "delete") {
        deletePrescription();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Prescriptions - MedSmart</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./assets/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/prescription.css">
</head>

<body>
    <?php renderMainMenu() ?>

    <main>
        <h2>Prescriptions</h2>
        <div id="upload-banner">
            <span class="text">
                Click the Upload Prescription button to upload your prescription details.<br>
                A Medsmart pharmacist will verify the prescription and get in touch with out regarding your order.</span>
            <span class="button-container">
                <a href="#" class="button" id="prescription-upload-button">Upload Prescription</a>
            </span>
        </div>

        <?php
        $con = connectDB();
        $sql = "SELECT Prescription_ID, Pharmacist_ID, Approved, Price FROM `Prescription` WHERE User_ID='{$_SESSION['user_id']}' ";
        $result = $con->query($sql);
        if ($result->num_rows == 0) {
            echo "No prescriptions uploaded.";
        } else {
            echo '<div id="prescription-table">
                <div class="row header">
                    <span class="pres-id">Ref #</span>
                    <span class="pres-price">Price</span>
                    <span class="pres-status">Status</span>
                    <span class="actions">&nbsp;</span>
                </div>';

            while ($row = $result->fetch_assoc()) {
                $status = "Pending";
                if ($row["Pharmacist_ID"]) {
                    $status = $row["Approved"] ? "Approved" : "Rejected";
                }

                echo "<div class='row'>
                    <span class='pres-id'>{$row['Prescription_ID']}</span>";

                if ($status === "Approved")
                    echo "<span class='pres-price'>LKR {$row['Price']}</span>";

                echo "<span class='pres-status'>$status</span>
                    <span class='actions'>";

                if ($status === "Approved")
                    echo "<a class='action' onclick='addPrescriptionToCart({$row['Prescription_ID']})'>
                            <img src='./assets/images/icons/cart_add.svg' alt='Add to cart' height='16px'>
                            <span>
                                Add to cart
                            </span>
                        </a>";

                echo "<a class='action' href='./prescriptions.php?action=delete&id={$row['Prescription_ID']}'>
                            <img src='./assets/images/icons/delete.svg' alt='Add to cart' height='16px'>
                            <span>
                                Delete
                            </span>
                        </a>";

                echo "</span></div>";
            }

            echo '</div>';
        }

        ?>

    </main>

    <div class="modal-container">
        <span id="upload-pres-modal">
            <div class="modal-top">
                <h3 class="title">Upload Prescription</h3>
                <img class="modal-close" src="./assets/images/icons/close.svg" alt="close button" width="16px" height="16px">
            </div>
            <form action="./prescriptions.php" method="post" enctype="multipart/form-data">
                <fieldset id="pres-img-upload">
                    <legend>Prescription</legend>
                    <span class="upload-image">
                        <img src="./assets/images/icons/upload.svg" alt="upload file icon" width="60px">
                    </span>

                    <h3 class="upload-text">
                        <span id="pres-upload-dnd-text"> Drag and drop an image of the prescription </span>
                        <br>
                        <span id="pres-upload-button">Select File</span>
                    </h3>
                    <span id="pres-upload-selected"></span>

                    <input type="file" style="display:none;" name="pres-image" accept="image/jpeg, image/png, application/pdf">
                </fieldset>

                <fieldset class="pres-remarks-fieldset">
                    <legend>Remarks</legend>
                    <textarea name="pres-remarks" rows="10"></textarea>
                </fieldset>

                <div class="modal-bottom">
                    <button class="button modal-close" type="reset">Cancel</button>
                    <button class="button" type="submit" name="submit" disabled>Submit</button>
                </div>
            </form>

        </span>
    </div>


    <?php
    renderFooter();
    if (!is_null($error_msg)) {
        echo "<script>alert('$error_msg')</script>";
    }
    ?>
    <script src="./assets/js/main.js"></script>
    <script src="./assets/js/prescription.js"></script>
    <script src="./assets/js/cart.js"></script>
</body>