<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CDN Sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
</body>

</html>
<?php
ob_start();
include('command/conn.php');
session_start();
// session_destroy();

if (isset($_POST['bill_no']) && isset($_POST['p_name']) && isset($_POST['p_id']) && isset($_POST['c_name']) && isset($_POST['p_qty']) && isset($_POST['p_price']) && isset($_POST['p_total']) && isset($_POST['gst'])) {
    $id = $_POST['p_id'];
    $pqty = $_POST['p_qty'];
    $u_email = $_COOKIE['email'];
    $prod_name = $_POST['p_name'];
    $gst_amount = $_POST['gst'];
    $gst_per = $_POST['gst_per'];
    $_SESSION['cname'] = $_POST['c_name'];
    $_SESSION['pid'] = $id;
    $_SESSION['bill_no'] = $_POST['bill_no'];
    $_SESSION['payment_type'] = $_POST['payment_type'];

    $query_uid = "select id from user where email='$u_email'";
    $result = mysqli_query($con, $query_uid);
    $row = mysqli_fetch_row($result);

    $query = "select id,profit,qty from product where product_name='$prod_name' AND user_id='$row[0]'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_row($result);
    $p_id = $row[0];
    $profit = $row[1];
    $p_qty = $row[2];

    if (isset($_SESSION['sales'][$id])) {
        $old = $_SESSION['sales'][$id]['qty'];
        $old_gst = $_SESSION['sales'][$id]['gst'];
        $_SESSION['sales'][$id] = array("pid" => $id, "pname" => $_POST['p_name'], "qty" => $old + $_POST['p_qty'], "price" => $_POST['p_price'], "gst" => ($_POST['gst'] + $old_gst), "gstper" => $gst_per, "total" => ($_POST['p_price'] * ($old + $_POST['p_qty'])) + ($_POST['gst'] + $old_gst));
    } else {
        $_SESSION['sales'][$id] = array("pid" => $id, "pname" => $_POST['p_name'], "qty" => $_POST['p_qty'], "price" => $_POST['p_price'], "gst" => $_POST['gst'], "gstper" => $gst_per, "total" => $_POST['p_total']);
    }
}


if (isset($_POST['action'])) {
    $pName = $_POST['p__name'];

    foreach ($_SESSION['sales'] as $key => $val) {
        if ($val['pname'] == $pName) {
            unset($_SESSION['sales'][$key]);
            $_SESSION['sales'] = array_values($_SESSION['sales']);
        }
    }
}
