<?php
include('conn.php');
session_start();
if (!isset($_COOKIE['email']) && !isset($_COOKIE['pass'])) {
  header("Location: http://localhost/newproject-Copy/login/index.php");
  exit;
}

if (isset($_POST['btn_company_add'])) {
  $company_logo = $_FILES['profileimg']['name'];
  $company_logo_tmp = $_FILES['profileimg']['tmp_name'];
  move_uploaded_file($company_logo_tmp, "../assets/images/company_logo/" . $company_logo);

  $company_name = $_POST['company_name'];
  $company_address = $_POST['company_address'];
  $company_mobile = $_POST['company_mobile'];
  $company_gst = $_POST['company_gst'];
  $u_id = $_POST['u_id'];

  $query_company_check_duplicate = "select company_name from company where company_name='$company_name' AND user_id='$u_id'";
  $result_company_check_duplicate = mysqli_query($con, $query_company_check_duplicate);
  if ($result_company_check_duplicate > 0) {
    session_start();
    $_SESSION['company_message'] = "Company already exist! ERROR";
    $_SESSION['icon'] = "error";
    header("Location: http://localhost/newproject-Copy/company.php");
    exit();
  } else {

    $query_add_company = "insert into company(company_name,company_address,company_mobile,company_gst,company_logo,user_id) values('$company_name','$company_address','$company_mobile','$company_gst','$company_logo','$u_id')";
    $result_add_company = mysqli_query($con, $query_add_company);
    if ($result_add_company) {
      session_start();
      $_SESSION['company_message'] = "Company added successful";
      $_SESSION['icon'] = "success";
      header("Location: http://localhost/newproject-Copy/company.php");
      exit();
    } else {
      session_start();
      $_SESSION['company_message'] = "Company not added! ERROR";
      $_SESSION['icon'] = "error";
      header("Location: http://localhost/newproject-Copy/company.php");
      exit();
    }
  }
}


if (isset($_POST['btn_company_edit'])) {
  $c_logo_temp = $_FILES['profileimg_edit']['tmp_name'];
  $c_logo = $_FILES['profileimg_edit']['name'];
  move_uploaded_file($c_logo_temp, "../assets/images/company_logo/" . $c_logo);
  $c_id = $_POST['company_id'];
  $c_name = $_POST['company_name'];
  $c_address =  $_POST['company_address'];
  $c_mobile = $_POST['company_mobile'];
  $c_gst = $_POST['company_gst'];
  $u_id = $_POST['u_id'];

  if ($c_logo_temp != '') {
    // for image selected
    $query_update_company = "update `company` set company_name='$c_name',company_address='$c_address',company_mobile='$c_mobile',company_gst='$c_gst',company_logo='$c_logo' WHERE user_id='$u_id' AND id='$c_id'";
    $result_update_company = mysqli_query($con, $query_update_company);
    if (mysqli_affected_rows($con)) {
      session_start();
      $_SESSION['company_message'] = "Company updated successful";
      $_SESSION['icon'] = "success";
      header("Location: http://localhost/newproject-Copy/company.php");
      exit();
    } else {
      session_start();
      $_SESSION['company_message'] = "No changes.";
      $_SESSION['icon'] = "error";
      header("Location: http://localhost/newproject-Copy/company.php");
      exit();
    }
  } else {
    // For image not selected
    $query_update_company = "update `company` set company_name='$c_name',company_address='$c_address',company_mobile='$c_mobile',company_gst='$c_gst' WHERE user_id='$u_id' AND id='$c_id'";
    $result_update_company = mysqli_query($con, $query_update_company);
    if (mysqli_affected_rows($con)) {
      session_start();
      $_SESSION['company_message'] = "Company updated successful";
      $_SESSION['icon'] = "success";
      header("Location: http://localhost/newproject-Copy/company.php");
      exit();
    } else {
      session_start();
      $_SESSION['company_message'] = "No changes.";
      $_SESSION['icon'] = "error";
      header("Location: http://localhost/newproject-Copy/company.php");
      exit();
    }
  }
}


if (isset($_POST['yes_btn']) && isset($_POST['delete_c_id'])) {
  $company_id = $_POST['delete_c_id'];

  $query_delete_company = "delete from company where id='$company_id'";
  $result_delete_company = mysqli_query($con, $query_delete_company);
  if ($result_delete_company) {
    session_start();
    $_SESSION['company_message'] = "Company Deleted successful";
    $_SESSION['icon'] = "success";
    header("Location: http://localhost/newproject-Copy/company.php");
    exit();
  } else {
    session_start();
    $_SESSION['company_message'] = "Company not delete! ERROR";
    $_SESSION['icon'] = "error";
    header("Location: http://localhost/newproject-Copy/company.php");
    exit();
  }
}
