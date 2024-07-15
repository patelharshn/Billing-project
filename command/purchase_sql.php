<?php
include('../command/conn.php');

if (isset($_POST['btn_purchase_add'])) {
    date_default_timezone_set("Asia/Kolkata");
    $date = date("Y-m-d");
    $u_email = $_POST['u_email'];
    $u_id = $_POST['u_id'];
    $prod_name = $_POST['prod_name'];
    $p_qty = $_POST['p_qty'];
    $p_price = $_POST['b_price'];
    $supplier_name = $_POST['supplier_name'];

    $query = "select id from product where product_name='$prod_name' AND user_id='$u_id'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_row($result);
    $p_id = $row[0];

    $query_supplier_id = "select id from supplier where supplier_name='$supplier_name' AND user_id='$u_id'";
    $reslut_supplier_id =  mysqli_query($con, $query_supplier_id);
    $row_supplier_id = mysqli_fetch_row($reslut_supplier_id);
    $sup_id = $row_supplier_id[0];

    $total_cost = $p_qty * $p_price;

    $insert_query = "insert into purchase (qty,total_cost,time,p_id,user_id,sup_id) values('$p_qty','$total_cost','$date','$p_id','$u_id','$sup_id')";
    $insert_result = mysqli_query($con, $insert_query);
    $row = mysqli_affected_rows($con);

    if ($row > 0) {
        $update_query = "update product set qty=qty+'$p_qty' where id='$p_id'";
        $update_result = mysqli_query($con, $update_query);
        $update_row = mysqli_affected_rows($con);
        if ($update_row > 0) {
            session_start();
            $_SESSION['purchase_message'] = "Purchase Record Added Successfully!";
            $_SESSION['icon'] = "success";
            $_SESSION['title'] = "Success...";
            header("Location: http://localhost/newproject-Copy/purchase.php");
            exit();
        }
    } else {
        session_start();
        $_SESSION['purchase_message'] = "Purchase Record Not Add";
        $_SESSION['icon'] = "error";
        $_SESSION['title'] = "Error...";
        $_SESSION['mail'] = '';
        header("Location: http://localhost/newproject-Copy/purchase.php");
        exit();
    }
}
