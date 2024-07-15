<?php
ob_start();
include('command/conn.php');
require('dompdf/autoload.inc.php');

use Dompdf\Dompdf;

session_start();
if (!isset($_COOKIE['email']) && !isset($_COOKIE['pass'])) {
    header("Location: http://localhost/newproject-Copy/login/index.php");
    exit;
}

$userid = $_COOKIE['email'];
$query_uid = "select id,shopname,mobile_no,gstnumber,address,image from user where email='$userid'";
$result_users = mysqli_query($con, $query_uid);
$row_user = mysqli_fetch_row($result_users);
$user_ID = $row_user[0];
$shop_name = $row_user[1];
$mobile_no = $row_user[2];
$gstnumber = $row_user[3];
$address = $row_user[4];
$image = $row_user[5];

if (isset($_GET['b_no'])) {
    $bno = $_GET['b_no'];
}
if (isset($bno)) {
    $query_cname = "select customer_name,date,payment_status from billing_header where bill_no='$bno'";
    $result_cname = mysqli_query($con, $query_cname);
    while ($row_c = mysqli_fetch_row($result_cname)) {
        $customerName = $row_c[0];
        // $date = $row[1];
        $dt = $row_c[1];
        $date_c = strstr($dt, ' ', true);
        $status = $row_c[2];
    }

    $query_cdetails = "select c_add,c_phone,gstno from customer where c_name='$customerName'";
    $result_cdetails = mysqli_query($con, $query_cdetails);
    while ($row = mysqli_fetch_row($result_cdetails)) {
        $customer_add = $row[0];
        $customer_phone = $row[1];
        $customer_gstno = $row[2];
    }

    // =================================================
    //                  DOMPDF USE
    // =================================================
    $dompdf = new Dompdf();
    $path = 'assets\\images\\profile\\' . $image;
    $imageData = base64_encode(file_get_contents($path));

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
      <div><b>Invoice No:</b> ' . $bno . '</div>
      <div><b>Invoice Date:</b> ' . $dt . '</div>
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
                  <p><b>' . $customerName . '</b></p>
                  <p>' . $customer_add . '</p>
                </td>
                <td colspan="2">
                  <p><b>' . $customerName . '</b></p>
                  <p>' . $customer_add . '</p>
                </td>
              </tr>
            </tbody>
          </table>
          <div style="width: 45%; float: left;">';
    if (strlen($customer_phone) == 10) {
        $html .= '<p><b>Customer Mobile:</b> ' . $customer_phone . '</p>';
    }
    $html .= '<p><b>GSTIN:</b> ' . $customer_gstno . '</p>';
    if ($status == "all") {
        $html .= '<p><b>Payment Status:</b><span style="color:blue;"> &nbsp;&nbsp;' . strtoupper($status) . '</span></p>';
    } else if ($status == "paid") {
        $html .= '<p><b>Payment Status:</b><span style="color:green;"> &nbsp;&nbsp;' . strtoupper($status) . '</span></p>';
    } else if ($status == "unpaid") {
        $html .= '<p><b>Payment Status:</b><span style="color:red;"> &nbsp;&nbsp;' . strtoupper($status) . '</span></p>';
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
    $query_bill_detail = "select product_name,product_qty,product_price,total,gst_amount from billing_details where bill_no='$bno'";
    $result_bill_detail = mysqli_query($con, $query_bill_detail);
    while ($val = mysqli_fetch_row($result_bill_detail)) {
        $query_p_gst = "select gst from product where product_name='$val[0]' AND user_id='$user_ID'";
        $result_p_gst = mysqli_query($con, $query_p_gst);
        $row_p_gst = mysqli_fetch_row($result_p_gst);
        $html .= '<tr>
          <td>' . $i . '</td>
          <td>' . $val[0] . '</td>
          <td>' . $val[1] . '</td>
          <td>' . number_format($val[2], 2) . '</td>
          <td>' . $row_p_gst[0] . '%' . '</td>
          <td>' . number_format($val[4], 2) . '</td>
          <td>' . number_format(($val[1] * $val[2]), 2) . '</td>
        </tr>';
        $total = $total + $val[3];
        $gstamount = $gstamount + $val[4];
        $taxble_value = $taxble_value + ($val[1] * $val[2]);
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
    $dompdf->stream($bno . ".pdf", array("Attachment" => 0));
}

// if (isset($_GET['d_bno'])) {
//     $download = $_GET['d_bno'];
// }
// if (isset($download)) {
//     $query_cname = "select customer_name,date from billing_header where bill_no='$download'";
//     $result_cname = mysqli_query($con, $query_cname);
//     while ($row = mysqli_fetch_row($result_cname)) {
//         $customerName = $row[0];
//         // $date = $row[1];
//         $dt = $row[1];
//         $date = strstr($dt, ' ', true);
//     }

//     $query_cdetails = "select c_add,c_phone from customer where c_name='$customerName'";
//     $result_cdetails = mysqli_query($con, $query_cdetails);
//     while ($row = mysqli_fetch_row($result_cdetails)) {
//         $customer_add = $row[0];
//         $customer_phone = $row[1];
//     }

//     $pdf = new FPDF();
//     $pdf->AddPage();

//     // Add Logo
//     $pdf->Image('assets\images\favicon-32x32.png', 10, 6, 30);

//     // Company Details
//     $pdf->SetFont('Arial', 'B', 15);
//     $pdf->Cell(80);
//     $pdf->Cell(30, 10, 'MARUTI FABRICS', 0, 1, 'C');

//     $pdf->SetFont('Arial', '', 8);
//     $pdf->Cell(0, 10, 'Plot No. 20-21/A, Sahaj Ind. Society, Bamroli, Surat.', 0, 1, 'C');
//     $pdf->Cell(0, 2, 'Mobile: 9328210985   GSTIN: 24BCOPP6008E1ZN', 0, 1, 'C');
//     $pdf->Ln(18);

//     $billNo = $_SESSION['bill_no'];
//     // Invoice Details
//     $pdf->SetFont('Arial', '', 12);
//     $pdf->Cell(95, 10, 'Invoice No.: ' . $download, 1);
//     $pdf->Cell(95, 10, 'Invoice Date: ' . $date, 1, 1);
//     $pdf->Cell(95, 10, 'Bill To :', 1);
//     $pdf->Cell(95, 10, 'Ship To :', 1, 1);

//     // Customer Information
//     $pdf->SetFont('Arial', '', 10);
//     $customerInfo = "Customer Name : " . $customerName . "\n";
//     $customerInfo .= "Address : " . $customer_add . "\n";

//     $extraInfo = "Mobile: " . $customer_phone . "\n";

//     $pdf->MultiCell(95, 5, $customerInfo, 1);
//     $pdf->SetXY(105, 70); // Adjust position to match the "Ship To" section
//     $pdf->MultiCell(95, 5, $customerInfo, 1);
//     $pdf->Ln(5);
//     $pdf->MultiCell(95, 5, $extraInfo, 0);
//     $pdf->Ln(10);

//     // Items Table Header
//     $pdf->SetFont('Arial', 'B', 10);
//     $pdf->Cell(10, 10, 'Sr.', 1);
//     $pdf->Cell(60, 10, 'Product Name', 1);
//     $pdf->Cell(20, 10, 'Qty', 1);
//     $pdf->Cell(30, 10, 'Rate', 1);
//     $pdf->Cell(30, 10, 'Tax', 1);
//     $pdf->Cell(30, 10, 'Amount', 1, 1);

//     // Items Data
//     $i = 1;
//     $total = 0;
//     $rs = "RS. ";
//     $query_bill_detail = "select product_name,product_qty,product_price,total,gst_amount from billing_details where bill_no='$download'";
//     $result_bill_detail = mysqli_query($con, $query_bill_detail);
//     while ($val = mysqli_fetch_row($result_bill_detail)) {
//         $pdf->SetFont('Arial', '', 10);
//         $pdf->Cell(10, 10, $i, 1);
//         $pdf->Cell(60, 10, $val[0], 1);
//         $pdf->Cell(20, 10, $val[1], 1);
//         $pdf->Cell(30, 10, number_format($val[2]), 1);
//         $pdf->Cell(30, 10, number_format($val[4]), 1);
//         $pdf->Cell(30, 10, number_format($val[3]), 1, 1);
//         $total = $total + $val[3];
//         $i++;
//     }

//     // Summary
//     $pdf->SetFont('Arial', 'B', 10);
//     $pdf->Cell(150, 10, 'TOTAL', 1);
//     $pdf->Cell(30, 10, $rs . number_format($total), 1, 1);
//     $pdf->Ln(5);

//     // Terms and Conditions
//     $pdf->Cell(190, 10, 'TERMS AND CONDITIONS', 0, 1);
//     $pdf->SetFont('Arial', '', 8);
//     $pdf->MultiCell(190, 5, "1. Goods once sold will not be taken back or exchanged\n2. All disputes are subject to [ENTER_YOUR_CITY_NAME] jurisdiction only", 0, 1);
//     $pdf->Ln(5);

//     $pdf->Output("D", $download . ".pdf");
// }


if (isset($_POST['payment_bno'])) {
    $paid = $_POST['payment_bno'];
}
if (isset($paid)) {
    $status_text = "paid";
    $query_paid_bill = "update billing_header set payment_status='$status_text' where bill_no='$paid' AND user_id='$user_ID'";
    $result_paid_bill = mysqli_query($con, $query_paid_bill);
    $row = mysqli_affected_rows($con);
    if ($row > 0) {
        $_SESSION['icon'] = "success";
        $_SESSION['message'] = "Payment Status Updated Successfully!";
        header("Location: http://localhost/newproject-Copy/billing.php");
        exit();
    } else {
        $_SESSION['icon'] = "error";
        $_SESSION['message'] = "Payment Status Not Update...";
        header("Location: http://localhost/newproject-Copy/billing.php");
        exit();
    }
}
