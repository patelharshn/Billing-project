<?php

ob_start();

// This is a header file include
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

$query_prod_name = "select product_name,id from product where user_id='$u_id'";
$result_prod_name = mysqli_query($con, $query_prod_name);

$query_supplier_name = "select supplier_name from supplier where user_id='$u_id'";
$result_supplier_name = mysqli_query($con, $query_supplier_name);
?>


<?php
// session_start();
if (isset($_SESSION['purchase_message']) && $_SESSION['purchase_message'] != '') {
    if (isset($_SESSION['purchase_message']) && $_SESSION['purchase_message'] == 'Product Added Successfully!') {
?>
        <script>
            Swal.fire({
                icon: '<?php echo $_SESSION['icon']; ?>',
                text: '<?php echo $_SESSION['purchase_message']; ?>',
                showConfirmButton: false,
                timer: 3000,
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
        unset($_SESSION['purchase_message']);
    } else {
    ?>
        <script>
            Swal.fire({
                icon: '<?php echo $_SESSION['icon']; ?>',
                text: '<?php echo $_SESSION['purchase_message']; ?>',
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
        unset($_SESSION['purchase_message']);
    }
}
?>

<div class="container-fluid vh-100 h-100">
    <div class="row min-vh-80 h-100">
        <div class="col-12">
            <!-- Main Content Start -->
            <!-- Modal start For Add purchase -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Add Purchase</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="./command/purchase_sql.php" method="post">
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
                                    <select class="form-select" onchange="getbprice(this.value)" name="prod_name" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                        <option value="">Select Product</option>
                                        <?php while ($row_prod_name = mysqli_fetch_row($result_prod_name)) { ?>
                                            <option value="<?php echo $row_prod_name[0]; ?>"><?php echo $row_prod_name[0]; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Buy Price</label>
                                    <input type="text" class="form-control" name="b_price" id="bprice" value="" readonly style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Supplier Name</label>
                                    <select class="form-select" name="supplier_name" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                        <option value="">Select Supplier</option>
                                        <?php while ($row_supplier_name = mysqli_fetch_row($result_supplier_name)) { ?>
                                            <option value="<?php echo $row_supplier_name[0]; ?>"><?php echo $row_supplier_name[0]; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Qty</label>
                                    <input type="number" class="form-control" name="p_qty" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                </div>
                                <input type="submit" name="btn_purchase_add" class="btn btn-primary" value="Add">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal End For Add Purchase -->

            <!-- Table Start -->
            <div class="table_data">
                <div class="container mt-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="table-responsive">
                                    <div class="card-header">
                                        <h4>Product Purchase
                                            <div class="float-end">
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                                    Add Purchase
                                                </button>
                                            </div>
                                        </h4>
                                    </div>
                                    <div class="card-body">

                                        <table id="table_data_search" class="table table-bordered table-striped">
                                            <thead>
                                                <tr class="text-center">
                                                    <th>ID</th>
                                                    <th>Product Name</th>
                                                    <th>Qty</th>
                                                    <th>Total Cost</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query = "select purchase.id,product.product_name,purchase.qty,purchase.total_cost,purchase.time from purchase,product where purchase.user_id='$u_id' AND product.id = purchase.p_id";
                                                $product_show_result = mysqli_query($con, $query);
                                                while ($row = mysqli_fetch_row($product_show_result)) {
                                                    echo "<tr class='text-center'>";
                                                    echo "<td>" . $row[0] . "</td>";
                                                    echo "<td>" . $row[1] . "</td>";
                                                    echo "<td>" . $row[2] . "</td>";
                                                    echo "<td>" . $row[3] . "</td>";
                                                    echo "<td>" . $row[4] . "</td>";
                                                    // echo "<td>" . $row[5] . "</td>";
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

                function getbprice(pname) {
                    var uid = $('#user_id').val();
                    $.ajax({
                        url: 'class.php',
                        type: 'POST',
                        data: {
                            p_name: pname,
                            u_id: uid
                        },
                        success: function(results) {
                            $('#bprice').attr("value", results);
                        }
                    })
                }
            </script>
            <!-- Main Content End -->
        </div>
    </div>
</div>

<?php include('footer.php'); ?>