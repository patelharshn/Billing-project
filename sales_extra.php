<?php
ob_start();

// This is a header file include
include('header.php');
include('command/conn.php');
// require('fpdf/fpdf.php');

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

$query_cname = "select c_name,id from customer where u_id='$u_id'";
$result_c_name = mysqli_query($con, $query_cname);


$query_bill = "select bill_no from billing_header where user_id='$u_id'";
$result_bill = mysqli_query($con, $query_bill);
$bid = "";
while ($row = mysqli_fetch_row($result_bill)) {
    $bid = $row[0];
}

?>


<?php
// session_start();
if (isset($_SESSION['sale_message']) && $_SESSION['sale_message'] != '') {
?>
    <script>
        // location.reload();
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
<div class="container-fluid vh-100 h-100">
    <div class="row min-vh-80 h-100">
        <div class="col-12">
            <!-- Main Content Start -->
            <!-- Modal start For Add Sales -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Add Sales</h5>
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
                                        <h4>Product Sales
                                            <!-- <div class="float-end">
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                                    Add Sales
                                                </button>
                                            </div> -->
                                        </h4>


                                        <div class="row mt-3">
                                            <div class="col-md-3 mt-2">
                                                <div class="input-group input-group-static">
                                                    <label class="labels">Bill No </label>
                                                    <input type="text" class="form-control" name="fname" value="<?php echo billno($bid); ?>" id="bno" style="font-weight: bold;" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mt-2">
                                                <!-- <div class="input-group input-group-static"> -->
                                                <label class="labels">Product Name </label>
                                                <select class="form-select" onchange="getbprice(this.value)" id="pname" name="prod_name" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                                    <option value="">Select Product</option>
                                                    <?php while ($row_prod_name = mysqli_fetch_row($result_prod_name)) { ?>
                                                        <option value="<?php echo $row_prod_name[0]; ?>"><?php echo $row_prod_name[0]; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <!-- </div> -->
                                            </div>

                                            <input hidden type="text" class="form-control" name="pid" id="pid" style="font-weight: bold;" readonly>
                                            <input hidden type="text" class="form-control" name="p_qty" id="product_qty" style="font-weight: bold;" readonly>

                                            <div class="col-md-3 mt-2">
                                                <!-- <div class="input-group input-group-static"> -->
                                                <label class="labels">Customer Name </label>
                                                <?php //if (!isset($_SESSION['cname'])) {
                                                ?>
                                                <select class="form-select" name="c_name" id="cname" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                                    <option value="">Select Customer</option>
                                                    <?php while ($row_c_name = mysqli_fetch_row($result_c_name)) {
                                                    ?>
                                                        <option value="<?php echo $row_c_name[1]; ?>"><?php echo $row_c_name[0]; ?></option>
                                                    <?php }
                                                    ?>
                                                </select>
                                                <?php //} //else {
                                                ?>
                                                <!-- <select class="form-select" name="c_name" id="cname" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                                        <option value="<?php //echo $_SESSION['cname']; 
                                                                        ?>"><?php //echo $_SESSION['cname']; 
                                                                            ?></option>
                                                    </select> -->
                                                <?php
                                                //} 
                                                ?>
                                                <!-- </div> -->
                                            </div>
                                            <div class="col-md-3 mt-2">
                                                <div class="input-group input-group-static">
                                                    <label class="labels">Qty </label>
                                                    <input type="number" class="form-control" name="fname" id="pqty" style="font-weight: bold;">
                                                </div>
                                            </div>
                                            <div class="col-md-3 mt-2">
                                                <div class="input-group input-group-static">
                                                    <label class="labels">Price </label>
                                                    <input type="text" class="form-control" name="fname" id="pprice" style="font-weight: bold;" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mt-2">
                                                <div class="input-group input-group-static">
                                                    <label class="labels">GST </label>
                                                    <input type="text" class="form-control" name="fname" id="pgst" style="font-weight: bold;" readonly>
                                                    <input type="hidden" class="form-control" id="pgst_hidden" style="font-weight: bold;" readonly>
                                                    <input type="hidden" class="form-control" id="gstamount_hidden" style="font-weight: bold;" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mt-2">
                                                <div class="input-group input-group-static">
                                                    <label class="labels">Total </label>
                                                    <input type="text" class="form-control" name="fname" id="ptotal" style="font-weight: bold;" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mt-2">
                                                <!-- <div class="input-group input-group-static"> -->
                                                <label class="labels">Payment Type </label>
                                                <select class="form-select" id="payment" name="payment_type" required style="border: 1px solid gray; padding:5px 5px 5px 5px;">
                                                    <option value="">Select Payment type</option>
                                                    <option value="paid">Paid</option>
                                                    <option value="unpaid">Unpaid</option>
                                                </select>
                                                <!-- </div> -->
                                            </div>
                                        </div>
                                        <br>
                                        <div class="float-end">
                                            <button type="button" class="btn btn-primary" id="btn_sales">
                                                Add Sales
                                            </button>
                                        </div>
                                        <br>

                                        <div class="card-body">

                                            <table id="table_data_search" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th>ID</th>
                                                        <th>Product Name</th>
                                                        <th>Qty</th>
                                                        <th>Price</th>
                                                        <th>GST</th>
                                                        <th>Total</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="result_data">
                                                    <?php
                                                    if (isset($_SESSION['sales'])) {
                                                        $i = 1;
                                                        foreach ($_SESSION['sales'] as $key => $val) {
                                                            echo "<tr class='text-center'>";
                                                            echo "<td>$i</td>";
                                                            echo "<td>$val[pname]</td>";
                                                            echo "<td>$val[qty]</td>";
                                                            echo "<td>$val[price]</td>";
                                                            echo "<td>" . number_format($val['gst'], 2) . "($val[gstper])</td>";
                                                            echo "<td>" . number_format($val['total'], 2) . "</td>";
                                                            echo "<td> 
                                                            <button type='button' class='btn btn-danger btn-sm deletebtn'>X</button>
                                                        </td>
                                                    </tr>";
                                                            $i += 1;
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                            <!-- btn -->
                                            <form action="class.php" method="post">
                                                <div class="container">
                                                    <center>
                                                        <input type="submit" class="btn btn-info" value="Create Bill" name="btn_bill" id="btn_create_bill">
                                                    </center>
                                                </div>
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
                                pname: pname,
                                uid: uid
                            },
                            success: function(results) {
                                $('#sprice').attr("value", results);
                                $('#pprice').attr("value", results);
                                getgst(pname);
                                getID(pname);
                            }
                        })
                    }

                    function getgst(pname) {
                        var uid = $('#user_id').val();
                        $.ajax({
                            url: 'class.php',
                            type: 'POST',
                            data: {
                                gst_pname: pname,
                                gst_uid: uid
                            },
                            success: function(results) {
                                $('#pgst').attr("value", results + "%");
                                $('#pgst_hidden').attr("value", results);
                            }
                        })
                    }

                    function getID(pname) {
                        var uid = $('#user_id').val();
                        $.ajax({
                            url: 'class.php',
                            type: 'POST',
                            data: {
                                P_Name: pname,
                                U_Id: uid
                            },
                            success: function(results) {
                                $('#pid').attr("value", results);
                                getQTY(pname, uid);
                            }
                        })
                    }

                    function getQTY(pname, uid) {
                        $.ajax({
                            url: 'class.php',
                            type: 'POST',
                            data: {
                                PName: pname,
                                UId: uid,
                            },
                            success: function(results) {
                                $('#product_qty').attr("value", results);
                            }
                        })
                    }

                    $('#btn_sales').click(function() {
                        var pname = $('#pname').val();
                        var pid = $('#pid').val();
                        var cname = $('#cname').val();
                        var prod_qty = $('#pqty').val();
                        var pprice = $('#pprice').val();
                        var ptotal = $('#ptotal').val();
                        var bno = $('#bno').val();
                        var product_qty = $('#product_qty').val();
                        var gst_amount = $('#gstamount_hidden').val();
                        var gst_per = $('#pgst').val();
                        var payment_type = $('#payment').val();

                        if (pname == '') {
                            Swal.fire({
                                icon: 'error',
                                text: 'please select product name',
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
                        } else if (pid == '') {
                            Swal.fire({
                                icon: 'error',
                                text: 'please set product id',
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

                        } else if (cname == '') {
                            Swal.fire({
                                icon: 'error',
                                text: 'please select Customer name',
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

                        } else if (prod_qty == '') {
                            Swal.fire({
                                icon: 'error',
                                text: 'please enter product quantity',
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

                        } else if (pprice == '') {
                            Swal.fire({
                                icon: 'error',
                                text: 'please set product price',
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

                        } else if (ptotal == '') {
                            Swal.fire({
                                icon: 'error',
                                text: 'please set total amount',
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
                        } else if (payment_type == '') {
                            Swal.fire({
                                icon: 'error',
                                text: 'please set payment type',
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
                            $.ajax({
                                url: 'sales_class.php',
                                type: 'POST',
                                data: {
                                    p_name: pname,
                                    p_id: pid,
                                    c_name: cname,
                                    p_qty: prod_qty,
                                    p_price: pprice,
                                    p_total: ptotal,
                                    bill_no: bno,
                                    gst: gst_amount,
                                    gst_per: gst_per,
                                    payment_type: payment_type
                                },
                                success: function(data) {
                                    Swal.fire({
                                        icon: 'info',
                                        text: 'Please wait..',
                                        showConfirmButton: false,
                                        timer: 1500,
                                        toast: true,
                                        position: 'top',
                                        timerProgressBar: true,
                                        didOpen: (toast) => {
                                            toast.onmouseenter = Swal.stopTimer;
                                            toast.onmouseleave = Swal.resumeTimer;
                                        }
                                    });
                                    $('#result_data').html(data);
                                    setTimeout(refresh, 1500);
                                }
                            })

                            function refresh() {
                                location.reload();
                            }
                            // }
                        }
                    });


                    $("#pqty").keyup(function() {
                        var price = $("#pprice").val();
                        var pqty = $("#pqty").val();
                        var gst = $("#pgst_hidden").val();

                        var total = price * pqty;
                        var gst_amount = (total * gst) / 100;
                        var final_product_total = total + gst_amount;
                        $('#ptotal').val(final_product_total.toFixed(2));
                        $('#gstamount_hidden').val(gst_amount);
                    });

                    function counttotal() {
                        var price = $("#pprice").val();
                        var pqty = $("#pqty").val();
                        var gst = $("#pgst_hidden").val();

                        var total = price * pqty;
                        var gst_amount = (total * gst) / 100;
                        $('#ptotal').val(total + gst_amount);
                        $('#gstamount_hidden').val(gst_amount);
                    }

                    $('.deletebtn').click(function() {
                        $tr = $(this).closest('tr');

                        var data = $tr.children("td").map(function() {
                            return $(this).text();
                        }).get();

                        $.ajax({
                            url: 'sales_class.php',
                            type: 'POST',
                            data: {
                                p__name: data[1],
                                action: "delete"
                            },
                            success: function(data) {
                                location.reload();
                            }
                        })
                    });
                </script>

                <script>
                    $('.bill_create').click(function() {
                        $.ajax({
                            url: 'class.php',
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
                function billno($bid1)
                {
                    if ($bid1 == "") {
                        $bid1 = 0;
                    }
                    $bid1 = $bid1 + 1;

                    $len = strlen($bid1);
                    if ($len == 1) {
                        $bid1 = "0000" . $bid1;
                    } elseif ($len == 2) {
                        $bid1 = "000" . $bid1;
                    } elseif ($len == 3) {
                        $bid1 = "00" . $bid1;
                    } elseif ($len == 4) {
                        $bid1 = "0" . $bid1;
                    } elseif ($len == 5) {
                        $bid1 = $bid1;
                    }
                    return $bid1;
                }
                ?>
            </div>
        </div>
    </div>
</div>


<?php include('footer.php'); ?>