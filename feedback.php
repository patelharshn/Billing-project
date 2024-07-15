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
if (isset($_SESSION['feedback_message']) && $_SESSION['feedback_message'] != "") {
    if ($_SESSION['feedback_message'] != "" && isset($_SESSION['feedback_message']) == "Feedback Submitted Successfully!") {
?>
        <script>
            Swal.fire({
                icon: '<?php echo $_SESSION['icon']; ?>',
                text: '<?php echo $_SESSION['feedback_message']; ?>',
                showConfirmButton: false,
                timer: 2500,
                toast: true,
                position: "top",
            });
        </script>
    <?php
        unset($_SESSION['feedback_message']);
    } else {
    ?>
        <script>
            Swal.fire({
                icon: '<?php echo $_SESSION['icon']; ?>',
                text: '<?php echo $_SESSION['feedback_message']; ?>',
                showConfirmButton: false,
                timer: 2500,
                toast: true,
                position: "top",
            });
        </script>
    <?php
        unset($_SESSION['feedback_message']);
    } ?>
<?php
}
?>

<div class="container-fluid vh-100 h-100">
    <div class="row min-vh-80 h-100">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="command/feedback_sql.php" method="post">
                        <div class="container-wrapper">
                            <div class="container d-flex align-items-center justify-content-center">
                                <div class="row justify-content-center">
                                    <h2 class="text-center">Give Feedback</h2>
                                    <div class="full-star-ratings mt-4" data-rateyo-full-star="true"></div>
                                    <textarea required name="feedbacktext" class="mt-4" cols="20" rows="5" style="resize: none;" placeholder="Write your feedback here..."></textarea>
                                    <input hidden value="0" type="text" id="starrating" name="starnum">
                                </div>
                            </div>
                            <div class="mt-4" style="align-items: center; text-align: center;">
                                <button type="submit" class="btn btn-primary" name="feedback_btn">
                                    Give Feedback
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
<script>
    $('.full-star-ratings').rateYo({
        rating: 0,
    });
    $('.full-star-ratings').click(function() {
        var $rateYo = $(".full-star-ratings").rateYo();
        var rating = $rateYo.rateYo("rating");

        // window.alert("Its " + rating + " Yo!");
        $('#starrating').attr("value", rating);
    });
</script>
<?php include('footer.php'); ?>