<?php
ob_start();
include('header.php');
include('command/conn.php');
session_start();
if (!isset($_COOKIE['email']) && !isset($_COOKIE['pass'])) {
    header("Location: http://localhost/newproject-Copy/login/index.php");
    exit;
}
$email = $_COOKIE['email'];

$user_id = "select id from user where email='$email'";
$result_uid = mysqli_query($con, $user_id);
$row = mysqli_fetch_row($result_uid);
$uid = $row[0];

$query_count_product = "select * from product where user_id='$uid'";
$result_product = mysqli_query($con, $query_count_product);
$t_product = mysqli_num_rows($result_product);

$query_count_purchase = "select * from purchase where user_id='$uid'";
$result_purchase = mysqli_query($con, $query_count_purchase);
$t_purchase = mysqli_num_rows($result_purchase);

$query_count_sales = "select * from billing_details where user_id='$uid'";
$result_sales = mysqli_query($con, $query_count_sales);
$total_sales = mysqli_num_rows($result_sales);

$query_count_customer = "select * from customer where u_id='$uid'";
$result_customer = mysqli_query($con, $query_count_customer);
$t_customer = mysqli_num_rows($result_customer);

$query_count_supplier = "select * from supplier where user_id='$uid'";
$result_supplier = mysqli_query($con, $query_count_supplier);
$t_supplier = mysqli_num_rows($result_supplier);

$query_count_return = "select * from product_return where user_id='$uid'";
$result_return = mysqli_query($con, $query_count_return);
$t_return = mysqli_num_rows($result_return);



$t_sales = $t_return + $total_sales;
?>

<!-- Slider Start -->
<div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner mb-4">
        <div class="carousel-item active">
            <div class="page-header min-vh-75 m-3 border-radius-xl" style="background-image: url('assets/images/1.png');">
                <span class="mask bg-gradient-dark"></span>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 my-auto">
                            <h1 class="text-white fadeIn2 fadeInBottom">Purchase</h1>
                            <p class="lead text-white opacity-8 fadeIn3 fadeInBottom">Automate procurement, streamline stock intake, and optimize inventory with our advanced purchase module.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <div class="page-header min-vh-75 m-3 border-radius-xl" style="background-image: url('assets/images/2.png');">
                <span class="mask bg-gradient-dark"></span>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 my-auto">
                            <h1 class="text-white fadeIn2 fadeInBottom">Sales</h1>
                            <p class="lead text-white opacity-8 fadeIn3 fadeInBottom">Maximize sales efficiency with our inventory management system's comprehensive sales tracking capabilities.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <div class="page-header min-vh-75 m-3 border-radius-xl" style="background-image: url('assets/images/3.png');">
                <span class="mask bg-gradient-dark"></span>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 my-auto">
                            <h1 class="text-white fadeIn2 fadeInBottom">Return</h1>
                            <p class="lead text-white opacity-8 fadeIn3 fadeInBottom">Simplify returns, enhance accuracy, and optimize inventory control with our robust return module.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="min-vh-75 position-absolute w-100 top-0">
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon position-absolute bottom-50" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon position-absolute bottom-50" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </a>
    </div>
</div>
<!-- Slider End -->


<!-- Cards Start -->
<div class="container">
    <div class="row">
        <div class="col-lg-3 col-sm-3 mt-sm-4 mt-4">
            <div class="card  mb-2">
                <div class="card-header p-3 pt-2 bg-transparent">
                    <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">shopping_cart</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize ">Total Products</p>
                        <h4 class="mb-0 "><?php echo $t_product; ?></h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-3 mt-sm-4 mt-4">
            <div class="card  mb-2">
                <div class="card-header p-3 pt-2 bg-transparent">
                    <div class="icon icon-lg icon-shape bg-gradient-secondary shadow-secondary text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">shop_two</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize ">Total Purchases</p>
                        <h4 class="mb-0 "><?php echo $t_purchase; ?></h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-sm-3 mt-sm-4 mt-4">
            <div class="card  mb-2">
                <div class="card-header p-3 pt-2 bg-transparent">
                    <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">storefront</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize ">Total Sales</p>
                        <h4 class="mb-0 "><?php echo $t_sales; ?></h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="col-lg-3 col-sm-3 mt-sm-4 mt-4">
            <div class="card  mb-2">
                <div class="card-header p-3 pt-2 bg-transparent">
                    <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">refresh</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize ">Total Returns</p>
                        <h4 class="mb-0 "><?php echo $t_return; ?></h4>
                    </div>
                </div>
            </div>
        </div> -->

        <div class="col-lg-3 col-sm-3 mt-sm-4 mt-4">
            <div class="card  mb-2">
                <div class="card-header p-3 pt-2 bg-transparent">
                    <div class="icon icon-lg icon-shape bg-gradient-warning shadow-warning text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">person_add</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize ">Total Customer</p>
                        <h4 class="mb-0 "><?php echo $t_customer; ?></h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="col-lg-3 col-sm-3 mt-sm-4 mt-4">
            <div class="card  mb-2">
                <div class="card-header p-3 pt-2 bg-transparent">
                    <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">store</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize ">Total Supplier</p>
                        <h4 class="mb-0 "><?php echo $t_supplier; ?></h4>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
</div>
<!-- Cards End -->



<?php include('footer.php'); ?>