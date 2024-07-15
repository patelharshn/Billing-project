<?php
include('conn.php');

if (isset($_POST['btn_tempo_add']) && isset($_POST['u_id'])) {
  $tempo_num = $_POST['t_num'];
  $u_id = $_POST['u_id'];

  $query_duplicate = "select tempo_number from tempo where tempo_number='$tempo_num' AND user_id='$u_id'";
  $result_duplicate = mysqli_query($con, $query_duplicate);
  if (mysqli_num_rows($result_duplicate) > 0) {
    session_start();
    $_SESSION['tempo_message'] = "Tempo Number already exists!";
    $_SESSION['icon'] = "error";
    header("Location: http://localhost/newproject-Copy/tempo.php");
    exit();
  } else {
    $query_tempo_insert = "insert into tempo(tempo_number,user_id) values('$tempo_num','$u_id')";
    $result_tempo_insert = mysqli_query($con, $query_tempo_insert);
    if (mysqli_affected_rows($con)) {
      session_start();
      $_SESSION['tempo_message'] = "Tempo Number added successful";
      $_SESSION['icon'] = "success";
      header("Location: http://localhost/newproject-Copy/tempo.php");
      exit();
    }
  }
}

if (isset($_POST['btn_tempo_edit']) && isset($_POST['t_id']) && isset($_POST['t_num'])) {
  $t_id = $_POST['t_id'];
  $tempo_num = $_POST['t_num'];

  $query_tempo_edit = "update tempo set tempo_number='$tempo_num' where id='$t_id'";
  $result_tempo_edit = mysqli_query($con, $query_tempo_edit);
  if (mysqli_affected_rows($con)) {
    session_start();
    $_SESSION['tempo_message'] = "Tempo Number edited successful";
    $_SESSION['icon'] = "success";
    header("Location: http://localhost/newproject-Copy/tempo.php");
    exit();
  } else {
    session_start();
    $_SESSION['tempo_message'] = "Tempo Number not edited";
    $_SESSION['icon'] = "error";
    header("Location: http://localhost/newproject-Copy/tempo.php");
    exit();
  }
}

if (isset($_POST['yes_btn'])) {
  $delete_t_id = $_POST['delete_t_id'];
  $query_tempo_delete = "delete from tempo where id='$delete_t_id'";
  $result_tempo_delete = mysqli_query($con, $query_tempo_delete);
  if (mysqli_affected_rows($con)) {
    session_start();
    $_SESSION['tempo_message'] = "Tempo Number deleted successful";
    $_SESSION['icon'] = "success";
    header("Location: http://localhost/newproject-Copy/tempo.php");
    exit();
  } else {
    session_start();
    $_SESSION['tempo_message'] = "Tempo Number not deleted";
    $_SESSION['icon'] = "error";
    header("Location: http://localhost/newproject-Copy/tempo.php");
    exit();
  }
}
