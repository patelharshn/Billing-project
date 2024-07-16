<?php
ob_start();
include('header.php');
include('command/conn.php');
session_start();
if (!isset($_COOKIE['email']) && !isset($_COOKIE['pass'])) {
  header("Location: http://localhost/newproject-Copy/login/index.php");
  exit;
}

$email = $_COOKIE['email'];

$query_uid = "select id from user where email='$email'";
$result = mysqli_query($con, $query_uid);
$row = mysqli_fetch_row($result);
if ($row >= 0) {
  $u_id = $row[0];
} else {
  echo "User ID Not found";
}
?>


<div class="container-fluid vh-100 h-100">
  <div class="row min-vh-80 h-100">
    <div class="col-12">
      <!-- Main Content Start -->
      <!-- Table Start -->
      <div class="table_data">
        <div class="container mt-4">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="table-responsive">
                  <div class="card-header">
                    <h4>All Challan's</h4>
                  </div>
                  <div class="card-body">

                    <table id="table_data_search" class="table table-bordered table-striped">
                      <thead>
                        <tr class="text-center">
                          <th>ID</th>
                          <th>Challan No.</th>
                          <th>Customer</th>
                          <th>Company</th>
                          <th>Total Taka</th>
                          <th>Total Meter</th>
                          <th>Quality</th>
                          <th>Broker</th>
                          <th>Tempo No.</th>
                          <th>Date</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $query = "select challan_no,customer_name,company_name,total_taka,total_meter,quality,broker,tempo_num,date from challan_header where user_id='$u_id' ORDER BY challan_no DESC";
                        $product_show_result = mysqli_query($con, $query);
                        $id = 1;
                        while ($row = mysqli_fetch_row($product_show_result)) {
                          echo "<tr>";
                          echo "<td>" . $id . "</td>";
                          echo "<td>" . $row[0] . "</td>";
                          echo "<td>" . $row[1] . "</td>";
                          echo "<td>" . $row[2] . "</td>";
                          echo "<td>" . $row[3] . "</td>";
                          echo "<td>" . $row[4] . "</td>";
                          echo "<td>" . $row[5] . "</td>";
                          echo "<td>" . $row[6] . "</td>";
                          echo "<td>" . $row[7] . "</td>";
                          echo "<td>" . $row[8] . "</td>";
                          echo "<td>";
                          // echo "<a href='bill_show.php?b_no=$row[2]'><button type='button' name='view_btn' class='btn btn-success btn-sm view'><i class='material-icons opacity-10' style='font-size: large;'>visibility</i></button></a> ";
                          echo "<a href='bill_show.php?b_no=$row[2]'><button type='button' name='view_btn' class='btn btn-info btn-sm view'><i class='material-icons opacity-10' style='font-size: large;'>download</i></button></a> ";
                          if ($row[3] == 'unpaid') {
                            // echo "<a href='bill_show.php?payment_bno=$row[2]'><button type='button' name='view_btn' class='btn btn-warning btn-sm view text-green'>PAID</button></a> ";
                            echo "<button type='button' class='btn btn-warning btn-sm deletebtn' data-bs-toggle='modal' data-bs-target='#delete_bill'>PAID</button>";
                          }
                          echo "</td>";
                          echo "</tr>";
                          $id++;
                        }
                        ?>
                      </tbody>
                    </table>
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
          $('.editbtn').on('click', function() {
            $('#edit_product').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function() {
              return $(this).text();
            }).get();

            // console.log(data);
            $('#id').val(data[0]);
            $('#p_name').val(data[1]);
            $('#p_type').val(data[3]);
            $('#b_price').val(data[4]);
            $('#s_price').val(data[5]);
          });

          $('.deletebtn').on('click', function() {
            $('#delete_product').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function() {
              return $(this).text();
            }).get();

            // console.log(data);
            $('#b_no').val(data[3]);
          });

          $('#table_data_search').DataTable({
            "lengthMenu": [
              [5, 10, 15, -1],
              [5, 10, 15, "All"]
            ],
            responsive: true,
            language: {
              paginate: {
                next: '&#8594;',
                previous: '&#8592;'
              },
              search: "_INPUT_",
              searchPlaceholder: "Search",
            }
          });
        });
      </script>
      <!-- Main Content End -->
    </div>
  </div>
</div>


<?php include('footer.php'); ?>