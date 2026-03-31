<?php
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
    header("Location: ../pages/register.php?error=Email already exists");
    exit();
  }

  $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";
if (mysqli_query($conn, $sql)) {
  if ($role == 'doctor') {
    $new_id = mysqli_insert_id($conn);
    mysqli_query($conn, "INSERT INTO doctors (user_id, specialization, available_days) VALUES ('$new_id', 'General Physician', 'Mon,Tue,Wed,Thu,Fri')");
  }
  header("Location: ../pages/login.php?error=Registered successfully! Please login.");
  exit();

  }
}

// LOGIN
if ($action == 'login') {
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = $_POST['password'];

  $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
  $user = mysqli_fetch_assoc($result);

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['name'] = $user['name'];
    $_SESSION['role'] = $user['role'];

    if ($user['role'] == 'doctor') {
      header("Location: ../pages/doctor/dashboard.php");
    } else {
      header("Location: ../pages/patient/book_appointment.php");
    }
    exit();
  } else {
    header("Location: ../pages/login.php?error=Invalid email or password");
    exit();
  }
}

// LOGOUT
if ($action == 'logout') {
  session_destroy();
  header("Location: /hospital-management/pages/login.php");
  exit();
}
?>