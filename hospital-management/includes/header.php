<?php if(session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hospital Management System</title>
  <link rel="stylesheet" href="/hospital-management/assets/css/style.css">
</head>
<body>

<nav>
  <h1>🏥 MediCare</h1>
  <div>
    <?php if(isset($_SESSION['user_id'])): ?>
      <span>Welcome, <?php echo $_SESSION['name']; ?></span>
      <a href="/hospital-management/api/auth.php?action=logout">Logout</a>
    <?php else: ?>
      <a href="/hospital-management/index.php">Login</a>
    <?php endif; ?>
  </div>
</nav>