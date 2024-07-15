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


<?php
// session_start();
if (isset($_SESSION['product_message']) && $_SESSION['product_message'] != '') {
    if (isset($_SESSION['product_message']) && $_SESSION['product_message'] == 'Customer Added Successfully!') {
?>
        <script>
            Swal.fire({
                icon: '<?php echo $_SESSION['icon']; ?>',
                text: '<?php echo $_SESSION['product_message']; ?>',
                showConfirmButton: false,
                timer: 2500,
                toast: true,
                position: "top",
            });
        </script>
    <?php
        unset($_SESSION['product_message']);
    } else {
    ?>
        <script>
            Swal.fire({
                icon: '<?php echo $_SESSION['icon']; ?>',
                text: '<?php echo $_SESSION['product_message']; ?>',
                showConfirmButton: false,
                timer: 2700,
                toast: true,
                position: "top",
            });
        </script>
    <?php
        unset($_SESSION['product_message']);
    }
}


if (isset($_SESSION['message']) && $_SESSION['message'] != '') {
    if (isset($_SESSION['message']) && $_SESSION['message'] == 'Customer Update Successfully!') {
    ?>
        <script>
            Swal.fire({
                icon: '<?php echo $_SESSION['icon']; ?>',
                text: '<?php echo $_SESSION['message']; ?>',
                showConfirmButton: false,
                timer: 2500,
                toast: true,
                position: "top",
            });
        </script>
    <?php
        unset($_SESSION['message']);
    } else {
    ?>
        <script>
            Swal.fire({
                icon: '<?php echo $_SESSION['icon']; ?>',
                text: '<?php echo $_SESSION['message']; ?>',
                showConfirmButton: false,
                timer: 2500,
                toast: true,
                position: "top",
            });
        </script>
    <?php
        unset($_SESSION['message']);
    }
}

if (isset($_SESSION['delete_message']) && $_SESSION['delete_message'] != '') {
    if (isset($_SESSION['delete_message']) && $_SESSION['delete_message'] == 'Customer Deleted Successfully!') {
    ?>
        <script>
            Swal.fire({
                icon: '<?php echo $_SESSION['icon']; ?>',
                text: '<?php echo $_SESSION['delete_message']; ?>',
                showConfirmButton: false,
                timer: 2500,
                toast: true,
                position: "top",
            });
        </script>
    <?php
        unset($_SESSION['delete_message']);
    } else {
    ?>
        <script>
            Swal.fire({
                icon: '<?php echo $_SESSION['icon']; ?>',
                text: '<?php echo $_SESSION['delete_message']; ?>',
                showConfirmButton: false,
                timer: 2500,
                toast: true,
                position: "top",
            });
        </script>
<?php
        unset($_SESSION['delete_message']);
    }
}
?>


<div class="container-fluid vh-100 h-100">
    <div class="row min-vh-80 h-100">
        <div class="col-12">
            <!-- Main Content Start -->
            <!-- Modal start For Add Customer -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Add Customer</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="./command/customer_sql.php" method="post">
                                <div class="mb-3">
                                    <!-- <label class="form-label">User Email</label> -->
                                    <input type="text" hidden value="<?php echo $email; ?>" class="form-control" name="u_email" readonly style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                </div>
                                <div class="mb-3">
                                    <!-- <label class="form-label">User ID</label> -->
                                    <input type="text" hidden value="<?php echo $u_id; ?>" class="form-control" name="u_id" readonly style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Customer Name</label>
                                    <input type="text" class="form-control" name="c_name" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control" name="c_address" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input type="text" maxlength="10" minlength="10" pattern="[0-9]{10}" class="form-control" name="c_phone" style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">GST No</label>
                                    <input type="text" class="form-control" name="gstno" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                </div>
                                <input type="submit" name="btn_customer_add" class="btn btn-primary" value="Add">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal End For Add Customer -->


            <!-- Modal start For Edit Customer -->
            <div class="modal fade" id="edit_product" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Edit Customer</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="./command/customer_sql.php" method="post">
                                <div class="mb-3">
                                    <!-- <label class="form-label">User Email</label> -->
                                    <input type="text" hidden value="<?php echo $email; ?>" class="form-control" name="u_email" readonly style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Customer ID</label>
                                    <input type="text" id="c_id" class="form-control" name="c_id" readonly style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Customer Name</label>
                                    <input type="text" class="form-control" name="c_name" id="c_name" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control" name="c_address" id="c_address" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" maxlength="10" minlength="10" pattern="[0-9]{10}" class="form-control" name="c_phone" id="c_phone" style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">GST No</label>
                                    <input type="text" class="form-control" name="gstno" id="gstno" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                </div>
                                <input type="submit" name="btn_customer_edit" class="btn btn-primary" value="Update Product">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal End For Edit Customer -->


            <!-- Modal start For Delete Customer -->
            <div class="modal fade" id="delete_product" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <form action="command/customer_sql.php" method="post">
                            <div class="modal-body">
                                <input type="hidden" name="delete_p_id" id="d_id">
                                <h4>Are you sure? delete customer</h4>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                <button type="submit" class="btn btn-danger" name="yes_btn" data-bs-dismiss="modal">Yes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Modal End For Delete Customer -->


            <!-- Table Start -->
            <div class="table_data">
                <div class="container mt-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="table-responsive">
                                    <div class="card-header">
                                        <h4>Manage Customer
                                            <div class="float-end">
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                                    Add Customer
                                                </button>
                                            </div>
                                        </h4>
                                    </div>
                                    <div class="card-body">

                                        <table id="table_data_search" class="table table-bordered table-striped">
                                            <thead>
                                                <tr class="text-center">
                                                    <th>ID</th>
                                                    <th>Customer Name</th>
                                                    <th>Address</th>
                                                    <th>Phone</th>
                                                    <th>GST No</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query = "select * from customer where u_id='$u_id'";
                                                $product_show_result = mysqli_query($con, $query);
                                                while ($row = mysqli_fetch_row($product_show_result)) {
                                                    echo "<tr>";
                                                    echo "<td>" . $row[0] . "</td>";
                                                    echo "<td>" . $row[1] . "</td>";
                                                    echo "<td>" . $row[2] . "</td>";
                                                    echo "<td>" . $row[3] . "</td>";
                                                    echo "<td>" . $row[4] . "</td>";
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
                        $('#c_id').val(data[0]);
                        $('#c_name').val(data[1]);
                        $('#c_address').val(data[2]);
                        $('#c_phone').val(data[3]);
                        $('#gstno').val(data[4]);
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
            </script>
            <!-- Main Content End -->
        </div>
    </div>
</div>

<?php include('footer.php'); ?>