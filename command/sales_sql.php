<?php
include('../command/conn.php');

if (isset($_POST['btn_sales_add'])) {
    date_default_timezone_set("Asia/Kolkata");
    $date = date("Y-m-d h:i:sa", time());

    $u_email = $_POST['u_email'];
    $u_id = $_POST['u_id'];
    $prod_name = $_POST['prod_name'];
    $s_qty = $_POST['s_qty'];
    $s_price = $_POST['s_price'];
    $c_name = $_POST['c_name'];

    $query_cusid = "select id from customer where c_name='$c_name' AND u_id='$u_id'";
    $result_cusid = mysqli_query($con, $query_cusid);
    $row_cusid = mysqli_fetch_row($result_cusid);
    $cid = $row_cusid[0];

    $query = "select id,profit,qty from product where product_name='$prod_name' AND user_id='$u_id'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_row($result);
    $p_id = $row[0];
    $profit = $row[1];
    $qty = $row[2];

    $total_cost = $s_qty * $s_price;
    $t_profit = $profit * $s_qty;

    if ($s_qty <= $qty) {
        $insert_query = "insert into sales (s_qty,total_amount,total_profit,date,pid,uid,c_id) values('$s_qty','$total_cost','$t_profit','$date','$p_id','$u_id','$cid')";
        $insert_result = mysqli_query($con, $insert_query);
        $row = mysqli_affected_rows($con);

        if ($row > 0) {
            $update_query = "update product set qty=qty-'$s_qty' where id='$p_id'";
            $update_result = mysqli_query($con, $update_query);
            $update_row = mysqli_affected_rows($con);
            if ($update_row > 0) {
                session_start();
                $_SESSION['purchase_message'] = "Sales Record Added Successfully!";
                $_SESSION['icon'] = "success";
                $_SESSION['title'] = "Success...";
                header("Location: http://localhost/newproject-Copy/sales.php");
                exit();
            }
        } else {
            session_start();
            $_SESSION['purchase_message'] = "Sales Record Not Add";
            $_SESSION['icon'] = "error";
            $_SESSION['title'] = "Error...";
            $_SESSION['mail'] = '';
            header("Location: http://localhost/newproject-Copy/sales.php");
            exit();
        }
    } else {
        session_start();
        $_SESSION['purchase_message'] = "Quantity Is Not Available";
        $_SESSION['icon'] = "error";
        $_SESSION['title'] = "Error...";
        $_SESSION['mail'] = '';
        header("Location: http://localhost/newproject-Copy/sales.php");
        exit();
    }
}
