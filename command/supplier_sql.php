<?php
include('conn.php');

if (isset($_POST['btn_supplier_add'])) {
    $umail = $_POST['u_email'];
    $u_id = $_POST['u_id'];
    $s_companyName = $_POST['s_companyName'];
    $s_name = $_POST['s_name'];
    $s_address = $_POST['s_address'];
    $s_phone = $_POST['s_phone'];

    $query_duplicate = "select * from supplier where user_id='$u_id'";
    $result_duplicate = mysqli_query($con, $query_duplicate);
    $row_duplicate = mysqli_fetch_row($result_duplicate);

    $row_sphone = $row_duplicate[3];

    if ($row_sphone == $s_phone) {
        session_start();
        $_SESSION['product_message'] = "Supplier Already Exist...Please Check";
        $_SESSION['icon'] = "error";
        $_SESSION['title'] = "Error...";
        header("Location: http://localhost/newproject-Copy/supplier.php");
        exit();
    } else {
        //id supplier_name	supplier_address	supplier_phone	supplier_companyname	user_id
        $query = "insert into supplier(supplier_name,supplier_address,supplier_phone,supplier_companyname,user_id) values('$s_name','$s_address','$s_phone','$s_companyName','$u_id')";
        $result = mysqli_query($con, $query);
        $row = mysqli_affected_rows($con);

        if ($row >= 0) {
            session_start();
            $_SESSION['product_message'] = "Supplier Added Successfully!";
            $_SESSION['icon'] = "success";
            $_SESSION['title'] = "Success...";
            header("Location: http://localhost/newproject-Copy/supplier.php");
            exit();
        } else {
            session_start();
            $_SESSION['product_message'] = "Supplier Not Add";
            $_SESSION['icon'] = "error";
            $_SESSION['title'] = "Error...";
            $_SESSION['mail'] = '';
            header("Location: http://localhost/newproject-Copy/supplier.php");
            exit();
        }
    }
}


if (isset($_POST['btn_supplier_edit'])) {
    $umail = $_POST['u_email'];
    $s_id = $_POST['s_id'];
    $s_companyName = $_POST['s_companyName'];
    $s_name = $_POST['s_name'];
    $s_address = $_POST['s_address'];
    $s_phone = $_POST['s_phone'];

    session_start();

    // supplier_name	supplier_address	supplier_phone	supplier_companyname	user_id
    $query_edit = "update supplier set supplier_name='$s_name' , supplier_address='$s_address', supplier_phone='$s_phone',supplier_companyname='$s_companyName' where id='$s_id'";
    $result = mysqli_query($con, $query_edit);
    $row = mysqli_affected_rows($con);

    if ($row > 0) {
        // echo "Update Product!!";
        $_SESSION['icon'] = "success";
        $_SESSION['title'] = "Success...";
        $_SESSION['message'] = "Supplier Update Successfully!";
        header("Location: http://localhost/newproject-Copy/supplier.php");
        exit();
    } else {
        echo "Not Update Product.....";
        $_SESSION['icon'] = "error";
        $_SESSION['title'] = "Error...";
        $_SESSION['message'] = "Customer Not Update...";
        header("Location: http://localhost/newproject-Copy/supplier.php");
        exit();
    }
}


if (isset($_POST['yes_btn'])) {
    $delete_id = $_POST['delete_s_id'];

    session_start();

    $query_p_id = "delete from supplier where id='$delete_id'";
    $result = mysqli_query($con, $query_p_id);
    $row = mysqli_affected_rows($con);
    if ($row > 0) {
        // echo "Product Deleted!";
        $_SESSION['icon'] = "success";
        $_SESSION['title'] = "Success...";
        $_SESSION['delete_message'] = "Supplier Deleted Successfully!";
        header("Location: http://localhost/newproject-Copy/supplier.php");
        exit();
    } else {
        // echo "Product Not Delete";
        $_SESSION['icon'] = "error";
        $_SESSION['title'] = "Error...";
        $_SESSION['delete_message'] = "Supplier Not Deleted...";
        header("Location: http://localhost/newproject-Copy/supplier.php");
        exit();
    }
}
