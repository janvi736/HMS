<?php include '../includes/header.php'; ?>

<div class="container">
  <div class="form-box">
    <h2 style="color:#27ae60;">👨‍⚕️ Doctor Login</h2>

    <?php if(isset($_GET['error'])): ?>
      <p class="error"><?php echo $_GET['error']; ?></p>
    <?php endif; ?>

    <form action="http://localhost/hospital-management/api/auth.php" method="POST">
      <input type="hidden" name="action" value="login">
      <input type="hidden" name="expected_role" value="doctor">

      <label>Email</label>
      <input type="email" name="email" placeholder="Enter your email" required>

      <label>Password</label>
      <input type="password" name="password" placeholder="Enter your password" required>

      <button type="submit" style="background:#27ae60;">Login as Doctor</button>
    </form>

    <p>Don't have an account? <a href="register_doctor.php">Register as Doctor</a></p>
<p style="margin-top:8px;"><a href="/hospital-management/index.php">← Back to Home</a></p>
  </div>
</div>

<?php include '../includes/footer.php'; ?>