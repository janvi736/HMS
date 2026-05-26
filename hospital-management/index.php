<?php include 'includes/header.php'; ?>

<div class="home-container">
  <h1>🏥 Hospital Management System</h1>
  <p>Choose your portal to continue</p>

  <div class="role-cards">
    <a href="/hospital-management/pages/login_patient.php" class="role-card">
      <span class="icon">🧑‍🤝‍🧑</span>
      <h3>Patient</h3>
      <p>Book & manage appointments</p>
    </a>

    <a href="/hospital-management/pages/login_doctor.php" class="role-card">
      <span class="icon">👨‍⚕️</span>
      <h3>Doctor</h3>
      <p>View your schedule</p>
    </a>

    <a href="/hospital-management/pages/login_admin.php" class="role-card">
      <span class="icon">🛡️</span>
      <h3>Admin</h3>
      <p>Manage the system</p>
    </a>
  </div>
</div>

<?php include 'includes/footer.php'; ?>