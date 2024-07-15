<?php
include('../command/conn.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'C:\xampp\htdocs\newproject-Copy\PHPMailer\PHPMailer.php';
require 'C:\xampp\htdocs\newproject-Copy\PHPMailer\SMTP.php';
require 'C:\xampp\htdocs\newproject-Copy\PHPMailer\Exception.php';

session_start();
if (isset($_POST['mail'])) {
    $email = $_POST['mail'];
    $query_email_check = "select * from user where email='$email'";
    $result_email_check = mysqli_query($con, $query_email_check);
    $row = mysqli_num_rows($result_email_check);
    if ($row > 0) {
        $otp = rand(1111, 9999);
        $_SESSION['otp'] = $otp;
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'hp004086@gmail.com';
            $mail->Password   = 'jkofloznkmebgcnv';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            $mail->setFrom('hp004086@gmail.com', 'IMS');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'IMS(Inventory Managment System) forgot password OTP';
            $mail->Body    = "<div style='font-family: Helvetica,Arial,sans-serif;min-width:700px;overflow:auto;line-height:2'>
                <div style='margin:50px auto;width:600px;padding:20px 0'>
                  <div style='border-bottom:1px solid #eee'>
                    <a style='font-size:1.4em;color: #00466a;text-decoration:none;font-weight:600'>Inventory Management System</a>
                  </div>
                  <p style='font-size:1.1em'>Hi,</p>
                  <p>We received a request to verify your email address. <br/>Your verification code is:</p>
                  <h2 style='background: #00466a;margin: 0 auto;width: max-content;padding: 0 10px;color: #fff;border-radius: 4px;'>$otp</h2>
                  <p style='font-size:0.9em;'>
                    This OTP is valid for 5 minutes.
                    <br/>
                    If you did not request this code, it is possible that someone else is trying to access your account. <br/><b>Do not forward or give this code to anyone.</b>
                    <br/>
                    <br/>
                    Sincerely yours,
                    <br/>
                    The IMS Project team</p>
                  <hr style='border:none;border-top:1px solid #eee' />
                  <div style='padding:8px 0;color:#aaa;font-size:0.8em;line-height:1;font-weight:300'>
                    <p>This email can't receive replies.</p>
                  </div>
                  <div style='float:right;padding:8px 0;color:#aaa;font-size:0.8em;line-height:1;font-weight:300'>
                    <p>Ganpat University</p>
                    <p>Dcs, Kherva</p>
                    <p>India</p>
                  </div>
                </div>
              </div>";
            if ($mail->send()) {
                $_SESSION['otp'] = $otp;
                $_SESSION['mail'] = $email;
                header("Location: http://localhost/newproject-Copy/OTP/index.php");
                exit();
            }
        } catch (Exception $e) {
?>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error...',
                    text: '<?php echo "OTP could not be sent. Please Check your internet connection or enter valid email ID" ?>',
                });
            </script>
<?php

        }
    } else {
        $_SESSION['email_message'] = "Email Is Not Found..";
        $_SESSION['icon'] = "error";
        header("Location: http://localhost/newproject-Copy/forgotpass/");
        exit();
    }
}

if (isset($_POST['updatebtn'])) {
    $pass = $_POST['passs'];
    $cpass = $_POST['cpasss'];
    $userEmail = $_SESSION['mail'];

    $hashpassord = password_hash($pass, PASSWORD_DEFAULT);

    if ($pass == $cpass) {
        $update_password = "update user set password='$hashpassord' where email='$userEmail'";
        $result_password = mysqli_query($con, $update_password);
        $row = mysqli_affected_rows($con);
        if ($row > 0) {
            session_start();
            $_SESSION['update_message'] = "Password Update Successfully!";
            $_SESSION['icon'] = "success";
            header("Location: http://localhost/newproject-Copy/login/index.php");
            exit();
        }
    } else {
        $_SESSION['cpass_message'] = "Confirm Password Is not match";
        $_SESSION['icon'] = "error";
        header("Location: http://localhost/newproject-Copy/forgotpass/forgotpassword.php");
        exit();
    }
}
