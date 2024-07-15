<?php
ob_start();
include('header.php');
include('command/conn.php');

session_start();
if (!isset($_COOKIE['email']) && !isset($_COOKIE['pass'])) {
  header("Location: http://localhost/newproject-Copy/login/index.php");
  exit;
}
// unset($_SESSION['challan']);
$email = $_COOKIE['email'];

$query_uid = "select id from user where email='$email'";
$result = mysqli_query($con, $query_uid);
$row = mysqli_fetch_row($result);
if ($row >= 0) {
  $u_id = $row[0];
} else {
  echo "User ID Not found";
}

$query_customer = "select c_name from customer where u_id='$u_id'";
$result_customer = mysqli_query($con, $query_customer);

$query_tempo_num = "select tempo_number from tempo where user_id='$u_id'";
$result_tempo_num = mysqli_query($con, $query_tempo_num);

$query_company = "select company_name from company where user_id='$u_id'";
$result_company = mysqli_query($con, $query_company);


$challan_no = "select challan_no from challan_header where user_id='$u_id'";
$result_challan_no = mysqli_query($con, $challan_no);
$cid = "";
while ($row = mysqli_fetch_row($result_challan_no)) {
  $cid = $row[0];
}

?>

<?php
// session_start();
if (isset($_SESSION['sale_message']) && $_SESSION['sale_message'] != '') {
?>
  <script>
    Swal.fire({
      icon: '<?php echo $_SESSION['icon']; ?>',
      text: '<?php echo $_SESSION['sale_message']; ?>',
      showConfirmButton: false,
      timer: 2700,
      toast: true,
      position: "top",
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
      }
    });
  </script>
<?php
  unset($_SESSION['sale_message']);
}
?>

<style>
  input::-webkit-outer-spin-button,
  input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }
</style>
<pre><?php //echo count($_SESSION['challan']) 
      ?></pre>
<pre><?php //print_r($_SESSION['challan']) 
      ?></pre>
<div class="container-fluid vh-100 h-100">
  <div class="row min-vh-80 h-100">
    <div class="col-12">
      <!-- Main Content Start -->
      <!-- Modal start For Add Sales -->
      <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Add Challan</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="./command/sales_sql.php" method="post">
                <div class="mb-3">
                  <label class="form-label">User Email</label>
                  <input type="text" value="<?php echo $email; ?>" class="form-control" name="u_email" readonly style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                </div>
                <div class="mb-3">
                  <label class="form-label">User ID</label>
                  <input type="text" value="<?php echo $u_id; ?>" class="form-control" name="u_id" id="user_id" readonly style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                </div>
                <div class="mb-3">
                  <label class="form-label">Product Name</label>
                  <!-- <select class="form-select" onchange="getbprice(this.value)" name="prod_name" required style="border: 1px solid gray; padding:5px 5px 5px 5px;"> -->
                  <!-- <option value="">Select Product</option> -->
                  <?php //while ($row_prod_name = mysqli_fetch_row($result_prod_name)) { 
                  ?>
                  <!-- <option value="<?php //echo $row_prod_name[0]; 
                                      ?>"><?php //echo $row_prod_name[0]; 
                                          ?></option> -->
                  <?php //} 
                  ?>
                  <!-- </select> -->
                </div>

                <div class="mb-3">
                  <label class="form-label">Sell Price</label>
                  <input type="text" class="form-control" name="s_price" id="sprice" value="" readonly style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                </div>

                <div class="mb-3">
                  <label class="form-label">Customer Name</label>
                  <!-- <select class="form-select" name="c_name" required style="border: 1px solid gray; padding:5px 5px 5px 5px;"> -->
                  <!-- <option value="">Select Customer</option> -->
                  <?php //while ($row_c_name = mysqli_fetch_row($result_c_name)) { 
                  ?>
                  <!-- <option value="<?php //echo $row_c_name[0]; 
                                      ?>"><?php //echo $row_c_name[0]; 
                                          ?></option> -->
                  <?php //} 
                  ?>
                  <!-- </select> -->
                </div>

                <div class="mb-3">
                  <label class="form-label">Qty</label>
                  <input type="number" class="form-control" name="s_qty" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                </div>
                <input type="submit" name="btn_sales_add" class="btn btn-primary" value="Add">
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal End For Add Sales -->

      <!-- Table Start -->
      <div class="table_data">
        <div class="container mt-4">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="table-responsive">
                  <div class="card-header">
                    <h4>Challan</h4>
                    <div class="row mt-3">
                      <div class="col-md-3 mt-2">
                        <div class="input-group input-group-static">
                          <label class="labels">Challan No </label>
                          <input type="text" class="form-control" name="c_no" value="<?php echo billno($cid); ?>" id="cno" style="font-weight: bold;" readonly>
                        </div>
                      </div>

                      <div class="col-md-3 mt-2">
                        <div class="input-group input-group-static">
                          <label class="labels">Meter </label>
                          <input type="number" class="form-control" name="meter" id="meter" style="font-weight: bold;">
                        </div>
                      </div>

                      <div class="col-md-3 mt-2">
                        <div class="input-group input-group-static">
                          <label class="labels">Quality </label>
                          <?php if (isset($_SESSION['quality'])) {
                          ?>
                            <input type="text" class="form-control" value="<?php echo $_SESSION['quality'] ?>" name="quality" id="quality" style="font-weight: bold;">
                          <?php
                          } else {
                          ?>
                            <input type="text" class="form-control" name="quality" id="quality" style="font-weight: bold;">
                          <?php
                          } ?>
                        </div>
                      </div>

                      <div class="col-md-3 mt-2">
                        <!-- <div class="input-group input-group-static"> -->
                        <label class="labels">Company </label>
                        <select class="form-select" id="comany_name_id" name="company_name" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                          <option value="">Select Company</option>
                          <?php while ($row_company = mysqli_fetch_row($result_company)) {
                          ?>
                            <option value="<?php echo $row_company[0] ?>" <?php if (isset($_SESSION['company'])) {
                                                                            if ($_SESSION['company'] == $row_company[0]) {
                                                                              echo 'selected';
                                                                            }
                                                                          } ?>><?php echo $row_company[0] ?></option>
                          <?php
                          } ?>
                        </select>
                        <!-- </div> -->
                      </div>
                      <div class="col-md-3 mt-2">
                        <!-- <div class="input-group input-group-static"> -->
                        <label class="labels">Customer </label>
                        <select class="form-select" id="customer_name_id" name="customer_name" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                          <option value="">Select Customer</option>
                          <?php while ($row_customer = mysqli_fetch_row($result_customer)) { ?>
                            <option value="<?php echo $row_customer[0] ?>" <?php if (isset($_SESSION['customer'])) {
                                                                              if ($_SESSION['customer'] == $row_customer[0]) {
                                                                                echo 'selected';
                                                                              }
                                                                            } ?>><?php echo $row_customer[0] ?></option>

                          <?php } ?>
                        </select>
                        <!-- </div> -->
                      </div>

                      <div class="col-md-3 mt-2">
                        <label class="labels">Tempo Number </label>
                        <select class="form-select" id="tempo_num_id" name="tempo_num" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                          <option value="">Select TempoNumber</option>
                          <?php while ($row_tempo_num = mysqli_fetch_row($result_tempo_num)) { ?>
                            <option value="<?php echo $row_tempo_num[0] ?>" <?php if (isset($_SESSION['tempo_no'])) {
                                                                              if ($_SESSION['tempo_no'] == $row_tempo_num[0]) {
                                                                                echo 'selected';
                                                                              }
                                                                            } ?>><?php echo $row_tempo_num[0] ?></option>

                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <br>
                    <div class="float-end">
                      <?php
                      if (isset($_SESSION['challan']) ? count($_SESSION['challan']) >= 48 : '') {
                      } else { ?>
                        <button type="button" class="btn btn-primary btn_add_challan">
                          Add Challan
                        </button>
                      <?php } ?>
                    </div>
                    <br>

                    <div class="card-body">
                      <?php
                      $data = $_SESSION['challan'] ?? [];
                      $chunkSize = 12;
                      $totalEntries = 48;
                      $colCount = ceil($totalEntries / $chunkSize);

                      echo "<table border='1' class='table table-bordered'>";
                      echo "<thead><tr>";

                      // Create table headers
                      for ($col = 0; $col < $colCount; $col++) {
                        echo "<th style='padding: 5px; text-align: center;'>
                        <div style='display: flex; justify-content: space-between;  margin: 5px; '>
                            <span> SR </span>
                            <span> METER </span>
                            <span> ACTION </span>
                        </div>
                    </th>";
                      }
                      echo "</tr></thead>";
                      echo "<tbody>";

                      // Create table rows
                      for ($row = 0; $row <= $chunkSize; $row++) {
                        echo "<tr class='text-center'>";
                        for ($col = 0; $col < $colCount; $col++) {
                          $index = $row + $col * $chunkSize;
                          if ($index < $totalEntries) {
                            if ($row < $chunkSize) {
                              if ($index < count($data)) {
                                $val = $data[$index];
                                echo "<td style='padding: 5px; text-align: center;'>
                        <div style='display: flex; justify-content: space-between; margin: 5px;'>";
                                if ($val['sr'] <= 9) {
                                  echo "<span> 0" . $val['sr'] . " </span>";
                                } else {
                                  echo "<span> " . $val['sr'] . " </span>";
                                }
                                echo "<span>" . $val['meter'] . "</span>
                            <a class='btn btn-danger btn-sm' href=\"deliverychallan_class.php?action=delete&index={$index}\">Delete</a>
                        </div>
                    </td>";
                              } else {
                                echo "<td></td>";
                              }
                            } else {
                              // Calculate and display totals for the current column
                              for ($col = 0; $col < $colCount; $col++) {
                                $totalMeter = 0;
                                for ($i = $col * $chunkSize; $i < min(($col + 1) * $chunkSize, count($data)); $i++) {
                                  $totalMeter += $data[$i]['meter'];
                                }
                                echo "<td style='padding: 5px; text-align: left;'>Total Meter :- $totalMeter</td>";
                              }
                            }
                          } else {
                            echo "<td></td>";
                          }
                        }
                        echo "</tr>";
                      }

                      echo "</tbody></table>";


                      ?>
                      </tbody>
                      </table>
                      <!-- btn -->
                      <form action="deliverychallan_class.php" method="post">
                        <?php if (isset($_SESSION['challan']) ? count($_SESSION['challan']) > 0 : '') { ?>
                          <div class="container">
                            <center>
                              <input type="submit" class="btn btn-info" value="Create Challan" name="btn_challan" id="btn_create_challan">
                            </center>
                          </div>
                        <?php } ?>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Table End -->

        <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

        <script>
          $(document).ready(function() {
            $('#meter').focus();
            // $('#table_data_search').DataTable({
            //   "lengthMenu": [
            //     [5, 10, 15, -1],
            //     [5, 10, 15, "All"]
            //   ],
            //   responsive: true,
            //   language: {
            //     paginate: {
            //       next: '&#8594;',
            //       previous: '&#8592;'
            //     },
            //     search: "_INPUT_",
            //     searchPlaceholder: "Search",
            //   }
            // });
          });

          $('.btn_add_challan').click(function() {
            var meter_val = $('#meter').val();
            var comany_name_id = $('#comany_name_id').val();
            var customer_name_id = $('#customer_name_id').val();
            var challan_no = $('#cno').val();
            var tempo_no = $('#tempo_num_id').val();
            var quality = $('#quality').val();

            if (meter_val == "") {
              alert("Please enter METER...");
            } else if (comany_name_id == "") {
              alert("Please select Company Name...");
            } else if (customer_name_id == "") {
              alert("Please select Customer Name...");
            } else if (tempo_no == "") {
              alert("Please select Tempo Number...");
            } else if (quality == "") {
              alert("Please enter Quality...");
            } else {
              $.ajax({
                url: 'deliverychallan_class.php',
                type: 'POST',
                data: {
                  meter: meter_val,
                  comany_name: comany_name_id,
                  customer_name: customer_name_id,
                  challan_no: challan_no,
                  tempo_no: tempo_no,
                  quality: quality
                },
                success: function(data) {
                  // alert("Challan Created Successfully");
                  location.reload();
                }
              })
            }
          });

          $('#meter').keypress(function(event) {
            console.log(event.which); //For Enter keycode is 13
            if (event.which == 13) {
              $('#quality').focus();
            }
          })

          $('#quality').keypress(function(event) {
            console.log(event.which); //For Enter keycode is 13
            if (event.which == 13) {
              $('.btn_add_challan').click();
            }
          })
        </script>

        <script>
          $('#btn_create_challan').click(function() {
            $.ajax({
              url: 'deliverychallan_class.php',
              type: 'POST',
              data: {
                Bill: "bill"
              },
              success: function(data) {
                window.location.href = data;
              }
            })
          });
        </script>
        <!-- Main Content End -->
        <?php
        function billno($cid1)
        {
          if ($cid1 == "") {
            $cid1 = 0;
          }
          $cid1 = $cid1 + 1;

          $len = strlen($cid1);
          if ($len == 1) {
            $cid1 = "0000" . $cid1;
          } elseif ($len == 2) {
            $cid1 = "000" . $cid1;
          } elseif ($len == 3) {
            $cid1 = "00" . $cid1;
          } elseif ($len == 4) {
            $cid1 = "0" . $cid1;
          } elseif ($len == 5) {
            $cid1 = $cid1;
          }
          return $cid1;
        }
        ?>
      </div>
    </div>
  </div>
</div>


<?php include('footer.php'); ?>