<?php

include('conn.php');
require('../fpdf/fpdf.php');
session_start();
if (!isset($_COOKIE['email']) && !isset($_COOKIE['pass'])) {
    header("Location: http://localhost/newproject-Copy/login/index.php");
    exit;
}

$email = $_COOKIE['email'];

$query_uid = "select id from user where email='$email'";
$result = mysqli_query($con, $query_uid);
$row = mysqli_fetch_row($result);
if ($row >= 0) {
    $u_id = $row[0];
} else {
    echo "User ID Not found";
}

if (isset($_POST['sd']) && isset($_POST['ed']) && $_POST['action'] == 'purchase') {
    $st_date = $_POST['sd'];
    $end_date = $_POST['ed'];
?>

    <table id='table_data_search' class='table table-bordered table-striped'>
        <thead>
            <tr class='text-center'>
                <th>ID</th>
                <th>Product Name</th>
                <th>Qty</th>
                <th>Total Cost</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody id='result_data'>
            <?php
            $i = 1;
            $query = "select purchase.id,product.product_name,purchase.qty,purchase.total_cost,purchase.time from purchase,product where purchase.user_id='$u_id' AND product.id = purchase.p_id AND purchase.time>='$st_date' AND purchase.time<='$end_date'";
            $product_show_result = mysqli_query($con, $query);
            $records = mysqli_num_rows($product_show_result);
            if ($records > 0) {
                while ($row = mysqli_fetch_row($product_show_result)) { ?>
                    <tr class='text-center'>
                        <td> <?php echo $i; ?></td>
                        <td> <?php echo $row[1]; ?></td>
                        <td> <?php echo $row[2]; ?></td>
                        <td> <?php echo $row[3]; ?></td>
                        <td> <?php echo $row[4]; ?></td>
                    </tr>
            <?php $i++;
                }
            } else {
                echo "<script>
                Swal.fire({
                    icon: 'error',
                    text: 'Record Not Found..',
                    showConfirmButton: false,
                    timer: 2700,
                    toast: true,
                    position: 'top',
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                </script>";
            } ?>
        </tbody>
    </table>
    <form action="./command/report_class.php" method="post">
        <div class="container">
            <center>
                <input hidden type="text" name="start_date" id="start_date" value="<?php echo $st_date; ?>">
                <input hidden type="text" name="end_date" id="end_date" value="<?php echo $end_date; ?>">
                <input hidden type="text" name="userID" id="userID" value="<?php echo $u_id; ?>">
                <input type="submit" class="btn btn-info" name="purchase_btn_pdf" id="btn_pdf" value="Download PDF">
            </center>
        </div>
    </form>
<?php
}

if (isset($_POST['sd']) && isset($_POST['ed']) && isset($_POST['customer']) && $_POST['action'] == 'sales') {
    $st_date = $_POST['sd'];
    $end_date = $_POST['ed'];
    $customer = $_POST['customer'];
    $status = $_POST['status'];

    if ($status == 'all') {
        $query_billno = "select bill_no from billing_header where user_id='$u_id' AND customer_name='$customer' AND date>='$st_date' AND date<='$end_date'";
    } else {
        $query_billno = "select bill_no from billing_header where user_id='$u_id' AND customer_name='$customer' AND date>='$st_date' AND date<='$end_date' AND payment_status='$status'";
    }
    $result_billno = mysqli_query($con, $query_billno);
    $show_bill_result = mysqli_num_rows($result_billno);
?>
    <table id='table_data_search' class='table table-bordered table-striped'>
        <thead>
            <tr class='text-center'>
                <th>ID</th>
                <th>Bill No</th>
                <th>Product Name</th>
                <th>Qty</th>
                <th>Unit Price</th>
                <th>Total</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody id='result_data'>
            <?php
            $i = 1;
            if ($show_bill_result > 0) {
                while ($row_billno = mysqli_fetch_row($result_billno)) {
                    $billNo = $row_billno[0];
                    $query = "select product_name,product_qty,product_price,total,date from billing_details where user_id='$u_id' AND bill_no='$billNo'";
                    $product_show_result = mysqli_query($con, $query);
                    $records = mysqli_num_rows($product_show_result);
                    if ($records > 0) {
                        while ($row = mysqli_fetch_row($product_show_result)) { ?>
                            <tr class='text-center'>
                                <td> <?php echo $i; ?></td>
                                <td> <?php echo $billNo; ?></td>
                                <td> <?php echo $row[0]; ?></td>
                                <td> <?php echo $row[1]; ?></td>
                                <td> <?php echo number_format($row[2]) ?></td>
                                <td> <?php echo number_format($row[3]) ?></td>
                                <td> <?php echo $row[4]; ?></td>
                            </tr>
            <?php $i++;
                        }
                    } else {
                        echo "<script>
                Swal.fire({
                    icon: 'error',
                    text: 'Record Not Found..',
                    showConfirmButton: false,
                    timer: 2700,
                    toast: true,
                    position: 'top',
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                </script>";
                    }
                }
            } else {
                echo "<script>
                Swal.fire({
                    icon: 'error',
                    text: 'Record Not Found..',
                    showConfirmButton: false,
                    timer: 2700,
                    toast: true,
                    position: 'top',
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                </script>";
            } ?>
        </tbody>
    </table>
    <form action="./command/report_class.php" method="post">
        <div class="container">
            <center>
                <input hidden type="text" name="start_date" id="start_date" value="<?php echo $st_date; ?>">
                <input hidden type="text" name="end_date" id="end_date" value="<?php echo $end_date; ?>">
                <input hidden type="text" name="userID" id="userID" value="<?php echo $u_id; ?>">
                <input hidden type="text" name="customername" id="c_name" value="<?php echo $customer; ?>">
                <input hidden type="text" name="status" id="status" value="<?php echo $status; ?>">
                <input type="submit" class="btn btn-info" name="sales_btn_pdf" id="btn_pdf" value="Download PDF">
            </center>
        </div>
    </form>
<?php
}

if (isset($_POST['sd']) && isset($_POST['ed']) && $_POST['action'] == 'return') {
    $st_date = $_POST['sd'];
    $end_date = $_POST['ed'];
?>
    <table id='table_data_search' class='table table-bordered table-striped'>
        <thead>
            <tr class='text-center'>
                <th>ID</th>
                <th>Product Name</th>
                <th>Qty</th>
                <th>Unit Price</th>
                <th>Total</th>
                <th>Customer Name</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody id='result_data'>
            <?php
            $i = 1;
            $query = "select product_name,qty,price,total,customer_name,date from product_return where user_id='$u_id' AND date>='$st_date' AND date<='$end_date'";
            $product_show_result = mysqli_query($con, $query);
            $records = mysqli_num_rows($product_show_result);
            if ($records > 0) {
                while ($row = mysqli_fetch_row($product_show_result)) { ?>
                    <tr class='text-center'>
                        <td> <?php echo $i; ?></td>
                        <td> <?php echo $row[0]; ?></td>
                        <td> <?php echo $row[1]; ?></td>
                        <td> <?php echo $row[2]; ?></td>
                        <td> <?php echo $row[3]; ?></td>
                        <td> <?php echo $row[4]; ?></td>
                        <td> <?php echo $row[5]; ?></td>
                    </tr>
            <?php $i++;
                }
            } else {
                echo "<script>
                Swal.fire({
                    icon: 'error',
                    text: 'Record Not Found..',
                    showConfirmButton: false,
                    timer: 2700,
                    toast: true,
                    position: 'top',
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                </script>";
            } ?>
        </tbody>
    </table>
    <form action="./command/report_class.php" method="post">
        <div class="container">
            <center>
                <input hidden type="text" name="start_date" id="start_date" value="<?php echo $st_date; ?>">
                <input hidden type="text" name="end_date" id="end_date" value="<?php echo $end_date; ?>">
                <input hidden type="text" name="userID" id="userID" value="<?php echo $u_id; ?>">
                <input type="submit" class="btn btn-info" name="return_btn_pdf" id="btn_pdf" value="Download PDF">
            </center>
        </div>
    </form>
<?php
}
