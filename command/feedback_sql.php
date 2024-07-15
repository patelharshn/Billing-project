<?php
include('conn.php');
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

if (isset($_POST['feedback_btn'])) {
    $text = $_POST['feedbacktext'];
    $num = $_POST['starnum'];

    $query_feedback = "insert into feedback(text,star,user_ID) values('$text','$num','$u_id')";
    $result_feedback = mysqli_query($con, $query_feedback);
    if ($result_feedback > 0) {
        $_SESSION['feedback_message'] = "Feedback Submitted Successfully!";
        $_SESSION['icon'] = "success";
        header("Location: http://localhost/newproject-Copy/feedback.php");
        exit();
    } else {
        $_SESSION['feedback_message'] = "Feedback Not Submitted...";
        $_SESSION['icon'] = "error";
        header("Location: http://localhost/newproject-Copy/feedback.php");
        exit();
    }
}
