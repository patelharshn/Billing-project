<?php
include('command/conn.php');
if (isset($_COOKIE['email'])) {
    $email = $_COOKIE['email'];
} else {
    header("Location: http://localhost/newproject-Copy/login/index.php");
}

$query_uid = "select username,image from user where email='$email'";
$result = mysqli_query($con, $query_uid);
$row = mysqli_fetch_row($result);
if ($row > 0) {
    $username = $row[0];
    $imageprofile = $row[1];
} else {
    echo "User ID Not found";
}
?>
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="index.php">
            <img src="assets/images/profile/<?php echo $imageprofile; ?>" class="navbar-brand-img h-100 rounded-circle" alt="main_logo">
            <span class="ms-1 font-weight-bold text-white">Hi, <?php echo $username; ?></span>
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <!-- <div class="collapse navbar-collapse w-auto ps" id="sidenav-collapse-main"> -->
    <div class="collapse navbar-collapse  w-auto  max-height-vh-100" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-white " href="index.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">home</i>
                    </div>
                    <span class="nav-link-text ms-1">Home</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white " href="product.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">shopping_cart</i>
                    </div>
                    <span class="nav-link-text ms-1">Product</span>
                </a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link text-white " href="purchase.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">shop_two</i>
                    </div>
                    <span class="nav-link-text ms-1">Purchase</span>
                </a>
            </li> -->
            <li class="nav-item">
                <a class="nav-link text-white " href="sales_extra.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">storefront</i>
                    </div>
                    <span class="nav-link-text ms-1">Sales</span>
                </a>
            </li>
            <!-- <li class="nav-item">
                <a data-bs-toggle="collapse" href="#return" class="nav-link text-white" aria-controls="return" role="button" aria-expanded="false">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">refresh</i>
                    </div>
                    <span class="nav-link-text ms-1">Return</span>
                </a>
                <div class="collapse" id="return">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link text-white ps-4" href="return.php">
                                <span class="sidenav-mini-icon"><i class="material-icons opacity-10">chevron_right</i></span>
                                <span class="sidenav-normal  ms-2"> Supplier Return </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white ps-4" href="#">
                                <span class="sidenav-mini-icon"><i class="material-icons opacity-10">chevron_right</i></span>
                                <span class="sidenav-normal  ms-2"> Customer Return </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li> -->

            <li class="nav-item">
                <a class="nav-link text-white " href="customer.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">person_add</i>
                    </div>
                    <span class="nav-link-text ms-1">Customer</span>
                </a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link text-white " href="supplier.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">store</i>
                    </div>
                    <span class="nav-link-text ms-1">Supplier</span>
                </a>
            </li> -->
            <li class="nav-item">
                <a class="nav-link text-white " href="billing.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <!-- <i class="material-icons opacity-10">receipt_long</i> -->
                        <i class="fa-solid fa-money-bill-1-wave" style="font-size: 17px;margin-left: 2.5px;"></i>
                    </div>
                    <span class="nav-link-text ms-1">Billing</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white " href="report.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">bar_chart</i>
                    </div>
                    <span class="nav-link-text ms-1">Report</span>
                </a>
            </li>

            <!-- <li class="nav-item">
                <a class="nav-link text-white " href="report.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">lab_profile</i>
                    </div>
                    <span class="nav-link-text ms-1">Delivery Challan</span>
                </a>
            </li> -->

            <li class="nav-item">
                <a class="nav-link text-white " href="deliverychallan.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">receipt_long</i>
                    </div>
                    <span class="nav-link-text ms-1">Delivery Challan</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white " href="deliverychallan_show.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-regular fa-file-lines" style="font-size: 18px;margin-left: 2.5px;"></i>
                    </div>
                    <span class="nav-link-text ms-1">Show Challan</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white " href="company.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">apartment</i>
                    </div>
                    <span class="nav-link-text ms-1">Company</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white " href="tempo.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">local_shipping</i>
                    </div>
                    <span class="nav-link-text ms-1">Tempo</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white " href="profile.php">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">account_circle</i>
                    </div>
                    <span class="nav-link-text ms-1">Profile</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="sidenav-footer position-absolute w-100 bottom-0 ">
        <div class="mx-3">
            <a class="btn bg-gradient-primary mt-4 w-100" href="logout/index.php" type="button">Logout</a>
        </div>
    </div>
</aside>