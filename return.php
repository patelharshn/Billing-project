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

if (isset($_GET['r_bno'])) {
    $bNo = $_GET['r_bno'];
} else {
    echo "";
}

$query_bill = "select customer_name,date,bill_no from billing_header where bill_no='$bNo' AND user_id='$u_id'";
$result_bill = mysqli_query($con, $query_bill);
while ($row = mysqli_fetch_row($result_bill)) {
    $cname = $row[0];
    $date = $row[1];
    $billNo = $row[2];
}
?>

<?php
// session_start();
if (isset($_SESSION['return_message']) && $_SESSION['return_message'] != '') {
    if (isset($_SESSION['return_message']) && $_SESSION['return_message'] == 'Product Returned!') {
?>
        <script>
            Swal.fire({
                icon: '<?php echo $_SESSION['icon']; ?>',
                text: '<?php echo $_SESSION['return_message']; ?>',
                showConfirmButton: false,
                timer: 1500,
                toast: true,
                position: "top",
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                },
            });
        </script>
    <?php
        unset($_SESSION['return_message']);
    } else {
    ?>
        <script>
            Swal.fire({
                icon: '<?php echo $_SESSION['icon']; ?>',
                text: '<?php echo $_SESSION['return_message']; ?>',
                showConfirmButton: false,
                timer: 1500,
                toast: true,
                position: "top",
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                },
            });
        </script>
<?php
        unset($_SESSION['return_message']);
    }
}
?>

<?php if (isset($billNo)) { ?>
    <div class="container-fluid vh-100 h-100">
        <div class="row min-vh-80 h-100">
            <div class="col-12">
                <!-- Table Start -->
                <div class="table_data">
                    <div class="container mt-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="table-responsive">
                                        <div class="card-header">
                                            <h4 style="text-align: center;">Product Details</h4>
                                            <hr class="horizontal dark mt-0 mb-4" style="opacity: 100;">
                                            <!-- <br> -->
                                            <div class="float-center">
                                                <div class=" row mb-4">
                                                    <div class="col-12 col-sm-6 col-md-8">
                                                        <h4>Customer Details</h4>
                                                        <address>
                                                            <strong>Name : <?php echo $cname; ?></strong><br>
                                                        </address>
                                                    </div>
                                                    <div class="col-12 col-sm-6 col-md-4">
                                                        <h4 class="row">Invoice Details</h4>
                                                        <div class="row">
                                                            <span class="col-6 ">Date : <?php echo $date = strstr($date, ' ', true); ?></span>
                                                            <span class="col-6 text-sm-end"></span>
                                                            <span class="col-6">Bill No : <?php echo $billNo; ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <!-- <br> -->
                                            <!-- <table id="table_data_search" class="table table-bordered table-striped"> -->
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>Sr</th>
                                                        <th>Product Name</th>
                                                        <th>Qty</th>
                                                        <th>Price</th>
                                                        <th>Total</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    $query_bill_detail = "select product_name,product_qty,product_price,total,bill_no from billing_details where bill_no='$billNo'";
                                                    $result_bill_detail = mysqli_query($con, $query_bill_detail);
                                                    if (mysqli_num_rows($result_bill_detail) > 0) {
                                                        while ($val = mysqli_fetch_row($result_bill_detail)) {
                                                            echo "<tr class='text-center'>";
                                                            echo "<td>" . $i . "</td>";
                                                            echo "<td>" . $val[0] . "</td>";
                                                            echo "<td>" . $val[1] . "</td>";
                                                            echo "<td>" . $val[2] . "</td>";
                                                            echo "<td>" . $val[3] . "</td>";
                                                            echo "<td><a href='class.php?b_no=$val[4]&pname=$val[0]&cname=$cname'><button type='button' name='view_btn' class='btn btn-warning btn-sm view'><i class='material-icons opacity-10' style='font-size: large;'>refresh</i></button></a></td>";
                                                            echo "</tr>";
                                                            $i = $i + 1;
                                                        }
                                                    } else {
                                                    ?>
                                                        <script>
                                                            Swal.fire({
                                                                icon: 'error',
                                                                text: 'Already All product returned!!',
                                                                showConfirmButton: false,
                                                                timer: 1500,
                                                                toast: true,
                                                                position: "top",
                                                                timerProgressBar: true,
                                                                didOpen: (toast) => {
                                                                    toast.onmouseenter = Swal.stopTimer;
                                                                    toast.onmouseleave = Swal.resumeTimer;
                                                                },
                                                            }).then(function() {
                                                                window.location.href = "http://localhost/newproject-Copy/billing.php";
                                                                exit();
                                                            });
                                                        </script>
                                                    <?php
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
<?php } else {
?>
    <script>
        Swal.fire({
            icon: 'error',
            text: 'Something Wrong!',
            showConfirmButton: false,
            timer: 1500,
            toast: true,
            position: "top",
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        }).then(function() {
            window.location.href = "http://localhost/newproject-Copy/billing.php";
        });
    </script>
<?php
} ?>

<?php include('footer.php'); ?>