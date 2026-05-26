<?php include '../includes/header.php'; ?>

<div class="container">
  <div class="form-box">
    <h2>👨‍⚕️ Doctor Register</h2>
    <p class="subtitle">Create your doctor account</p>

    <?php if(isset($_GET['error'])): ?>
      <p class="error"><?php echo $_GET['error']; ?></p>
    <?php endif; ?>

    <form action="http://localhost/hospital-management/api/auth.php" method="POST">
      <input type="hidden" name="action" value="register">
      <input type="hidden" name="role" value="doctor">

      <label>Full Name</label>
      <input type="text" name="name" placeholder="Dr. Your Name" required>

      <label>Email</label>
      <input type="email" name="email" placeholder="Enter your email" required>

      <label>Password</label>
      <input type="password" name="password" placeholder="Create a password" required>

      <label>Specialization</label>
      <input type="text" name="specialization" placeholder="e.g. Cardiologist, Dentist, Pediatrician" required>

      <label>Available Days</label>
      <select name="available_days">
        <option value="Mon,Tue,Wed,Thu,Fri">Monday to Friday</option>
        <option value="Mon,Wed,Fri">Monday, Wednesday, Friday</option>
        <option value="Tue,Thu,Sat">Tuesday, Thursday, Saturday</option>
        <option value="Mon,Tue,Wed,Thu,Fri,Sat">Monday to Saturday</option>
      </select>

      <button type="submit" style="background:#27ae60;">Register as Doctor</button>
    </form>

    <p>Already have an account? <a href="login_doctor.php">Login here</a></p>
    <p style="margin-top:8px;"><a href="/hospital-management/index.php">← Back to Home</a></p>
  </div>
</div>

<?php include '../includes/footer.php'; ?>