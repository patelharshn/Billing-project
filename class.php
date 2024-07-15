<?php
include('command/conn.php');
// require('fpdf/fpdf.php');

// ==================================
//      FOR DOMPDF USE START
// ==================================
require('dompdf/autoload.inc.php');

use Dompdf\Dompdf;

// $options->set('isHtml5ParserEnabled', true); // Enable HTML5 parser

// ==================================
//      FOR DOMPDF USE END
// ==================================

session_start();
if (!isset($_COOKIE['email']) && !isset($_COOKIE['pass'])) {
  header("Location: http://localhost/newproject-Copy-Copy/login/index.php");
  exit;
}

$u_email = $_COOKIE['email'];

$query_uid = "select id,shopname,mobile_no,gstnumber,address,image from user where email='$u_email'";
$result = mysqli_query($con, $query_uid);
$row = mysqli_fetch_row($result);
$user_ID = $row[0];
$shop_name = $row[1];
$mobile_no = $row[2];
$gstnumber = $row[3];
$address = $row[4];
$image = $row[5];

if (isset($_POST['p_name']) && isset($_POST['u_id'])) {
  $productName = $_POST['p_name'];
  $uid = $_POST['u_id'];

  $q = "select buy_price from product where product_name='$productName' AND user_id='$uid'";
  $result = mysqli_query($con, $q);
  while ($row = mysqli_fetch_row($result)) {
    echo $row[0];
  }
}

if (isset($_POST['pname']) && isset($_POST['uid'])) {
  $productName = $_POST['pname'];
  $uid = $_POST['uid'];

  $q = "select sell_price from product where product_name='$productName' AND user_id='$uid'";
  $result = mysqli_query($con, $q);
  while ($row = mysqli_fetch_row($result)) {
    echo $row[0];
  }
}

if (isset($_POST['gst_pname']) && isset($_POST['gst_uid'])) {
  $productName = $_POST['gst_pname'];
  $uid = $_POST['gst_uid'];

  $q = "select gst from product where product_name='$productName' AND user_id='$uid'";
  $result = mysqli_query($con, $q);
  while ($row = mysqli_fetch_row($result)) {
    echo $row[0];
  }
}

if (isset($_POST['P_Name']) && isset($_POST['U_Id'])) {
  $productName = $_POST['P_Name'];
  $uid = $_POST['U_Id'];

  $q = "select id from product where product_name='$productName' AND user_id='$uid'";
  $result = mysqli_query($con, $q);
  while ($row = mysqli_fetch_row($result)) {
    echo $row[0];
  }
}

if (isset($_POST['PName']) && isset($_POST['UId'])) {
  $productName = $_POST['PName'];
  $uid = $_POST['UId'];

  $q = "select qty from product where product_name='$productName' AND user_id='$uid'";
  $result = mysqli_query($con, $q);
  while ($row = mysqli_fetch_row($result)) {
    echo $row[0];
  }
}

if (isset($_SESSION['cname'])) {
  $cid = $_SESSION['cname'];
  $query_cname = "select c_name,c_add,c_phone,gstno from customer where id='$cid'";
  $result_c_name = mysqli_query($con, $query_cname);
  while ($row_c_name = mysqli_fetch_row($result_c_name)) {
    $c_name = $row_c_name[0];
    $c_add = $row_c_name[1];
    $c_phone = $row_c_name[2];
    $c_gstno = $row_c_name[3];
  }
}


// Create a bill as PDF
if (isset($_POST['btn_bill'])) {
  if (isset($_SESSION['sales']) && count($_SESSION['sales']) != 0) {
    date_default_timezone_set("Asia/Kolkata");
    $date = date("Y-m-d");
    $cname = $c_name;
    $bill_no = $_SESSION['bill_no'];
    $payment_status = $_SESSION['payment_type'];

    $query = "insert into billing_header(customer_name,date,bill_no,payment_status,user_id) values('$cname','$date','$bill_no','$payment_status','$user_ID')";
    $result_insert_bill = mysqli_query($con, $query);
    foreach ($_SESSION['sales'] as $key => $val) {
      $pname = $val['pname'];
      $pqty = $val['qty'];
      $pprice = $val['price'];
      $ptotal = $val['total'];
      $gst_amount = $val['gst'];
      $query_insert_bill_details = "insert into billing_details(bill_no,product_name,product_qty,product_price,gst_amount,date,total,user_id) values('$bill_no','$pname','$pqty','$pprice','$gst_amount','$date','$ptotal','$user_ID')";
      $result_bill_details = mysqli_query($con, $query_insert_bill_details);
    }

    // =================================================
    //                  DOMPDF USE
    // =================================================
    $dompdf = new Dompdf();
    $path = 'assets\\images\\profile\\' . $image;
    $imageData = base64_encode(file_get_contents($path));
    $billNo = $_SESSION['bill_no'];

    $i = 1;
    $total = 0;
    $gstamount = 0;
    $taxble_value = 0;

    $html = '
<html>
<head>
<style>
  body {
    font-family: Arial, Helvetica, sans-serif, DejaVu Sans;
    margin: 0;
    padding: 0;
  }

  .invoice-header {
    padding: 10px;
    overflow: auto; /* Add this to make the logo and company info float correctly */
    width:100%;
  }
  .invoice-header img {
    width: 100px;
    height: 100px;
    margin: 10px;
    float: left;
    border-radius:50%;
  }
  .invoice-header .company-info {
    float: left;
    margin-left: 20px;
    width:60%;
  }
  .invoice-header .company-info p {
    margin-bottom: 5px;
    word-wrap: break-word; /* Add this to allow the text to wrap to the next line */
    word-break: break-all; /* Add this to break the text at any character */
  }
  .invoice-info {
    clear: both; /* Add this to move the bill to and ship to info below the company info */
    margin-top: 20px;
  }
  .invoice-info div {
    width: 45%;
    page-break-inside: avoid; /* Add this to prevent page breaks inside the address element */
  }
  .invoice-no-date {
    display: block;
    justify-content: space-between;
    margin-bottom: 20px;
  }
  .invoice-no-date div {
    width: 45%;
    justify-content: space-between;
  }
  .invoice-table {
    width: 100%;
    border-collapse: collapse;
  }
  .invoice-table th,.invoice-table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
  }
  .invoice-table th {
    background-color: #f0f0f0;
  }
  .invoice-footer {
    background-color: #f0f0f0;
    padding: 10px;
    border-top: 1px solid #ddd;
  }
  .invoice-footer p {
    margin-bottom: 10px;
  }
</style>
</head>
<body>
  <div class="invoice-container">
    <div class="invoice-header">
      <img src="data:images;base64,' . $imageData . '" alt="">
      <div class="company-info">
        <p><b>' . $shop_name . '</b></p>
        <p>' . $address . '</p>
        <p>Mobile: ' . $mobile_no . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; GSTIN: ' . $gstnumber . '</p>
      </div>
    </div>
    <div class="invoice-no-date">
      <div><b>Invoice No:</b> ' . $billNo . '</div>
      <div><b>Invoice Date:</b> ' . date("d-m-Y") . '</div>
      <hr>
    </div>
    <div class="invoice-info">
          <table class="invoice-table">
            <thead>
              <tr>
                <th colspan="2">Bill To</th>
                <th colspan="2">Ship To</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td colspan="2">
                  <p><b>' . $cname . '</b></p>
                  <p>' . $c_add . '</p>
                </td>
                <td colspan="2">
                  <p><b>' . $cname . '</b></p>
                  <p>' . $c_add . '</p>
                </td>
              </tr>
            </tbody>
          </table>
          <div style="width: 45%; float: left;">';
    if (strlen($c_phone) == 10) {
      $html .= '<p><b>Customer Mobile:</b> ' . $c_phone . '</p>';
    }
    $html .= '<p><b>GSTIN:</b> ' . $c_gstno . '</p>';
    if ($payment_status == "all") {
      $html .= '<p><b>Payment Status:</b><span style="color:blue;"> &nbsp;&nbsp;' . strtoupper($payment_status) . '</span></p>';
    } else if ($payment_status == "paid") {
      $html .= '<p><b>Payment Status:</b><span style="color:green;"> &nbsp;&nbsp;' . strtoupper($payment_status) . '</span></p>';
    } else if ($payment_status == "unpaid") {
      $html .= '<p><b>Payment Status:</b><span style="color:red;"> &nbsp;&nbsp;' . strtoupper($payment_status) . '</span></p>';
    }
    $html .= '</div>
      <div style="width: 45%; float: right;">
        <!-- Add empty space for alignment -->
      </div>
      <div style="clear: both;"></div>
    </div>
    <table class="invoice-table">
      <thead>
        <tr>
          <th>Sr.</th>
          <th>ITEMS</th>
          <th>QTY.</th>
          <th>RATE</th>
          <th>TAX</th>
          <th>TAX Amount</th>
          <th>AMOUNT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
        </tr>
      </thead>
      <tbody>';
    foreach ($_SESSION['sales'] as $key => $val) {
      $html .= '<tr>
          <td>' . $i . '</td>
          <td>' . $val['pname'] . '</td>
          <td>' . $val['qty'] . '</td>
          <td>' . number_format($val['price'], 2) . '</td>
          <td>' . $val['gstper'] . '</td>
          <td>' . number_format($val['gst'], 2) . '</td>
          <td>' . number_format(($val['price'] * $val['qty']), 2) . '</td>
        </tr>';
      $total = $total + $val['total'];
      $gstamount = $gstamount + $val['gst'];
      $taxble_value = $taxble_value + ($val['qty'] * $val['price']);
      $i++;
    }
    $html .= '</tbody>
      <tfoot>
        <tr>
          <td colspan="6" style="text-align: right; font-size: 18px;"><b>Total Taxable Value:</b></td>
          <td style="text-align: right; font-size: 18px;">₹' . number_format(($taxble_value), 2) . '</td>
        </tr>
        <tr>
          <td colspan="6" style="text-align: right; font-size: 18px;"><b>CGST:</b></td>
          <td style="text-align: right; font-size: 18px;">₹' . number_format(($gstamount / 2), 2) . '</td>
        </tr>
        <tr>
          <td colspan="6" style="text-align: right; font-size: 18px;"><b>SGST:</b></td>
          <td style="text-align: right; font-size: 18px;">₹' . number_format(($gstamount / 2), 2) . '</td>
        </tr>
        <tr>
          <td colspan="6" style="text-align: right; font-size: 18px;"><b>Total GST:</b></td>
          <td style="text-align: right; font-size: 18px;">₹' . number_format(($gstamount), 2) . '</td>
        </tr>
        <tr>
          <td colspan="6" style="text-align: right; font-size: 18px;"><b>Total:</b></td>
          <td style="text-align: right; font-size: 18px;"><b>₹' . number_format($total, 2) . '</b></td>
        </tr>
      </tfoot>
    </table>
    <div class="invoice-footer">
    <p>Thank you...Visit Again &#9786;</p>
      <p>Company Stamp: _________________________</p> <!-- added line for company stamp -->
    </div>
  </div>
</body>
</html>';


    $dompdf->loadHtml($html);
    $dompdf->render();
    $dompdf->stream($billNo . ".pdf", array("Attachment" => 0));

    unset($_SESSION['sales']);
    unset($_SESSION['cname']);
    header("Location: http://localhost/newproject-Copy/sales_extra.php");
    exit();
  } else {
    $_SESSION['sale_message'] = "No any product add for Sale...";
    $_SESSION['icon'] = "error";
    $_SESSION['title'] = "Error...";
    header("Location: http://localhost/newproject-Copy/sales_extra.php");
    exit();
  }
}

// Product Delete and Insert into Return Table
if (isset($_GET['b_no']) && $_GET['pname']) {
  $bno = $_GET['b_no'];
  $pname = $_GET['pname'];
  $customer_name = $_GET['cname'];
  $query_get_pdetails = "select product_name,product_qty,product_price,total from billing_details where bill_no='$bno' AND product_name='$pname'";
  $result_get_ddetails = mysqli_query($con, $query_get_pdetails);
  while ($row = mysqli_fetch_row($result_get_ddetails)) {
    $productname = $row[0];
    $productQty = $row[1];
    $productPrice = $row[2];
    $total = $row[3];
  }

  date_default_timezone_set("Asia/Kolkata");
  $date = date("Y-m-d");
  $query_insert_return = "insert into product_return(product_name,qty,price,total,customer_name,date,user_id) values('$productname','$productQty','$productPrice','$total','$customer_name','$date','$user_ID')";
  $result_return = mysqli_query($con, $query_insert_return);

  $query_product_return = "update product set qty=qty+'$productQty' where product_name='$pname' AND user_id='$user_ID' ";
  $result_product_return = mysqli_query($con, $query_product_return);

  $query_delete = "delete from billing_details where bill_no='$bno' AND product_name='$pname' AND user_id='$user_ID'";
  $result_delete = mysqli_query($con, $query_delete);
  $delete = mysqli_affected_rows($con);
  if ($delete > 0) {
    $_SESSION['return_message'] = "Product Returned!";
    $_SESSION['icon'] = "success";
    header("Location: http://localhost/newproject-Copy/return.php?r_bno=" . $bno);
    exit();
  } else {
    $_SESSION['return_message'] = "Product Not Return! Please try again..";
    $_SESSION['icon'] = "error";
    header("Location: http://localhost/newproject-Copy/return.php?r_bno=" . $bno);
    exit();
  }
}
