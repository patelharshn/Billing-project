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
    if (isset($_SESSION['product_message']) && $_SESSION['product_message'] == 'Product Added Successfully!') {
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
    if (isset($_SESSION['message']) && $_SESSION['message'] == 'Product Update Successfully!') {
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
    if (isset($_SESSION['delete_message']) && $_SESSION['delete_message'] == 'Product Deleted Successfully!') {
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

if (isset($_SESSION['message']) && $_SESSION['message'] != '') {
    if (isset($_SESSION['message']) && $_SESSION['message'] == 'Payment Status Updated Successfully!') {
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
                            <h5 class="modal-title" id="staticBackdropLabel">Add Product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="./command/product_sql.php" method="post">
                                <div class="mb-3">
                                    <label class="form-label">User Email</label>
                                    <input type="text" value="<?php echo $email; ?>" class="form-control" name="u_email" readonly style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">User ID</label>
                                    <input type="text" value="<?php echo $u_id; ?>" class="form-control" name="u_id" readonly style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Product Name</label>
                                    <input type="text" class="form-control" name="p_name" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Buy Price</label>
                                    <input type="number" class="form-control" name="b_price" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Sell Price</label>
                                    <input type="number" class="form-control" name="s_price" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Mode of Sell</label>
                                    <select class="form-select" name="p_mos" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                        <option value="pieces" selected>Pieces</option>
                                        <option value="kg">K.g</option>
                                        <option value="liter">Liter</option>
                                    </select>
                                </div>
                                <input type="submit" name="btn_product_add" class="btn btn-primary" value="Add">
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
                            <h5 class="modal-title" id="staticBackdropLabel">Edit Product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="./command/product_sql.php" method="post">
                                <div class="mb-3">
                                    <label class="form-label">User Email</label>
                                    <input type="text" value="<?php echo $email; ?>" class="form-control" name="u_email" readonly style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Product ID</label>
                                    <input type="text" id="id" class="form-control" name="p_id" readonly style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Product Name</label>
                                    <input type="text" class="form-control" name="p_name" id="p_name" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Buy Price</label>
                                    <input type="number" class="form-control" name="b_price" id="b_price" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Sell Price</label>
                                    <input type="number" class="form-control" name="s_price" id="s_price" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                </div>
                                <!-- <div class="mb-3">
                                    <label class="form-label">Qty</label>
                                    <input type="text" class="form-control" name="p_qty" id="p_qty" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                </div> -->
                                <div class="mb-3">
                                    <label class="form-label">Mode of Sell</label>
                                    <select class="form-select" name="p_mos" id="p_type" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                        <option value="pieces" selected>Pieces</option>
                                        <option value="kg">K.g</option>
                                        <option value="liter">Liter</option>
                                    </select>
                                </div>
                                <input type="submit" name="btn_product_edit" class="btn btn-primary" value="Update Product">
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
            <div class="modal fade" id="delete_bill" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <form action="bill_show.php" method="post">
                            <div class="modal-body">
                                <input type="hidden" name="payment_bno" id="b_no">
                                <h4>Are you sure? Change Payment Status</h4>
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
                                        <h4>Product Sales Bill's
                                            <!-- <div class="float-end">
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                                    Add Product
                                                </button>
                                            </div> -->
                                        </h4>
                                    </div>
                                    <div class="card-body">

                                        <table id="table_data_search" class="table table-bordered table-striped">
                                            <thead>
                                                <tr class="text-center">
                                                    <th>ID</th>
                                                    <th>Customer Name</th>
                                                    <th>Date</th>
                                                    <th>Bill No</th>
                                                    <th>Payment Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query = "select customer_name,date,bill_no,payment_status from billing_header where user_id='$u_id' ORDER BY bill_no DESC";
                                                $product_show_result = mysqli_query($con, $query);
                                                $id = 1;
                                                while ($row = mysqli_fetch_row($product_show_result)) {
                                                    echo "<tr>";
                                                    echo "<td>" . $id . "</td>";
                                                    echo "<td>" . $row[0] . "</td>";
                                                    echo "<td>" . $row[1] . "</td>";
                                                    echo "<td>" . $row[2] . "</td>";
                                                    if ($row[3] == 'unpaid') {
                                                        echo "<td style='color: red; font-weight: bold; text-transform: uppercase;'>" . $row[3] . "</td>";
                                                    } else {
                                                        echo "<td style='color: green; font-weight: bold; text-transform: uppercase;'>" . $row[3] . "</td>";
                                                    }
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