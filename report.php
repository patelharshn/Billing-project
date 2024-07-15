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

$user_email = $_COOKIE['email'];
if (isset($user_email)) {
    $user_id = "select id from user where email='$user_email'";
    $result = mysqli_query($con, $user_id);
    $row = mysqli_fetch_row($result);
    $user_id = $row[0];
}

if (isset($user_id)) {
    $user_id = "select c_name from customer where u_id='$user_id'";
    $result = mysqli_query($con, $user_id);
}

// $date = $_POST['daterange'];

// echo strstr($date, "to", true);
// echo "<br>";
// echo substr($date, 14);
?>

<!-- <form action="" method="post">
    <input type="text" id="calendar-selectrange" name="daterange">

</form> -->

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
                                        <h4>Report</h4>

                                        <div class="row mt-3">
                                            <!-- <div class="col-md-3 mt-2"> -->
                                            <!-- <label class="labels">Report Type </label> -->
                                            <select hidden class="form-select" id="type" name="report_type" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                                <option value="Sales Report" selected>Sales Report</option>
                                            </select>
                                            <!-- </div> -->

                                            <div class="col-md-3 mt-2">
                                                <label class="labels">Customer </label>
                                                <select class="form-select" id="customer" name="customer_name" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                                    <option value="">Select Customer</option>
                                                    <?php while ($row = mysqli_fetch_row($result)) {
                                                    ?>
                                                        <option value="<?php echo $row[0]; ?>"><?php echo $row[0]; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mt-2">
                                                <label class="labels">Start Date </label>
                                                <input type="text" id="calendar-selectrange" name="start_date" placeholder="Please Select Start Date">
                                            </div>
                                            <div class="col-md-3 mt-2">
                                                <label class="labels">End Date </label>
                                                <input type="text" id="calendar-selectrange1" name="end_date" placeholder="Please Select End Date">
                                            </div>
                                            <div class="col-md-3 mt-2">
                                                <label class="labels">Payment Status </label>
                                                <select class="form-select" id="paymentstatus" name="payment_status" required style="border: 1px solid gray; padding:5px 5px 5px 5px;font-weight:bold">
                                                    <option value="">Select Status</option>
                                                    <!-- <option style="color: blue; font-weight: bold;" value="all">All</option> -->
                                                    <option style="color: green; font-weight: bold;" value="paid">Paid</option>
                                                    <option style="color: red; font-weight: bold;" value="unpaid">Unpaid</option>
                                                </select>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="float-end">
                                            <button type="button" class="btn btn-primary" id="btn_report">
                                                Show Report
                                            </button>
                                        </div>
                                        <br>

                                        <div class="card-body" id="tablesdata">

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

                <!-- Main Content End -->
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    // flatpickr('#calendar-selectrange', {
    //     "maxDate": "today",
    //     "dateFormat": "Y-m-d"
    // });
    const start_date = flatpickr("#calendar-selectrange", {
        dateFormat: 'Y-m-d',
        "maxDate": "today",
        onChange: function(sel_date, date_str) {
            end_date.set("minDate", date_str);
            end_date.set("maxDate", "today");
        }
    });

    const end_date = flatpickr("#calendar-selectrange1", {
        dateFormat: 'Y-m-d',
        "maxDate": "today"
    });

    $('#paymentstatus').on('change', function() {
        var paymentstatus = $(this).val();
        if (paymentstatus == 'unpaid') {
            $('#paymentstatus').css('color', 'red');
        } else if (paymentstatus == 'paid') {
            $('#paymentstatus').css('color', 'green');
        } else if (paymentstatus == 'all') {
            $('#paymentstatus').css('color', 'blue');
        }
    })

    $('#btn_report').click(function() {
        var type = $('#type').val();
        var customer = $('#customer').val();
        var start_date = $('#calendar-selectrange').val();
        var end_date = $('#calendar-selectrange1').val();
        var payment_status = $('#paymentstatus').val();

        if (type == '') {
            Swal.fire({
                icon: 'error',
                text: 'Please Select report type...',
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
        } else if (customer == '') {
            Swal.fire({
                icon: 'error',
                text: 'Please Select Customer...',
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
        } else if (start_date == '') {
            Swal.fire({
                icon: 'error',
                text: 'Please Select Start Date...',
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

        } else if (end_date == '') {
            Swal.fire({
                icon: 'error',
                text: 'Please Select End Date...',
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
        } else if (payment_status == '') {
            Swal.fire({
                icon: 'error',
                text: 'Please Select Payment Status...',
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
        } else {
            if (type == 'Purchase Report') {
                $.ajax({
                    url: 'command/report_sql.php',
                    type: 'POST',
                    data: {
                        sd: start_date,
                        ed: end_date,
                        action: 'purchase'
                    },
                    success: function(data) {
                        $('#tablesdata').html(data);
                    }
                })
            } else if (type == 'Sales Report') {
                $.ajax({
                    url: 'command/report_sql.php',
                    type: 'POST',
                    data: {
                        sd: start_date,
                        ed: end_date,
                        customer: customer,
                        status: payment_status,
                        action: 'sales'
                    },
                    success: function(data) {
                        $('#tablesdata').html(data);
                    }
                })

            } else if (type == 'Return Report') {
                $.ajax({
                    url: 'command/report_sql.php',
                    type: 'POST',
                    data: {
                        sd: start_date,
                        ed: end_date,
                        action: 'return'
                    },
                    success: function(data) {
                        $('#tablesdata').html(data);
                    }
                })

            }

        }
    });
</script>

<?php include('footer.php'); ?>