<?php include '../includes/header.php'; ?>

<div class="container">
  <div class="form-box">
    <h2>Register</h2>

    <?php if(isset($_GET['error'])): ?>
      <p class="error"><?php echo $_GET['error']; ?></p>
    <?php endif; ?>

    <form action="/hospital-management/api/auth.php" method="POST">
      <input type="hidden" name="action" value="register">

      <label>Full Name</label>
      <input type="text" name="name" placeholder="Enter your full name" required>

      <label>Email</label>
      <input type="email" name="email" placeholder="Enter your email" required>

      <label>Password</label>
      <input type="password" name="password" placeholder="Create a password" required>

      <label>Role</label>
      <select name="role">
        <option value="patient">Patient</option>
        <option value="doctor">Doctor</option>
      </select>

      <button type="submit">Register</button>
    </form>

    <p>Already have an account? <a href="login.php">Login here</a></p>
  </div>
</div>

<?php include '../includes/footer.php'; ?>