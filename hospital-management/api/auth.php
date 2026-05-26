<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/hospital-management/config/db.php';

$action = $_POST['action'] ?? $_GET['action'] ?? '';

// REGISTER
if ($action == 'register') {
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $role = $_POST['role'];

  $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
  if (mysqli_num_rows($check) > 0) {
    if ($role == 'doctor') {
      header("Location: http://localhost/hospital-management/pages/register_doctor.php?error=Email already exists");
    } else {
      header("Location: http://localhost/hospital-management/pages/register.php?error=Email already exists");
    }
    exit();
  }

  $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";
  if (mysqli_query($conn, $sql)) {
    if ($role == 'doctor') {
      $new_id = mysqli_insert_id($conn);
      $spec = isset($_POST['specialization']) && $_POST['specialization'] != '' ? mysqli_real_escape_string($conn, $_POST['specialization']) : 'General Physician';
      $days = isset($_POST['available_days']) && $_POST['available_days'] != '' ? mysqli_real_escape_string($conn, $_POST['available_days']) : 'Mon,Tue,Wed,Thu,Fri';
      mysqli_query($conn, "INSERT INTO doctors (user_id, specialization, available_days) VALUES ('$new_id', '$spec', '$days')");
      header("Location: http://localhost/hospital-management/pages/login_doctor.php?error=Registered successfully! Please login.");
    } else {
      header("Location: http://localhost/hospital-management/pages/login_patient.php?error=Registered successfully! Please login.");
    }
    exit();
  }
}

// LOGIN
if ($action == 'login') {
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = $_POST['password'];
  $expected_role = $_POST['expected_role'] ?? '';

  $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
  $user = mysqli_fetch_assoc($result);

  $login_pages = [
    'patient' => 'http://localhost/hospital-management/pages/login_patient.php',
    'doctor'  => 'http://localhost/hospital-management/pages/login_doctor.php',
    'admin'   => 'http://localhost/hospital-management/pages/login_admin.php',
  ];

  if ($user && password_verify($password, $user['password'])) {
    if ($expected_role && $user['role'] != $expected_role) {
      $redirect = $login_pages[$expected_role];
      header("Location: $redirect?error=You are not registered as a " . ucfirst($expected_role));
      exit();
    }

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['name'] = $user['name'];
    $_SESSION['role'] = $user['role'];

    if ($user['role'] == 'doctor') {
      header("Location: http://localhost/hospital-management/pages/doctor/dashboard.php");
    } else if ($user['role'] == 'admin') {
      header("Location: http://localhost/hospital-management/pages/admin/dashboard.php");
    } else {
      header("Location: http://localhost/hospital-management/pages/patient/book_appointment.php");
    }
    exit();

  } else {
    $redirect = $login_pages[$expected_role] ?? 'http://localhost/hospital-management/pages/login_patient.php';
    header("Location: $redirect?error=Invalid email or password");
    exit();
  }
}

// LOGOUT
if ($action == 'logout') {
  session_destroy();
  header("Location: http://localhost/hospital-management/index.php");
  exit();
}
?>