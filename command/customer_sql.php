<?php
include('conn.php');

if (isset($_POST['btn_customer_add'])) {
    $umail = $_POST['u_email'];
    $u_id = $_POST['u_id'];
    $c_name = $_POST['c_name'];
    $c_add = $_POST['c_address'];
    $c_phone = $_POST['c_phone'];
    $c_gstno = $_POST['gstno'];

    // $query_duplicate = "select * from customer where u_id='$u_id'";
    $query_duplicate = "select c_name from customer where u_id='$u_id' and c_name='$c_name'";
    $result_duplicate = mysqli_query($con, $query_duplicate);
    // $row_duplicate = mysqli_fetch_row($result_duplicate);
    while ($row_duplicate = mysqli_fetch_row($result_duplicate)) {
        // $row_cphone = $row_duplicate[3];
        $row_cphone = $row_duplicate[0];
    }

    if ($row_cphone > 0) {
        session_start();
        $_SESSION['product_message'] = "Customer Already Exist...Please Check";
        $_SESSION['icon'] = "error";
        $_SESSION['title'] = "Error...";
        header("Location: http://localhost/newproject-Copy/customer.php");
        exit();
    } else {
        $query = "insert into customer(c_name,c_add,c_phone,gstno,u_id) values('$c_name','$c_add','$c_phone','$c_gstno','$u_id')";
        $result = mysqli_query($con, $query);
        $row = mysqli_affected_rows($con);

        if ($row >= 0) {
            session_start();
            $_SESSION['product_message'] = "Customer Added Successfully!";
            $_SESSION['icon'] = "success";
            $_SESSION['title'] = "Success...";
            header("Location: http://localhost/newproject-Copy/customer.php");
            exit();
        } else {
            session_start();
            $_SESSION['product_message'] = "Customer Not Add";
            $_SESSION['icon'] = "error";
            $_SESSION['title'] = "Error...";
            $_SESSION['mail'] = '';
            header("Location: http://localhost/newproject-Copy/customer.php");
            exit();
        }
    }
}


if (isset($_POST['btn_customer_edit'])) {
    $umail = $_POST['u_email'];
    $c_id = $_POST['c_id'];
    $c_name = $_POST['c_name'];
    $c_add = $_POST['c_address'];
    $c_phone = $_POST['c_phone'];
    $c_gstno = $_POST['gstno'];

    session_start();

    $query_edit = "update customer set c_name='$c_name' , c_add='$c_add', c_phone='$c_phone', gstno='$c_gstno' where id='$c_id'";
    $result = mysqli_query($con, $query_edit);
    $row = mysqli_affected_rows($con);

    if ($row > 0) {
        // echo "Update Product!!";
        $_SESSION['icon'] = "success";
        $_SESSION['title'] = "Success...";
        $_SESSION['message'] = "Customer Update Successfully!";
        header("Location: http://localhost/newproject-Copy/customer.php");
        exit();
    } else {
        echo "Not Update Product.....";
        $_SESSION['icon'] = "error";
        $_SESSION['title'] = "Error...";
        $_SESSION['message'] = "Customer Not Update...";
        header("Location: http://localhost/newproject-Copy/customer.php");
        exit();
    }
}


if (isset($_POST['yes_btn'])) {
    $delete_id = $_POST['delete_p_id'];

    session_start();

    $query_p_id = "delete from customer where id='$delete_id'";
    $result = mysqli_query($con, $query_p_id);
    $row = mysqli_affected_rows($con);
    if ($row > 0) {
        // echo "Product Deleted!";
        $_SESSION['icon'] = "success";
        $_SESSION['title'] = "Success...";
        $_SESSION['delete_message'] = "Customer Deleted Successfully!";
        header("Location: http://localhost/newproject-Copy/customer.php");
        exit();
    } else {
        // echo "Product Not Delete";
        $_SESSION['icon'] = "error";
        $_SESSION['title'] = "Error...";
        $_SESSION['delete_message'] = "Customer Not Deleted...";
        header("Location: http://localhost/newproject-Copy/customer.php");
        exit();
    }
}
