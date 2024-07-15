<?php
include('conn.php');
// require('../fpdf/fpdf.php');
require_once '../dompdf/autoload.inc.php';

use Dompdf\Dompdf;

session_start();
if (!isset($_COOKIE['email']) && !isset($_COOKIE['pass'])) {
    header("Location: http://localhost/newproject-Copy/login/index.php");
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
?>


<?php
// if (isset($_POST['purchase_btn_pdf'])) {
//     $sdate = $_POST['start_date'];
//     $edate = $_POST['end_date'];
//     $user_ID = $_POST['userID'];
//     $pdf = new FPDF();
//     $pdf->AddPage();

//     // Add Logo
//     $pdf->Image('..\assets\images\favicon-32x32.png', 10, 6, 30);

//     // Company Details
//     $pdf->SetFont('Arial', 'B', 15);
//     $pdf->Cell(80);
//     $pdf->Cell(30, 10, 'MARUTI FABRICS', 0, 1, 'C');

//     $pdf->SetFont('Arial', '', 8);
//     $pdf->Cell(0, 10, 'Plot No. 20-21/A, Sahaj Ind. Society, Bamroli, Surat.', 0, 1, 'C');
//     $pdf->Cell(0, 2, 'Mobile: 9328210985   GSTIN: 24BCOPP6008E1ZN', 0, 1, 'C');
//     $pdf->Ln(5);

//     $pdf->SetFont('Arial', 'B', 12);
//     $pdf->Cell(0, 10, 'Purchase Report', 0, 1, 'C');
//     $pdf->Ln(5);

//     $billNo = $_SESSION['bill_no'];
//     // Invoice Details
//     $pdf->SetFont('Arial', '', 12);
//     $pdf->Cell(95, 10, 'Start Date : ' . $sdate, 1);
//     $pdf->Cell(95, 10, 'End Date : ' . $edate, 1, 1);

//     $extraInfo = "Report Date : " . date("d-m-Y") . "\n";

//     $pdf->MultiCell(95, 10, $extraInfo, 0);
//     $pdf->Ln(10);

//     // Items Table Header
//     $pdf->SetFont('Arial', 'B', 10);
//     $pdf->Cell(10, 10, 'Sr.', 1);
//     $pdf->Cell(70, 10, 'Product Name', 1);
//     $pdf->Cell(20, 10, 'Qty', 1);
//     $pdf->Cell(30, 10, 'Total Amount', 1);
//     $pdf->Cell(30, 10, 'Date', 1, 1);

//     // Items Data
//     $i = 1;
//     $total = 0;
//     $query = "select purchase.id,product.product_name,purchase.qty,purchase.total_cost,purchase.time from purchase,product where purchase.user_id='$user_ID' AND product.id = purchase.p_id AND purchase.time>='$sdate' AND purchase.time<='$edate'";
//     $product_show_result = mysqli_query($con, $query);
//     while ($val = mysqli_fetch_row($product_show_result)) {
//         $pdf->SetFont('Arial', '', 10);
//         $pdf->Cell(10, 10, $i, 1);
//         $pdf->Cell(70, 10, $val[1], 1);
//         $pdf->Cell(20, 10, $val[2], 1);
//         $pdf->Cell(30, 10, number_format($val[3]), 1);
//         $pdf->Cell(30, 10, $val[4], 1, 1);
//         $total = $total + $val[3];
//         $i++;
//     }

//     $pdf->Cell(10, 10, '', 0);
//     $pdf->Cell(70, 10, '', 0);
//     $pdf->Cell(20, 10, 'Total', 1);
//     $pdf->Cell(30, 10, number_format($total), 1);
//     // $pdf->Cell(30, 10, number_format($total), 1);

//     $pdf->Output("D", $sdate . " to " . $edate . "purchase.pdf");
// }

if (isset($_POST['sales_btn_pdf'])) {
    $total_r = 0;
    $i = 1;
    $total = 0;
    $sdate = $_POST['start_date'];
    $edate = $_POST['end_date'];
    $user_ID = $_POST['userID'];
    $c_name = $_POST['customername'];
    $status = $_POST['status'];

    if (isset($c_name)) {
        $query_customer_gstno = "select gstno from customer where c_name='$c_name'";
        $result_customer_gstno = mysqli_query($con, $query_customer_gstno);
        $row_customer_gstno = mysqli_fetch_row($result_customer_gstno);
        $gstNo = $row_customer_gstno[0];
    }

    if ($status == 'all') {
        $query_billno = "select bill_no from billing_header where user_id='$user_ID' AND customer_name='$c_name' AND date>='$sdate' AND date<='$edate'";
    } else {
        $query_billno = "select bill_no from billing_header where user_id='$user_ID' AND customer_name='$c_name' AND date>='$sdate' AND date<='$edate' AND payment_status='$status'";
    }
    $result_billno = mysqli_query($con, $query_billno);


    if ($total_r == 0) {
        if ($status == 'all') {
            $query_billno_sum = "select bill_no from billing_header where user_id='$user_ID' AND customer_name='$c_name' AND date>='$sdate' AND date<='$edate'";
        } else {
            $query_billno_sum = "select bill_no from billing_header where user_id='$user_ID' AND customer_name='$c_name' AND date>='$sdate' AND date<='$edate' AND payment_status='$status'";
        }
        $result_billno_sum = mysqli_query($con, $query_billno_sum);
        while ($row_billno_sum = mysqli_fetch_assoc($result_billno_sum)) {
            $billNo_sum = $row_billno_sum['bill_no'];
            $query_sum = "select * from billing_details where user_id='$user_ID' AND bill_no='$billNo_sum'";
            $product_show_result_sum = mysqli_query($con, $query_sum);
            while ($val_sum = mysqli_fetch_assoc($product_show_result_sum)) {
                $total_r = $total_r + $val_sum['total'];
            }
        }
    }

    $dompdf = new Dompdf();
    $path = "..\\assets\\images\\profile\\" . $image;
    $imageData = base64_encode(file_get_contents($path));

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
      <img src="data:image/png;base64,' . $imageData . '" alt="">
      <div class="company-info">
        <p><b>' . $shop_name . '</b></p>
        <p>' . $address . '</p>
        <p>Mobile: ' . $mobile_no . '&nbsp;&nbsp;&nbsp;&nbsp; GSTIN: ' . $gstnumber . '</p>
      </div>
    </div>
    <div class="invoice-no-date">
    <div><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p></div>
      <hr>
    </div>
    <p style="text-align:center;"><b> Party Ledger Report </b> </p>
    <div class="invoice-info">
          <table class="invoice-table">
            <thead>
              <tr>
                <th colspan="2">Date: ' . $sdate . ' - ' . $edate . '</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td colspan="2">
                  <p><b>Party Name :</b> ' . strtoupper($c_name) . ' </p>
                  <p><b>GSTIN :</b> ' . $gstNo . '</p>';
    if ($status == 'all') {
        $total_r = 0;
        $html .= '<p><b>Payment Status :</b> <span style="color:blue;">' . strtoupper($status) . '</span></p>';
    } else if ($status == 'paid') {
        $total_r = 0;
        $html .= '<p><b>Payment Status :</b> <span style="color:green;">' . strtoupper($status) . '</span></p>';
    } else if ($status == 'unpaid') {
        $html .= '<p><b>Payment Status :</b> <span style="color:red;">' . strtoupper($status) . '</span></p>';
    }
    $html .= '
                  <p><b>Total Receivable :</b> ₹' . number_format($total_r, 2) . '</p>
                </td>
              </tr>
            </tbody>
          </table>
          <div style="width: 45%; float: left;">
          <br><br>
          </div>
      <div style="width: 45%; float: right;">
        <!-- Add empty space for alignment -->
      </div>
      <div style="clear: both;"></div>
    </div>
    <table class="invoice-table">
      <thead>
        <tr>
          <th>SR.</th>
          <th>Bill No</th>
          <th>ITEMS</th>
          <th>QTY.</th>
          <th>RATE</th>
          <th>TAX</th>
          <th>AMOUNT</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>';
    while ($row_billno = mysqli_fetch_row($result_billno)) {
        $billNo = $row_billno[0];
        $query = "select product_name,product_qty,product_price,gst_amount,total,date from billing_details where user_id='$user_ID' AND bill_no='$billNo'";
        $product_show_result = mysqli_query($con, $query);
        while ($val = mysqli_fetch_row($product_show_result)) {
            $query_p_gst = "select gst from product where product_name='$val[0]' AND user_id='$user_ID'";
            $result_p_gst = mysqli_query($con, $query_p_gst);
            $row_p_gst = mysqli_fetch_row($result_p_gst);
            $html .= '<tr>
            <td>' . $i . '</td>
            <td>' . $billNo . '</td>
            <td>' . $val[0] . '</td>
            <td>' . $val[1] . '</td>
            <td>' . number_format($val[2], 2) . '</td>
            <td>' . number_format($val[3], 2) . '(' . $row_p_gst[0] . '%) </td>
            <td>' . number_format($val[4], 2) . ' </td>
            <td>' . $val[5] . ' </td>';
            $total = $total + $val[4];
            $i++;
        }
    }
    $html .= '</tr>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="6" style="text-align: right; font-size: 18px;"><b>Total Sales:</b></td>
          <td colspan="2" style="text-align: left; font-size: 18px;">₹' . number_format($total, 2) . '</td>
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
    // ob_end_clean();
    $dompdf->stream($sdate . " to " . $edate . " - sales.pdf", array("Attachment" => 0));

    // $pdf = new FPDF();
    // $pdf->AddPage();

    // // Add Logo
    // $pdf->Image('..\\assets\\images\\profile\\' . $image, 10, 6, 30);

    // // Company Details
    // $pdf->SetFont('Arial', 'B', 15);
    // $pdf->Cell(80);
    // $pdf->Cell(30, 10, $shop_name, 0, 1, 'C');

    // $pdf->SetFont('Arial', '', 10);
    // $pdf->Cell(0, 10, $address, 0, 1, 'C');
    // $pdf->Cell(0, 2, 'Mobile: ' . $mobile_no . '   GSTIN: ' . $gstnumber, 0, 1, 'C');
    // $pdf->Ln(8);

    // $pdf->SetFont('Arial', 'B', 12);
    // $pdf->Cell(0, 10, 'Party Ledger Report', 0, 1, 'C');
    // $pdf->Ln(5);

    // $pdf->SetFont('Arial', '', 12);
    // $pdf->Cell(95, 10, 'Date : ' . $sdate . ' - ' . $edate, 0, 1);
    // $pdf->Line(10, 40, 200, 40);

    // $extraInfo = "Party Name : " . strtoupper($c_name) . "\n";
    // $extraInfo .= "GSTIN : " . $gstNo . "\n";

    // $pdf->MultiCell(95, 10, $extraInfo, 0);
    // $pdf->Cell(35, 10, 'Payment Status : ', 0, 0);
    // if ($status == 'all') {
    //     // Blue color
    //     $pdf->SetFont('Arial', 'B', 12);
    //     $pdf->SetTextColor(0, 0, 250);
    //     $pdf->Cell(95, 10, strtoupper($status), 0, 1);
    // } elseif ($status == 'paid') {
    //     // Green color
    //     $pdf->SetFont('Arial', 'B', 12);
    //     $pdf->SetTextColor(30, 144, 0);
    //     $pdf->Cell(95, 10, strtoupper($status), 0, 1);
    // } elseif ($status == 'unpaid') {
    //     // Red color
    //     $pdf->SetFont('Arial', 'B', 12);
    //     $pdf->SetTextColor(137, 0, 0);
    //     $pdf->Cell(95, 10, strtoupper($status), 0, 1);
    // }
    // $pdf->SetTextColor(0, 0, 0);
    // $pdf->SetFont('Arial', '', 12);
    // $pdf->Cell(36, 10, 'Total Receivable :', 0);
    // $pdf->SetFont('Arial', 'B', 12);
    // if ($status == 'paid') {
    //     $total_r = 0;
    // } elseif ($status == 'all') {
    //     $total_r = 0;
    // }
    // $pdf->Cell(10, 10, ' Rs. ' . number_format($total_r), 0, 1);
    // $pdf->Ln(10);

    // $pdf->SetFont('Arial', 'B', 10);
    // $pdf->Cell(10, 10, 'Sr.', 1);
    // $pdf->Cell(15, 10, 'Bill No', 1);
    // $pdf->Cell(55, 10, 'Product Name', 1);
    // $pdf->Cell(12, 10, 'Qty', 1);
    // $pdf->Cell(20, 10, 'Unit Price', 1);
    // $pdf->Cell(25, 10, 'GST', 1);
    // $pdf->Cell(25, 10, 'Total', 1);
    // $pdf->Cell(25, 10, 'Date', 1, 1);

    // // Items Data
    // $i = 1;
    // $total = 0;
    // while ($row_billno = mysqli_fetch_row($result_billno)) {
    //     $billNo = $row_billno[0];
    //     $query = "select product_name,product_qty,product_price,gst_amount,total,date from billing_details where user_id='$user_ID' AND bill_no='$billNo'";
    //     $product_show_result = mysqli_query($con, $query);
    //     while ($val = mysqli_fetch_row($product_show_result)) {
    //         $query_p_gst = "select gst from product where product_name='$val[0]' AND user_id='$user_ID'";
    //         $result_p_gst = mysqli_query($con, $query_p_gst);
    //         $row_p_gst = mysqli_fetch_row($result_p_gst);
    //         $pdf->SetFont('Arial', '', 10);
    //         $pdf->Cell(10, 10, $i, 1);
    //         $pdf->Cell(15, 10, $billNo, 1);
    //         $pdf->Cell(55, 10, $val[0], 1);
    //         $pdf->Cell(12, 10, $val[1], 1);
    //         $pdf->Cell(20, 10, number_format($val[2], 2), 1);
    //         $pdf->Cell(25, 10, number_format($val[3], 2) . '(' . $row_p_gst[0] . '%)', 1);
    //         $pdf->Cell(25, 10, number_format($val[4], 2), 1);
    //         $pdf->Cell(25, 10, $val[5], 1, 1);
    //         $total = $total + $val[4];
    //         $i++;
    //     }
    // }

    // $pdf->Cell(10, 10, '', 0);
    // $pdf->Cell(15, 10, '', 0);
    // $pdf->Cell(55, 10, '', 0);
    // $pdf->Cell(12, 10, '', 0);
    // $pdf->SetFont('Arial', 'B', 11);
    // $pdf->Cell(45, 10, 'Total Sales :', 1);
    // $pdf->MultiCell(30, 10, 'Rs. ' . number_format($total, 2), 1, 1);

    // $pdf->Output("I", $sdate . " to " . $edate . " sales.pdf");
}

// if (isset($_POST['return_btn_pdf'])) {
//     $sdate = $_POST['start_date'];
//     $edate = $_POST['end_date'];
//     $user_ID = $_POST['userID'];
//     $pdf = new FPDF();
//     $pdf->AddPage();

//     $pdf->SetFont('Arial', 'B', 20);

//     $pdf->Cell(71, 10, '', 0, 0);
//     $pdf->Cell(59, 5, 'Return Report', 0, 0);
//     $pdf->Cell(59, 10, '', 0, 1);

//     $pdf->SetFont('Arial', 'B', 15);
//     $pdf->Cell(71, 5, '', 0, 0);
//     $pdf->Cell(59, 5, '', 0, 0);
//     $pdf->Cell(59, 5, '', 0, 1);

//     $pdf->SetFont('Courier', '', 12);

//     $pdf->Cell(25, 9, 'From: ' . $sdate, 0, 0);
//     $pdf->Cell(34, 9, '', 0, 1);

//     $pdf->Cell(25, 9, 'To:   ' . $edate, 0, 0);
//     $pdf->Cell(34, 9, '', 0, 1);

//     $pdf->Cell(130, 9, '', 0, 0);
//     $pdf->Cell(25, 1, 'Report Date:  ' . date("d-m-Y"), 0, 0);
//     $pdf->Cell(34, 1, '', 0, 1);

//     $pdf->SetFont('Arial', 'B', 10);
//     $pdf->Cell(189, 10, '', 0, 1);

//     $pdf->Cell(50, 10, '', 0, 1);

//     $pdf->SetFont('Courier', 'B', 12);
//     $pdf->Cell(10, 6, 'Sr', 0, 0, 'C');
//     $pdf->Cell(40, 6, 'Product Name', 0, 0, 'C');
//     $pdf->Cell(15, 6, 'Qty', 0, 0, 'C');
//     $pdf->Cell(32, 6, 'Unit Price', 0, 0, 'C');
//     $pdf->Cell(30, 6, 'Total', 0, 0, 'C');
//     $pdf->Cell(35, 6, 'Customer Name', 0, 0, 'C');
//     $pdf->Cell(30, 6, 'Date', 0, 1, 'C');
//     $pdf->SetFont('Courier', '', 12);
//     $i = 1;

//     $query = "select product_name,qty,price,total,customer_name,date from product_return where user_id='$user_ID' AND date>='$sdate' AND date<='$edate'";
//     $product_show_result = mysqli_query($con, $query);
//     while ($val = mysqli_fetch_row($product_show_result)) {
//         $pdf->Cell(10, 6, $i, 0, 0, 'C');
//         $pdf->Cell(40, 6, $val[0], 0, 0, 'C');
//         $pdf->Cell(15, 6, $val[1], 0, 0, 'C');
//         $pdf->Cell(32, 6, $val[2], 0, 0, 'C');
//         $pdf->Cell(30, 6, $val[3], 0, 0, 'C');
//         $pdf->Cell(35, 6, $val[4], 0, 0, 'C');
//         $pdf->Cell(30, 6, $val[5], 0, 1, 'C');
//         $i++;
//     }


//     $pdf->Line(10, 50, 200, 50);

//     $pdf->Output("D", $sdate . " to " . $edate . " return.pdf");
// }
