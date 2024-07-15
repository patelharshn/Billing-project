<?php
include('conn.php');

// shopname,email,username,mobile_no,pincode,first_name,last_name,state,image
if (isset($_POST['update_btn'])) {
    $filename = $_FILES['profileimg']['name'];
    $ftemp = $_FILES['profileimg']['tmp_name'];

    $uname = $_POST['uname'];
    $address = $_POST['address'];
    // $fname = $_POST['fname'];
    // $lname = $_POST['lname'];
    $phone = $_POST['phone'];
    $shop = $_POST['shop'];
    // $pincode = $_POST['pincode'];
    $gstno = $_POST['gstno'];
    $state = $_POST['state'];
    $email = $_POST['email'];

    $query_select = "select image from user where email='$email'";
    $result_select = mysqli_query($con, $query_select);
    $row_select = mysqli_fetch_row($result_select);
    $images = $row_select[0];

    if ($ftemp != '') {
        $query_update = "update user set shopname='$shop',username='$uname',mobile_no='$phone',gstnumber='$gstno',address='$address',state='$state',image='$filename' where email='$email'";
        $result_update = mysqli_query($con, $query_update);
        $row = mysqli_affected_rows($con);

        if ($row > 0) {
            move_uploaded_file($ftemp, "../assets/images/profile/" . $filename);
            unlink("../assets/images/profile/$images");
            session_start();
            $_SESSION['update_message'] = "Profile Update Successfully!";
            $_SESSION['icon'] = "success";
            $_SESSION['title'] = "Success...";
            header("Location: http://localhost/newproject-Copy/profile.php");
            exit();
        } else {
            session_start();
            $_SESSION['update_message'] = "Profile Not Update...";
            $_SESSION['icon'] = "error";
            $_SESSION['title'] = "Error...";
            header("Location: http://localhost/newproject-Copy/profile.php");
            exit();
        }
    } else {
        $query = "update user set shopname='$shop',username='$uname',mobile_no='$phone',gstnumber='$gstno',address='$address',state='$state'where email='$email'";
        $result = mysqli_query($con, $query);
        $rows = mysqli_affected_rows($con);

        if ($rows > 0) {
            session_start();
            $_SESSION['update_message'] = "Profile Update Successfully!";
            $_SESSION['icon'] = "success";
            $_SESSION['title'] = "Success...";
            header("Location: http://localhost/newproject-Copy/profile.php");
            exit();
        } else {
            session_start();
            $_SESSION['update_message'] = "No Any Changes..";
            $_SESSION['icon'] = "error";
            $_SESSION['title'] = "Error...";
            header("Location: http://localhost/newproject-Copy/profile.php");
            exit();
        }
    }
}
