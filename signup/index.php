<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <!-- CDN Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- CDN Css Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- CDN Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <?php
    session_start();
    if (isset($_SESSION['message']) && $_SESSION['message'] != '') {
        if (isset($_SESSION['message']) && $_SESSION['message'] == 'Register Successfully!') {
    ?>
            <script>
                Swal.fire({
                    icon: '<?php echo $_SESSION['icon']; ?>',
                    text: '<?php echo $_SESSION['message']; ?>',
                    showConfirmButton: false,
                    timer: 2500,
                    toast: true,
                    position: "top",
                }).then(function() {
                    window.location.href = "http://localhost/newproject-Copy/login/index.php";
                });
            </script>
        <?php
            unset($_SESSION['message']);
        } else {
        ?>
            <script>
                Swal.fire({
                    icon: '<?php echo $_SESSION['icon']; ?>',
                    text: '<?php echo $_SESSION['message'] ?>',
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
    <section class="vh-90.5 mt-56" style="background-color: #eeee;">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-black" style="border-radius: 25px;">
                        <div class="card-body p-md-5">
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up</p>

                                    <form class="mx-1 mx-md-4" action="command.php" method="post" enctype="multipart/form-data">
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <div class="form-outline flex-fill mb-0">
                                                <!-- <?php
                                                        // if (isset($_SESSION['img_profile'])) {
                                                        ?>
                                                    <img class="rounded-circle" id="profile" width="150px" src="../assets/images/profile/<?php echo $_SESSION['img_profile']; ?>">

                                                <?php
                                                // } else {
                                                ?> -->
                                                <img class="rounded-circle" id="profile" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg">

                                                <!-- <?php
                                                        // }
                                                        ?> -->
                                                <br>
                                                <span class="btn btn-primary btn-file">Upload image<input type="file" id="inputfile" accept="image/png, image/jpeg" required name="profileimg_signup"></span>
                                                <span> </span>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <?php
                                                if (isset($_SESSION['uname'])) {
                                                ?>
                                                    <input type="text" id="" class="form-control" name="uname" value="<?php echo $_SESSION['uname']; ?>" required>
                                                <?php
                                                    unset($_SESSION['uname']);
                                                } else {
                                                ?>
                                                    <input type="text" id="" class="form-control" name="uname" value="" required>
                                                <?php
                                                }
                                                ?>
                                                <!-- <input type="text" id="form3Example1c" class="form-control" name="uname" required> -->
                                                <label class="form-label" for="form3Example1c">Your Name</label>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-shop fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <?php
                                                if (isset($_SESSION['shop'])) {
                                                ?>
                                                    <input type="text" id="form3Example1c" class="form-control" name="shop" value="<?php echo $_SESSION['shop']; ?>" required>
                                                <?php
                                                    unset($_SESSION['shop']);
                                                } else {
                                                ?>
                                                    <input type="text" id="form3Example1c" class="form-control" value="" name="shop" required>
                                                <?php
                                                }
                                                ?>
                                                <!-- <input type="text" id="form3Example1c" class="form-control" name="shop" required> -->
                                                <label class="form-label" for="form3Example1c">Shop Name</label>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <?php
                                                if (isset($_SESSION['mail'])) {
                                                ?>
                                                    <input type="email" id="form3Example3c" class="form-control" value="<?php echo $_SESSION['mail']; ?>" name="mail" required />
                                                <?php
                                                    unset($_SESSION['mail']);
                                                } else {
                                                ?>
                                                    <input type="email" id="form3Example3c" class="form-control" value="" name="mail" required />
                                                <?php
                                                }
                                                ?>
                                                <!-- <input type="email" id="form3Example3c" class="form-control" name="mail" required /> -->
                                                <label class="form-label" for="form3Example3c">Your Email</label>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <?php
                                                if (isset($_SESSION['pass'])) {
                                                ?>
                                                    <input type="password" id="form3Example4c" class="form-control" value="<?php echo $_SESSION['pass']; ?>" name="pass" required />
                                                <?php
                                                    unset($_SESSION['pass']);
                                                } else {
                                                ?>
                                                    <input type="password" id="form3Example4c" class="form-control" value="" name="pass" required />
                                                <?php
                                                }
                                                ?>
                                                <!-- <input type="password" id="form3Example4c" class="form-control" name="pass" required /> -->
                                                <label class="form-label" for="form3Example4c">Password</label>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <?php
                                                if (isset($_SESSION['cpass'])) {
                                                ?>
                                                    <input type="password" id="form3Example4cd" class="form-control" value="<?php echo $_SESSION['cpass']; ?>" name="cpass" required />
                                                <?php
                                                    unset($_SESSION['cpass']);
                                                } else {
                                                ?>
                                                    <input type="password" id="form3Example4cd" class="form-control" value="" name="cpass" required />
                                                <?php
                                                }
                                                ?>
                                                <!-- <input type="password" id="form3Example4cd" class="form-control" name="cpass" required /> -->
                                                <label class="form-label" for="form3Example4cd">Repeat your password</label>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fas fa-city fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <select class="form-select" name="state" style="border: 1px solid gray; padding:5px 5px 5px 5px;" required>
                                                    <?php
                                                    if (isset($_SESSION['state'])) {
                                                    ?>
                                                        <option value="<?php echo $_SESSION['state']; ?>" selected><?php echo $_SESSION['state']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                    <option value="">Select State</option>
                                                    <option value="Andhra Pradesh">Andhra Pradesh</option>
                                                    <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                                    <option value="Assam">Assam</option>
                                                    <option value="Bihar">Bihar</option>
                                                    <option value="Chhattisgarh">Chhattisgarh</option>
                                                    <option value="Goa">Goa</option>
                                                    <option value="Gujarat">Gujarat</option>
                                                    <option value="Haryana">Haryana</option>
                                                    <option value="Himachal Pradesh">Himachal Pradesh</option>
                                                    <option value="Jharkhand">Jharkhand</option>
                                                    <option value="Karnataka">Karnataka</option>
                                                    <option value="Kerala">Kerala</option>
                                                    <option value="Madhya Pradesh">Madhya Pradesh</option>
                                                    <option value="Maharashtra">Maharashtra</option>
                                                    <option value="Manipur">Manipur</option>
                                                    <option value="Meghalaya">Meghalaya</option>
                                                    <option value="Mizoram">Mizoram</option>
                                                    <option value="Nagaland">Nagaland</option>
                                                    <option value="Odisha">Odisha</option>
                                                    <option value="Punjab">Punjab</option>
                                                    <option value="Rajasthan">Rajasthan</option>
                                                    <option value="Sikkim">Sikkim</option>
                                                    <option value="Tamil Nadu">Tamil Nadu</option>
                                                    <option value="Telangana">Telangana</option>
                                                    <option value="Tripura">Tripura</option>
                                                    <option value="Uttar Pradesh">Uttar Pradesh</option>
                                                    <option value="Uttarakhand">Uttarakhand</option>
                                                    <option value="West Bengal">West Bengal</option>
                                                </select>
                                                <label class="form-label" for="form3Example4cd">State</label>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <button type="submit" class="btn btn-primary btn-lg" name="btn_reg">Get OTP</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
                                    <img src="../assets/images/logo.webp" class="img-fluid" alt="IMS">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        let profilepic = document.getElementById("profile");
        let inputfile = document.getElementById("inputfile");

        inputfile.onchange = function() {
            profilepic.src = URL.createObjectURL(inputfile.files[0]);
        }
    </script>

    <!-- Script CDN Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>