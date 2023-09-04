 <?php
    session_start(["use_strict_mode" => 1]);

    if (!isset($_SESSION["user_id"])) {
        session_unset();
        session_destroy();
    }

    /** connectDB connects to the database and returns the new connection.
     */
    function connectDB()
    {
        $db_sever = "localhost";
        $db_name = "medsmart";
        $username = "root";
        $password = "";

        $conn = new mysqli($db_sever, $username, $password, $db_name);

        if ($conn->connect_error) {
            die("Unable to connect to db" . $conn->connect_error);
        }

        return $conn;
    }

    /** checks if the user is logged in.
     * If the user is not logged in, redirect the user to login.
     * This function must be called before any page content is sent.
     */
    function checkLogin()
    {
        if (!isset($_SESSION["user_id"])) {
            header("Location: login.php?redirect={$_SERVER['REQUEST_URI']}");
            die();
        }
    }

    /** gets the amount of items in the user's cart.
     * If the user is not logged in, this function returns 0.
     */
    function getCartItems()
    {
        if (isset($_SESSION["user_id"])) {
            $con = connectDB();

            // get the amount of items in the user's cart.
            $sql = "SELECT COUNT(*) AS total FROM `cart` WHERE user_id={$_SESSION["user_id"]}";
            $result = $con->query($sql);

            $amount = 0;

            if ($result && $result->num_rows === 1) {
                $amount = mysqli_fetch_assoc($result)['total'];
            }

            $con->close();

            return $amount;
        }
    }


    /** renderMainMenu renders the main menu for the site.
     */
    function renderMainMenu()
    {
        $logged_in = isset($_SESSION["user_id"]);

        echo '<nav class="main-menu ' . ($logged_in ? "logged-in" : "") . '">
            <span class="menu-item hoverable mobile mobile-only" id="menu-opener">
                <span class="content">
                    <img src="./assets/images/icons/menu.svg" alt="Menu icon" height="24px" width="24px">
                </span>
            </span>
            <a class="menu-item no-hover mobile" href="./index.php" id="site-header">
                <img class="content" width="32px" height="32px" alt="MedSmart Logo" src="./assets/images/logo.png">
                <span class="content">MedSmart</span>
            </a>
            <span class="menu-item spacer"></span>';


        $menu_items = ["Store" => "./store.php", "Contact" => "./contact.php", "About" => "./about.php"];
        foreach ($menu_items as $name => $url) {
            echo '<a class="menu-item hoverable" href="' . $url . '">
            <span class="content">' . $name . '</span>
            </a>';
        }

        echo '
            <span class="menu-item">
                <a class="content button prescription-button" href="' . ($logged_in ? "" : "./login.php?redirect=") . './prescriptions.php">Upload Prescription </a>
            </span>

            <span class="menu-item">
                <a class="content button" href="./login.php" id="login-button">Login </a>
            </span>
            <span class="menu-item spacer mobile mobile-only"></span>
            <a class="menu-item mobile shopping-cart" href="./cart.php">
                <img src="./assets/images/icons/shopping-cart.svg" alt="shopping cart Icon" height="36px" width="36px">';

        $cart_items = getCartItems();
        echo $cart_items > 0 ? '<span class="item-amount">' . $cart_items . '</span>' : '<span class="item-amount hidden"></span>';


        echo '</a>
            <span class="menu-item mobile" id="user-menu-opener">
                <img src="./assets/images/icons/user.svg" alt="User Icon" height="36px" width="36px">
            </span>';

        echo '
            <div class="dropdown-menu compact" id="user-menu">
                <a class="menu-item hoverable" href="./user.php">
                    <span class="content">Profile</span>
                </a>
                <a class="menu-item hoverable" href="./prescriptions.php">
                    <span class="content">Prescriptions</span>
                </a>
                <a class="menu-item hoverable" href="./logout.php">
                    <span class="content">Logout</span>
                </a>
            </div>
        </nav>';
    }

    /** renderFooter renders the footer of the page */
    function renderFooter()
    {
        echo '<footer>
        <div class="content-row">
            <div class="payment-options">
                <span class="heading">Payment Methods</span>
                <div id="card-icons">
                    <img src="./assets/images/icons/visa.svg" alt="Visa card icon" height="42px" width="42px">
                    <img src="./assets/images/icons/mastercard.svg" alt="Master card icon" height="42px" width="42px">
                    <img src="./assets/images/icons/paypal.svg" alt="Paypal icon" height="42px" width="42px">
                </div>
            </div>
            <div class="links">
                <div class="link-row">
                    <span class="heading">Email Addres</span>

                </div>
                <div class="link-row">
                    <span class="heading">Link row 2</span>

                </div>
                <div class="link-row">
                    <span class="heading">Link row 3</span>


                </div>
            </div>
            <div class="contact">
                <span class="heading">Contact Us</span>
                <div class="contact-details">
                    <div class="detail">
                        <img class="icon" src="./assets/images/icons/telephone.svg" alt="Telephone icon" height="16px" width="16px">
                        <span class="content">+9412345678</span>
                    </div>
                    <div class="detail">
                        <img class="icon" src="./assets/images/icons/email.svg" alt="Email icon" height="16px" width="16px">
                        <span class="content">support@medsmart.lk</span>
                    </div>
                    <div class="detail">
                        <img class="icon" src="./assets/images/icons/location.svg" alt="Location icon" height="16px" width="16px">
                        <span class="content">
                            No 1238, <br>
                            New Kandy road,<br>
                            Kothalawala Kaduwela, <br>
                            Location
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div id="copyright">Copyright 2023 MedSmart</div>
    </footer>';
    }

    ?>
