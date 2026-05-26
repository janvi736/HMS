<?php include '../includes/header.php'; ?>

<div class="container">
  <div class="form-box">
    <h2>Register</h2>

    <?php if(isset($_GET['error'])): ?>
      <p class="error"><?php echo $_GET['error']; ?></p>
    <?php endif; ?>

    <form action="http://localhost/hospital-management/api/auth.php" method="POST">
      <input type="hidden" name="action" value="register">

      <label>Full Name</label>
      <input type="text" name="name" placeholder="Enter your full name" required>

      <label>Email</label>
      <input type="email" name="email" placeholder="Enter your email" required>

      <label>Password</label>
      <input type="password" name="password" placeholder="Create a password" required>

      <label>Role</label>
<select name="role" id="role" onchange="toggleSpec()">
  <option value="patient">Patient</option>
  <option value="doctor">Doctor</option>
</select>

<div id="spec-field" style="display:none">
  <label>Specialization</label>
  <input type="text" name="specialization" placeholder="e.g. Cardiologist, Dentist, Pediatrician">
</div>

<script>
function toggleSpec() {
  var role = document.getElementById('role').value;
  document.getElementById('spec-field').style.display = role === 'doctor' ? 'block' : 'none';
}
</script>

      <button type="submit">Register</button>
    </form>

    <p>Already have an account? <a href="login.php">Login here</a></p>
  </div>
</div>

<?php include '../includes/footer.php'; ?>