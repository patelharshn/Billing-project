<?php
include('command/conn.php');

require('dompdf/autoload.inc.php');

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isRemoteEnabled', true);
$options->set('isHtml5ParserEnabled', true);

session_start();
$email = $_COOKIE['email'];

$query_uid = "select id from user where email='$email'";
$result = mysqli_query($con, $query_uid);
$row = mysqli_fetch_row($result);
if ($row >= 0) {
  $u_id = $row[0];
} else {
  echo "User ID Not found";
}


if (!isset($_SESSION['challan'])) {
  $_SESSION['challan'] = array();
}

function addData($meter)
{
  global $_SESSION;
  $sr = count($_SESSION['challan']) + 1;
  $_SESSION['challan'][] = array('sr' => $sr, 'meter' => $meter);
}

function deleteData($index)
{
  global $_SESSION;
  if (isset($_SESSION['challan'][$index])) {
    unset($_SESSION['challan'][$index]);
    $_SESSION['challan'] = array_values($_SESSION['challan']);
    foreach ($_SESSION['challan'] as $key => $value) {
      $_SESSION['challan'][$key]['sr'] = $key + 1;
    }
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // ========================
  //  Add data in session
  // ========================
  if (isset($_POST['meter']) && isset($_POST['comany_name']) && isset($_POST['customer_name'])) {
    addData($_POST['meter']);
    $_SESSION['company'] = $_POST['comany_name'];
    $_SESSION['customer'] = $_POST['customer_name'];
    $_SESSION['challan_no'] = $_POST['challan_no'];
    $_SESSION['tempo_no'] = $_POST['tempo_no'];
    $_SESSION['quality'] = $_POST['quality'];
    $_SESSION['broker'] = $_POST['broker'];
  }

  // ========================
  //  Insert into DATABASE
  // ========================
  if (isset($_POST['btn_challan'])) {
    $company_name = $_SESSION['company'];
    $customer_name = $_SESSION['customer'];
    $challan_no = $_SESSION['challan_no'];
    $tempo_no = $_SESSION['tempo_no'];
    $quality = $_SESSION['quality'];
    $broker = $_SESSION['broker'];
    date_default_timezone_set("Asia/Kolkata");
    $date = date("Y-m-d");
    $total_taka = count($_SESSION['challan']);
    $total_meter = 0;
    foreach ($_SESSION['challan'] as $key => $val) {
      $total_meter = $total_meter + $val['meter'];
    }

    // =====================
    //  Get company details
    // =====================
    $query_company_details = "select company_name,company_address,company_mobile,company_gst,company_logo from company where company_name='$company_name' AND user_id='$u_id'";
    $result_company_details = mysqli_query($con, $query_company_details);
    $row_company_details = mysqli_fetch_row($result_company_details);

    // =====================
    //  Get customer details
    // =====================
    $query_customer_details = "select c_name,c_add,c_phone,gstno from customer where c_name='$customer_name' AND u_id='$u_id'";
    $result_customer_details = mysqli_query($con, $query_customer_details);
    $row_customer_details = mysqli_fetch_row($result_customer_details);

    // ========================
    //   Challan details add
    // ========================
    $query_insert_header = "insert into challan_header(challan_no,customer_name,company_name,total_taka,total_meter,date,user_id) values('$challan_no','$customer_name','$company_name','$total_taka','$total_meter','$date','$u_id')";
    $result_insert_header = mysqli_query($con, $query_insert_header);
    foreach ($_SESSION['challan'] as $key => $val) {
      $meter = $val['meter'];
      $query_insert_header = "insert into challan_details(challan_no,customer_name,company_name,meter,date,user_id) values('$challan_no','$customer_name','$company_name','$meter','$date','$u_id')";
      $result_insert_header = mysqli_query($con, $query_insert_header);
    }

    // ===========================
    //        PDF DOM_PDF
    // ===========================
    $dompdf = new Dompdf($options);
    $html = '
    
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>' . $company_name . ' Challan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.2;
            font-size: 12px; /* Reduced font size to fit all content */
        }

        .invoice-container {
            // width: 100%;
            max-width: 1120px;
            margin: 0 auto;
            padding: 10px; /* Reduced padding */
            box-sizing: border-box;
        }

        .company-header {
            text-align: center;
            margin-bottom: 2px;
        }


        .company-details {
            text-align: center;
            margin-bottom: 10px;
        }

        .invoice-details {
            border-top: 1px solid #000;
            padding-top: 2px; /* Reduced padding */
            margin-bottom: 2px; /* Reduced margin */
        }

        .buyer-seller-details {
            // border: 1px solid #000;
            padding: 5px; /* Reduced padding */
            margin-bottom: 1px; /* Reduced margin */
        }

        .buyer, .delivery {
            width: 48%;
            float: left;
            border: 1px solid #000;
            padding: 5px; /* Reduced padding */
            margin-right: 1%;
            box-sizing: border-box;
        }

        .delivery {
            margin-right: 0;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        .invoice-table {
            width: 100%;
            border: 1;
            // border-collapse: collapse;
            margin-bottom: 5px; /* Reduced margin */
        }

        .invoice-table th, .invoice-table td {
            border: 1px solid #000;
            padding: 2px; /* Reduced padding */
            text-align: center;
        }

        .invoice-table th {
            background-color: #f2f2f2;
        }

        .totals {
            border:1px solid black;
            // text-align: right;
            margin-top: 10px; /* Reduced margin */
            // padding:5px;
        }

        .footer p {
            text-align: center;
            margin: 0;
        }

        .signature{
          float:left;
          margin-top:10px;
        }

        .authorized {
            float: right;
            margin-top: 10px; /* Reduced margin */
        }

        .authorized {
            clear: both;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="company-header">
            <h1>' . strtoupper($company_name) . '</h1>
        </div>
        <div class="company-details">
            <p>' . $row_company_details[1] . '</p>
            <p>(M): ' . $row_company_details[2] . '</p>
            <p>GSTIN : ' . $row_company_details[3] . '</p>
        </div>
        <div class="invoice-details">
            <div class="clearfix">
                <div style="width: 50%; float: left;">
                    <p>Challan No : <strong>' . $challan_no . '</strong></p>
                    <p>Quality : <strong>' . $quality . '</strong></p>
                </div>
                <div style="width: 50%; float: right; text-align: right;">
                    <p>Date :- <strong>' . $date . '</strong></p>
                    <p>Broker :- <strong>' . $broker . '</strong></p>
                    <p>Tempo :- ' . $tempo_no . '</p>
                </div>
            </div>
        </div>
        <div class="buyer-seller-details clearfix">
            <div class="buyer">
                <p>Buyer : <strong>' . $row_customer_details[0] . '</strong></p>
                <p>' . $row_customer_details[1] . '</p>
                <p>GSTIN : <strong>' . $row_customer_details[3] . '</strong></p>
            </div>
            <div class="delivery">
                <p>Delivery : <strong>' . $row_customer_details[0] . '</strong></p>
                <p>' . $row_customer_details[1] . '</p>
                <p>GSTIN : <strong>' . $row_customer_details[3] . '</strong></p>
            </div>
        </div>
        <table class="invoice-table">
            <thead>
                <tr>';
    $data = $_SESSION['challan'] ?? [];
    $chunkSize = 12;
    $totalEntries = 48;
    $colCount = ceil($totalEntries / $chunkSize);
    for ($col = 0; $col < $colCount; $col++) {
      $html .= "<th style='padding: 5px; text-align: center;'>
      <div style='display: flex; justify-content: space-between;  margin: 5px; '>
          <span> TAKA No.</span>
          <span> - </span>
          <span> METER </span>
      </div>
  </th>";
    }
    $html .= '</tr>
            </thead>
            <tbody>';
    for ($row = 0; $row <= $chunkSize; $row++) {
      $html .= "<tr class='text-center'>";
      for ($col = 0; $col < $colCount; $col++) {
        $index = $row + $col * $chunkSize;
        if ($index < $totalEntries) {
          if ($row < $chunkSize) {
            if ($index < count($data)) {
              $val = $data[$index];
              $html .=  "<td style='padding: 5px; text-align: center;'>
                        <div style='display: flex; justify-content: space-between; margin: 5px;'>";
              if ($val['sr'] <= 9) {
                $html .= "<span> 0" . $val['sr'] . " </span>";
              } else {
                $html .= "<span> " . $val['sr'] . " </span>";
              }
              $html .= "<span>&nbsp; - &nbsp;</span>";
              $html .= "<span> " . number_format($val['meter'], 2) . " </span>
                        </div>
                    </td>";
            } else {
              $html .= "<td></td>";
            }
          } else {
            for ($col = 0; $col < $colCount; $col++) {
              $totalMeter = 0;
              for ($i = $col * $chunkSize; $i < min(($col + 1) * $chunkSize, count($data)); $i++) {
                $totalMeter += $data[$i]['meter'];
              }
              $html .= "<td>
                      Total Meter :- $totalMeter
                  </td>";
            }
          }
        } else {
          $html .= "<td></td>";
        }
      }
      $html .= "</tr>";
    }
    $html .= '</tbody>
            <div style="display:flex; justify-content: space-between; width:390%;padding:10px;">
              <span><strong>Total Taka : ' . $total_taka . '</strong></span>
              <span style="float:right;"><strong>Total Meters : ' . $total_meter . '</strong></span>
            </div>
        </table>
        <div class="footer">
            <p><strong>NO DYEING GUARANTEE</strong></p>
            <div class="signature">
                <p>FOR <strong>' . strtoupper($row_company_details[0]) . '</strong></p>
                <p><strong>' . $row_customer_details[0] . '</strong></p>
            </div>
            <div class="authorized">
                <p>Signature of the goods receiver</p>
                <p><strong>Proprietor/Authorized</strong></p>
            </div>
        </div>
    </div>
</body>
</html>

    ';
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    $dompdf->stream($company_name . ".pdf", array("Attachment" => false));


    // unset($_SESSION['challan']);
    // unset($_SESSION['company']);
    // unset($_SESSION['customer']);
    // unset($_SESSION['challan_no']);
  }
}

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['index'])) {
  deleteData($_GET['index']);
  header("Location:http://localhost/newproject-Copy/deliverychallan.php");
  exit();
}
