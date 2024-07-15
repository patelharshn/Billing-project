<?php
ob_start();
include('header.php');
session_start();
if (!isset($_COOKIE['email']) && !isset($_COOKIE['pass'])) {
    header("Location: http://localhost/newproject-Copy/login/index.php");
    exit;
}

$emails = $_COOKIE['email'];

$query_uid = "select shopname,email,username,mobile_no,gstnumber,address,state,image from user where email='$emails'";
$result = mysqli_query($con, $query_uid);
$row = mysqli_fetch_row($result);
if ($row >= 0) {
    $shopname = $row[0];
    $email = $row[1];
    $username = $row[2];
    $mobileno = $row[3];
    $gstno = $row[4];
    $address = $row[5];
    $state = $row[6];
    $pimage = $row[7];
} else {
    echo "User ID Not found";
}


$count = 0;
if (isset($shopname)) {
    $count++;
}
if (isset($email)) {
    $count++;
}
if (isset($username)) {
    $count++;
}
if (isset($mobileno)) {
    $count++;
}
if (isset($gstno)) {
    $count++;
}
if (isset($address)) {
    $count++;
}
if (isset($state)) {
    $count++;
}
?>
<style>
    .box {
        align-items: center;
        justify-content: center;
    }

    .btn-file {
        position: relative;
        overflow: hidden;
    }

    .btn-file input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        filter: alpha(opacity=0);
        opacity: 0;
        outline: none;
        cursor: pointer;
        display: block;
    }
</style>

<?php
if (isset($_SESSION['update_message']) && $_SESSION['update_message'] != '') {
    if (isset($_SESSION['update_message']) && $_SESSION['update_message'] == 'Product Added Successfully!') {
?>
        <script>
            Swal.fire({
                icon: '<?php echo $_SESSION['icon']; ?>',
                text: '<?php echo $_SESSION['update_message']; ?>',
                showConfirmButton: false,
                timer: 2500,
                toast: true,
                position: "top",
            });
        </script>
    <?php
        unset($_SESSION['update_message']);
    } else {
    ?>
        <script>
            Swal.fire({
                icon: '<?php echo $_SESSION['icon']; ?>',
                text: '<?php echo $_SESSION['update_message']; ?>',
                showConfirmButton: false,
                timer: 2700,
                toast: true,
                position: "top",
            });
        </script>
<?php
        unset($_SESSION['update_message']);
    }
}
?>


<form action="command/profile_sql.php" method="post" enctype="multipart/form-data">
    <div class="container rounded bg-white mt-0 mb-5">
        <div class="row box">
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                    <?php
                    if (isset($pimage) && $pimage != '') {
                    ?>
                        <img class="rounded-circle" id="profile" width="150px" src="assets/images/profile/<?php echo $pimage ?>">
                    <?php
                    } else {
                    ?>
                        <img class="rounded-circle" id="profile" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg">
                    <?php
                    }
                    ?>
                    <br>
                    <span class="btn btn-primary btn-file">Upload new image<input type="file" id="inputfile" accept="image/png, image/jpeg" name="profileimg"></span>
                    <span class="font-weight-bold"><?php $per = $count / 7 * 100;
                                                    echo round($per) . "%"; ?></span>
                    <span class="text-black-50">Profile Complate</span>
                    <span> </span>
                </div>
            </div>
            <div class="col-md-5 border-right">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Profile Details</h4>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <div class="input-group input-group-static">
                                <label class="labels">Username </label>
                                <input type="text" class="form-control" name="uname" required autocomplete="off" value="<?php echo $username; ?>" style="font-weight: bold;">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="input-group input-group-static">
                                <label class="labels">Address </label>
                                <input type="text" class="form-control" name="address" required autocomplete="off" value="<?php echo $address ?>" style="font-weight: bold;">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <!-- <div class="col-md-6 mt-2">
                            <div class="input-group input-group-static">
                                <label class="labels">First Name </label>
                                <input type="text" class="form-control" name="fname" value="<?php //echo $firstname; 
                                                                                            ?>" style="font-weight: bold;">
                            </div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <div class="input-group input-group-static">
                                <label class="labels">Last Name </label>
                                <input type="text" class="form-control" name="lname" value="<?php //echo $lastname; 
                                                                                            ?>" style="font-weight: bold;">
                            </div>
                        </div> -->
                        <div class="col-md-6 mt-2">
                            <br>
                            <div class="input-group input-group-static">
                                <label class="labels">Mobile Number </label>
                                <input type="text" class="form-control" name="phone" minlength="10" maxlength="10" value="<?php echo $mobileno ?>" style="font-weight: bold;">
                            </div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <br>
                            <div class="input-group input-group-static">
                                <label class="labels">Shop Name</label>
                                <input type="text" class="form-control" name="shop" value="<?php echo $shopname; ?>" style="font-weight: bold;" required>
                            </div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <br>
                            <div class="input-group input-group-static">
                                <label class="labels">GST NO</label>
                                <input type="text" class="form-control" name="gstno" value="<?php echo $gstno; ?>" style="font-weight: bold;" required>
                            </div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <br>
                            <label class="labels">State </label>
                            <select class="form-select" name="state" style="border: 1px solid gray; padding:5px 5px 5px 5px; font-weight: bold;" required>
                                <option value="">Select State</option>
                                <option value="Andhra Pradesh" <?php
                                                                if ($state == 'Andhra Pradesh') {
                                                                    echo "selected";
                                                                }
                                                                ?>>Andhra Pradesh</option>
                                <option value="Arunachal Pradesh" <?php
                                                                    if ($state == 'Arunachal Pradesh') {
                                                                        echo "selected";
                                                                    }
                                                                    ?>>Arunachal Pradesh</option>
                                <option value="Assam" <?php
                                                        if ($state == 'Assam') {
                                                            echo "selected";
                                                        }
                                                        ?>>Assam</option>
                                <option value="Bihar" <?php
                                                        if ($state == 'Bihar') {
                                                            echo "selected";
                                                        }
                                                        ?>>Bihar</option>
                                <option value="Chhattisgarh" <?php
                                                                if ($state == 'Chhattisgarh') {
                                                                    echo "selected";
                                                                }
                                                                ?>>Chhattisgarh</option>
                                <option value="Goa" <?php
                                                    if ($state == 'Goa') {
                                                        echo "selected";
                                                    }
                                                    ?>>Goa</option>
                                <option value="Gujarat" <?php
                                                        if ($state == 'Gujarat') {
                                                            echo "selected";
                                                        }
                                                        ?>>Gujarat</option>
                                <option value="Haryana" <?php
                                                        if ($state == 'Haryana') {
                                                            echo "selected";
                                                        }
                                                        ?>>Haryana</option>
                                <option value="Himachal Pradesh" <?php
                                                                    if ($state == 'Himachal Pradesh') {
                                                                        echo "selected";
                                                                    }
                                                                    ?>>Himachal Pradesh</option>
                                <option value="Jharkhand" <?php
                                                            if ($state == 'Jharkhand') {
                                                                echo "selected";
                                                            }
                                                            ?>>Jharkhand</option>
                                <option value="Karnataka" <?php
                                                            if ($state == 'Karnataka') {
                                                                echo "selected";
                                                            }
                                                            ?>>Karnataka</option>
                                <option value="Kerala" <?php
                                                        if ($state == 'Kerala') {
                                                            echo "selected";
                                                        }
                                                        ?>>Kerala</option>
                                <option value="Madhya Pradesh" <?php
                                                                if ($state == 'Madhya Pradesh') {
                                                                    echo "selected";
                                                                }
                                                                ?>>Madhya Pradesh</option>
                                <option value="Maharashtra" <?php
                                                            if ($state == 'Maharashtra') {
                                                                echo "selected";
                                                            }
                                                            ?>>Maharashtra</option>
                                <option value="Manipur" <?php
                                                        if ($state == 'Manipur') {
                                                            echo "selected";
                                                        }
                                                        ?>>Manipur</option>
                                <option value="Meghalaya" <?php
                                                            if ($state == 'Meghalaya') {
                                                                echo "selected";
                                                            }
                                                            ?>>Meghalaya</option>
                                <option value="Mizoram" <?php
                                                        if ($state == 'Mizoram') {
                                                            echo "selected";
                                                        }
                                                        ?>>Mizoram</option>
                                <option value="Nagaland" <?php
                                                            if ($state == 'Nagaland') {
                                                                echo "selected";
                                                            }
                                                            ?>>Nagaland</option>
                                <option value="Odisha" <?php
                                                        if ($state == 'Odisha') {
                                                            echo "selected";
                                                        }
                                                        ?>>Odisha</option>
                                <option value="Punjab" <?php
                                                        if ($state == 'Punjab') {
                                                            echo "selected";
                                                        }
                                                        ?>>Punjab</option>
                                <option value="Rajasthan" <?php
                                                            if ($state == 'Rajasthan') {
                                                                echo "selected";
                                                            }
                                                            ?>>Rajasthan</option>
                                <option value="Sikkim" <?php
                                                        if ($state == 'Sikkim') {
                                                            echo "selected";
                                                        }
                                                        ?>>Sikkim</option>
                                <option value="Tamil Nadu" <?php
                                                            if ($state == 'Tamil Nadu') {
                                                                echo "selected";
                                                            }
                                                            ?>>Tamil Nadu</option>
                                <option value="Telangana" <?php
                                                            if ($state == 'Telangana') {
                                                                echo "selected";
                                                            }
                                                            ?>>Telangana</option>
                                <option value="Tripura" <?php
                                                        if ($state == 'Tripura') {
                                                            echo "selected";
                                                        }
                                                        ?>>Tripura</option>
                                <option value="Uttar Pradesh" <?php
                                                                if ($state == 'Uttar Pradesh') {
                                                                    echo "selected";
                                                                }
                                                                ?>>Uttar Pradesh</option>
                                <option value="Uttarakhand" <?php
                                                            if ($state == 'Uttarakhand') {
                                                                echo "selected";
                                                            }
                                                            ?>>Uttarakhand</option>
                                <option value="West Bengal" <?php
                                                            if ($state == 'West Bengal') {
                                                                echo "selected";
                                                            }
                                                            ?>>West Bengal</option>
                            </select>
                        </div>
                        <div class="col-md-12 mt-2">
                            <br>
                            <div class="input-group input-group-static">
                                <label class="labels">Email ID</label>
                                <input type="text" class="form-control" value="<?php echo $email; ?>" name="email" style="font-weight: bold;" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="submit" name="update_btn">Save Changes</button></div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    let profilepic = document.getElementById("profile");
    let inputfile = document.getElementById("inputfile");

    inputfile.onchange = function() {
        profilepic.src = URL.createObjectURL(inputfile.files[0]);
    }
</script>

<?php include('footer.php'); ?>