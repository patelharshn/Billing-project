<?php

use FontLib\Table\Type\name;

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


<?php
// session_start();
if (isset($_SESSION['company_message']) && $_SESSION['company_message'] != '') {
  if (isset($_SESSION['company_message']) && $_SESSION['company_message'] == 'Company added successful') {
?>
    <script>
      Swal.fire({
        icon: '<?php echo $_SESSION['icon']; ?>',
        text: '<?php echo $_SESSION['company_message']; ?>',
        showConfirmButton: false,
        timer: 2500,
        toast: true,
        position: "top",
      });
    </script>
  <?php
    unset($_SESSION['company_message']);
  } else {
  ?>
    <script>
      Swal.fire({
        icon: '<?php echo $_SESSION['icon']; ?>',
        text: '<?php echo $_SESSION['company_message']; ?>',
        showConfirmButton: false,
        timer: 2700,
        toast: true,
        position: "top",
      });
    </script>
<?php
    unset($_SESSION['company_message']);
  }
}
?>

<div class="container-fluid vh-100 h-100">
  <div class="row min-vh-80 h-100">
    <div class="col-12">
      <!-- Main Content Start -->
      <!-- Modal start For Add Product -->
      <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Add Company</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="./command/company_sql.php" method="post" enctype="multipart/form-data">
                <input hidden type="text" value="<?php echo $email; ?>" class="form-control" name="u_email" readonly style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                <input hidden type="text" value="<?php echo $u_id; ?>" class="form-control" name="u_id" readonly style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                <div class="mb-3">
                  <label class="form-label">Company Logo</label>
                  <br>
                  <img class="rounded-circle" style="border: 1px solid black;" id="profile" width="150px" src="assets/images/profile/2024 (1).png">
                  <br><br>
                  <span class="btn btn-primary btn-file">Upload new image</span>
                  <input hidden type="file" id="inputfile" accept="image/png, image/jpeg" name="profileimg" required>
                </div>
                <div class="mb-3">
                  <label class="form-label">Company Name</label>
                  <input type="text" class="form-control" name="company_name" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                </div>
                <div class="mb-3">
                  <label class="form-label">Company Address</label>
                  <input type="text" class="form-control" name="company_address" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                </div>
                <div class="mb-3">
                  <label class="form-label">Company Mobile</label>
                  <input type="text" class="form-control" name="company_mobile" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                </div>
                <div class="mb-3">
                  <label class="form-label">Company GST NO</label>
                  <input type="text" class="form-control" name="company_gst" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                </div>
                <input type="submit" name="btn_company_add" class="btn btn-primary" value="Add">
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal End For Add Product -->


      <!-- Modal start For Edit Product -->
      <div class="modal fade" id="edit_product" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Edit Company Details</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="./command/company_sql.php" method="post" enctype="multipart/form-data">
                <!-- <div class="mb-3"> -->
                <!-- <label class="form-label">User Email</label> -->
                <input hidden type="text" value="<?php echo $email; ?>" class="form-control" name="u_email" readonly style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                <input hidden type="text" value="<?php echo $u_id; ?>" class="form-control" name="u_id" readonly style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                <!-- </div> -->

                <div class="mb-3">
                  <label class="form-label">Company ID</label>
                  <input type="text" id="c_id" class="form-control" name="company_id" readonly style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                </div>
                <div class="mb-3">
                  <label class="form-label">Company Logo</label>
                  <br>
                  <img class="rounded-circle" style="border: 1px solid black;" id="c_logo" width="150px" src="">
                  <br><br>
                  <span class="btn btn-primary btn_logo_upload">Upload new image</span>
                  <input hidden type="file" id="inputfile_edit" accept="image/png, image/jpeg" name="profileimg_edit">
                </div>
                <div class="mb-3">
                  <label class="form-label">Company Name</label>
                  <input type="text" id="c_name" class="form-control" name="company_name" style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                </div>
                <div class="mb-3">
                  <label class="form-label">Company Address</label>
                  <input type="text" id="c_address" class="form-control" name="company_address" style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                </div>
                <div class="mb-3">
                  <label class="form-label">Company Mobile</label>
                  <input type="text" id="c_mobile" class="form-control" name="company_mobile" style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                </div>
                <div class="mb-3">
                  <label class="form-label">Company GST Number</label>
                  <input type="text" id="c_gst" class="form-control" name="company_gst" style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                </div>

                <input type="submit" name="btn_company_edit" class="btn btn-primary" value="Update">
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal End For Edit Product -->


      <!-- Modal start For Delete Product -->
      <div class="modal fade" id="delete_product" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">

            <form action="command/company_sql.php" method="post" enctype="multipart/form-data">
              <div class="modal-body">
                <input type="hidden" name="delete_c_id" id="d_id">
                <h4>Are you sure? delete tempo details</h4>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <button type="submit" class="btn btn-danger" name="yes_btn" data-bs-dismiss="modal">Yes</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- Modal End For Delete Product -->


      <!-- Table Start -->
      <div class="table_data">
        <div class="container mt-4">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="table-responsive">
                  <div class="card-header">
                    <h4>Manage Company
                      <div class="float-end">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                          Add Company
                        </button>
                      </div>
                    </h4>
                  </div>
                  <div class="card-body">

                    <table id="table_data_search" class="table table-bordered table-striped">
                      <thead>
                        <tr class="text-center">
                          <th>ID</th>
                          <th>Company Logo</th>
                          <th style="display: none;">Company Logo</th>
                          <th>Company Name</th>
                          <th>Company Address</th>
                          <th>Company Mobile</th>
                          <th>Company GST</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $query = "select id,company_logo,company_name,company_address,company_mobile,company_gst from company where user_id='$u_id'";
                        $product_show_result = mysqli_query($con, $query);
                        while ($row = mysqli_fetch_row($product_show_result)) {
                          echo "<tr>";
                          echo "<td>" . $row[0] . "</td>";
                          echo "<td style='display:none;'>" . $row[1] . "</td>";
                          echo "<td> <img style='width: 60px; height:60px;' src='assets/images/company_logo/$row[1]'alt='COMPANY LOGO'> </td>";
                          echo "<td>" . $row[2] . "</td>";
                          echo "<td>" . $row[3] . "</td>";
                          echo "<td>" . $row[4] . "</td>";
                          echo "<td>" . $row[5] . "</td>";
                          echo "<td> 
                              <button type='button' class='btn btn-success btn-sm editbtn' data-bs-toggle='modal' data-bs-target='#edit_product'>Edit</button>
                              <button type='button' class='btn btn-danger btn-sm deletebtn' data-bs-toggle='modal' data-bs-target='#delete_product'>Delete</button>
                          </td>";
                          echo "</tr>";
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

            var logo_path = "assets/images/company_logo/" + data[1];
            $('#c_id').val(data[0]);
            $('#c_logo').attr("src", logo_path);
            $('#c_name').val(data[3]);
            $('#c_address').val(data[4]);
            $('#c_mobile').val(data[5]);
            $('#c_gst').val(data[6]);
          });

          $('.deletebtn').on('click', function() {
            $('#delete_product').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function() {
              return $(this).text();
            }).get();

            // console.log(data);
            $('#d_id').val(data[0]);
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

        // Image upload btn click
        $('.btn-file').click(function() {
          $('#inputfile').click();
        });
        $('.btn_logo_upload').click(function() {
          $('#inputfile_edit').click();
        });

        // IMAGE UPDATE
        let profilepic = document.getElementById("profile");
        let inputfile = document.getElementById("inputfile");

        inputfile.onchange = function() {
          profilepic.src = URL.createObjectURL(inputfile.files[0]);
        }

        let profilepic_edit = document.getElementById("c_logo");
        let inputfile_edit = document.getElementById("inputfile_edit");

        inputfile_edit.onchange = function() {
          profilepic_edit.src = URL.createObjectURL(inputfile_edit.files[0]);
        }
      </script>
      <!-- Main Content End -->
    </div>
  </div>
</div>

<?php include('footer.php'); ?>