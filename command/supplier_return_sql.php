<?php

include('../command/conn.php');

if (isset($_POST['btn_s_return_add'])) {
    date_default_timezone_set("Asia/Kolkata");
    $date = date("Y-m-d h:i:sa", time());

    $u_email = $_POST['u_email'];
    $u_id = $_POST['u_id'];
    $prod_name = $_POST['prod_name'];
    $supplier_name = $_POST['supplier_name'];
    $p_qty = $_POST['p_qty'];

    // echo $u_email . " " . $u_id . " " . $prod_name . " " . $supplier_name . " " . $p_qty;
    $query = "select qty,id from product where product_name='$prod_name' AND user_id='$u_id'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_row($result);
    $qty = $row[0];
    $p_id = $row[1];

    if ($p_qty <= $qty) {
        // id	product_name	supplier_name	qty	date	user_id
        $insert_query = "insert into supplier_return(product_name,supplier_name,qty,date,user_id) values('$prod_name','$supplier_name','$p_qty','$date','$u_id')";
        $insert_result = mysqli_query($con, $insert_query);
        $row = mysqli_affected_rows($con);

        if ($row > 0) {
            $update_query = "update product set qty=qty-'$p_qty' where id='$p_id'";
            $update_result = mysqli_query($con, $update_query);
            $update_row = mysqli_affected_rows($con);
            if ($update_row > 0) {
                session_start();
                $_SESSION['purchase_message'] = "Return Record Added Successfully!";
                $_SESSION['icon'] = "success";
                $_SESSION['title'] = "Success...";
                header("Location: http://localhost/newproject-Copy/supplier_return.php");
                exit();
            }
        } else {
            session_start();
            $_SESSION['purchase_message'] = "Return Record Not Add";
            $_SESSION['icon'] = "error";
            $_SESSION['title'] = "Error...";
            $_SESSION['mail'] = '';
            header("Location: http://localhost/newproject-Copy/supplier_return.php");
            exit();
        }
    } else {
        session_start();
        $_SESSION['purchase_message'] = "Quantity Is Not Available";
        $_SESSION['icon'] = "error";
        $_SESSION['title'] = "Error...";
        $_SESSION['mail'] = '';
        header("Location: http://localhost/newproject-Copy/supplier_return.php");
        exit();
    }
}
