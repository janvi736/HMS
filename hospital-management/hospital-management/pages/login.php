<?php include '../includes/header.php'; ?>

<div class="container">
  <div class="form-box">
    <h2>Login</h2>

    <?php if(isset($_GET['error'])): ?>
      <p class="error"><?php echo $_GET['error']; ?></p>
    <?php endif; ?>

    <form action="/hospital-management/api/auth.php" method="POST">
      <input type="hidden" name="action" value="login">

      <label>Email</label>
      <input type="email" name="email" placeholder="Enter your email" required>

      <label>Password</label>
      <input type="password" name="password" placeholder="Enter your password" required>

      <button type="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="register.php">Register here</a></p>
  </div>
</div>

<?php include '../includes/footer.php'; ?>