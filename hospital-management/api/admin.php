<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/hospital-management/config/db.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
  header("Location: /hospital-management/pages/login.php");
  exit();
}

if(isset($_GET['action'])) {
  $id = mysqli_real_escape_string($conn, $_GET['id']);

  if($_GET['action'] == 'delete_user') {
    // Delete their appointments first
    mysqli_query($conn, "DELETE FROM appointments WHERE patient_id='$id' OR doctor_id='$id'");
    // Delete from doctors table if doctor
    mysqli_query($conn, "DELETE FROM doctors WHERE user_id='$id'");
    // Delete user
    mysqli_query($conn, "DELETE FROM users WHERE id='$id'");
    header("Location: /hospital-management/pages/admin/dashboard.php");
    exit();
  }
}
?>