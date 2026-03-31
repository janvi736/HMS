<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/hospital-management/config/db.php';

$action = $_POST['action'] ?? '';

if ($action == 'book') {
  $patient_id = $_SESSION['user_id'];
  $doctor_id = mysqli_real_escape_string($conn, $_POST['doctor_id']);
  $date = mysqli_real_escape_string($conn, $_POST['appointment_date']);
  $time = mysqli_real_escape_string($conn, $_POST['time_slot']);
  $notes = mysqli_real_escape_string($conn, $_POST['notes']);

  // Check if slot already booked
  $check = mysqli_query($conn, "SELECT * FROM appointments WHERE doctor_id='$doctor_id' AND appointment_date='$date' AND time_slot='$time'");
  if (mysqli_num_rows($check) > 0) {
    header("Location: ../pages/patient/book_appointment.php?error=This slot is already booked. Please choose another.");
    exit();
  }

  $sql = "INSERT INTO appointments (patient_id, doctor_id, appointment_date, time_slot, notes) VALUES ('$patient_id', '$doctor_id', '$date', '$time', '$notes')";
  if (mysqli_query($conn, $sql)) {
    header("Location: ../pages/patient/book_appointment.php?success=Appointment booked successfully!");
    exit();
  }
}
if (isset($_GET['action']) && isset($_GET['id'])) {
  $id = mysqli_real_escape_string($conn, $_GET['id']);

  if ($_GET['action'] == 'delete') {
    mysqli_query($conn, "DELETE FROM appointments WHERE id='$id'");
  } else {
    $status = $_GET['action'] == 'confirm' ? 'confirmed' : 'cancelled';
    mysqli_query($conn, "UPDATE appointments SET status='$status' WHERE id='$id'");
  }

  header("Location: /hospital-management/pages/doctor/dashboard.php");
  exit();

}
?>
