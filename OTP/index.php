<?php
session_start();
require('../command/conn.php');

if (!isset($_SESSION['mail'])) {
    header("location: http://localhost/newproject-Copy/signup/index.php");
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Varification</title>

    <link rel="shortcut icon" href="favicon.png">

    <link rel="stylesheet" href="./style.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <!-- CDN Sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="./script.js" defer></script>
</head>

<body>
    <div class="container">
        <header>
            <i class="bx bxs-check-shield"></i>
        </header>
        <h4>Enter OTP Code</h4>
        <h5>Otp Send On <?php echo $_SESSION['mail']; ?></h5>
        <form action="index.php" method="post">
            <div class="input-field">
                <input name="1" type="number" />
                <input name="2" type="number" disabled />
                <input name="3" type="number" disabled />
                <input name="4" type="number" disabled />
            </div>
            <button name="btn_verify">Verify OTP</button>
        </form>
    </div>
    </div>
</body>

</html>

<?php

if (isset($_POST['btn_verify']) && isset($_SESSION['shop'])) {
    $u_otp = $_POST['1'] . $_POST['2'] . $_POST['3'] . $_POST['4'];
    $otp = $_SESSION['otp'];
    if ($otp == $u_otp) {
?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success...',
                text: 'Otp Verify Successfully!',
            });
        </script>
        <?php

        $shop = $_SESSION['shop'];
        $mail = $_SESSION['mail'];
        $uname = $_SESSION['uname'];
        $pass = $_SESSION['pass'];
        $state = $_SESSION['state'];
        $imgprofile = $_SESSION['img_profile'];
        echo "<script>alert($imgprofile);</script>";

        $hashpassord = password_hash($pass, PASSWORD_DEFAULT);

        $query_inserts = "insert into user(shopname,email,username,password,state,image) values('$shop','$mail','$uname','$hashpassord','$state','$imgprofile')";
        $result = mysqli_query($con, $query_inserts);
        $row = mysqli_affected_rows($con);

        if ($row >= 0) {
            unset($_SESSION['shop']);
            unset($_SESSION['mail']);
            unset($_SESSION['uname']);
            unset($_SESSION['pass']);
            unset($_SESSION['otp']);
            unset($_SESSION['state']);
            unset($_SESSION['img_profile']);

            $_SESSION['message'] = "SignUp Successfully...Please Login With Email And Password!";
            $_SESSION['icon'] = "success";
            $_SESSION['title'] = "Success...";
            header("Location: http://localhost/newproject-Copy/login/index.php");
            exit();
        }
    } else {
        ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error...',
                text: 'Incorrect OTP...Please enter valid OTP',
            });
        </script>
    <?php
    }
}



if (isset($_POST['btn_verify'])) {
    $u_otp = $_POST['1'] . $_POST['2'] . $_POST['3'] . $_POST['4'];
    $otp = $_SESSION['otp'];
    if ($otp == $u_otp) {
        header("Location: http://localhost/newproject-Copy/forgotpass/forgotpassword.php");
        exit();
    } else {
    ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error....',
                text: 'Otp Incorrect...',
            });
        </script>
<?php
    }
}
?>