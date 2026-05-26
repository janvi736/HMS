<?php
include '../../includes/header.php';
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
  header("Location: /hospital-management/pages/login.php");
  exit();
}
include '../../config/db.php';

// Counts
$total_patients = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM users WHERE role='patient'"))['count'];
$total_doctors  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM users WHERE role='doctor'"))['count'];
$total_appointments = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM appointments"))['count'];
$pending = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM appointments WHERE status='pending'"))['count'];
?>

<div style="padding:30px;">

  <h2 style="color:#2c7be5; margin-bottom:24px;">🛡️ Admin Panel</h2>

  <!-- Stats Cards -->
  <div style="display:flex; gap:20px; margin-bottom:36px; flex-wrap:wrap;">
    <div class="stat-card" style="background:#e8f4fd; border-left:5px solid #2c7be5;">
      <h3><?php echo $total_patients; ?></h3>
      <p>Total Patients</p>
    </div>
    <div class="stat-card" style="background:#e8fdf0; border-left:5px solid #27ae60;">
      <h3><?php echo $total_doctors; ?></h3>
      <p>Total Doctors</p>
    </div>
    <div class="stat-card" style="background:#fff8e8; border-left:5px solid #f39c12;">
      <h3><?php echo $total_appointments; ?></h3>
      <p>Total Appointments</p>
    </div>
    <div class="stat-card" style="background:#fdf0f0; border-left:5px solid #e74c3c;">
      <h3><?php echo $pending; ?></h3>
      <p>Pending Appointments</p>
    </div>
  </div>

  <!-- All Appointments -->
  <h3 style="color:#2c7be5; margin-bottom:16px;">📋 All Appointments</h3>
  <table class="dashboard-table" style="margin-bottom:40px;">
    <thead>
      <tr>
        <th>Patient</th>
        <th>Doctor</th>
        <th>Specialization</th>
        <th>Date</th>
        <th>Time</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $appointments = mysqli_query($conn, "
        SELECT a.*, 
          u1.name as patient_name, 
          u2.name as doctor_name,
          d.specialization
        FROM appointments a
        JOIN users u1 ON a.patient_id = u1.id
        JOIN users u2 ON a.doctor_id = u2.id
        JOIN doctors d ON a.doctor_id = d.user_id
        ORDER BY a.appointment_date DESC
      ");
      while($row = mysqli_fetch_assoc($appointments)):
      ?>
      <tr>
        <td><?php echo $row['patient_name']; ?></td>
        <td><?php echo $row['doctor_name']; ?></td>
        <td><?php echo $row['specialization']; ?></td>
        <td><?php echo $row['appointment_date']; ?></td>
        <td><?php echo $row['time_slot']; ?></td>
        <td><span class="status <?php echo $row['status']; ?>"><?php echo ucfirst($row['status']); ?></span></td>
        <td>
          <a href="/hospital-management/api/appointments.php?action=delete&id=<?php echo $row['id']; ?>"
             onclick="return confirm('Delete this appointment?')"
             style="color:red;">Delete</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

  <!-- All Doctors -->
  <h3 style="color:#2c7be5; margin-bottom:16px;">👨‍⚕️ All Doctors</h3>
  <table class="dashboard-table" style="margin-bottom:40px;">
    <thead>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Specialization</th>
        <th>Available Days</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $doctors = mysqli_query($conn, "
        SELECT u.*, d.specialization, d.available_days 
        FROM users u 
        JOIN doctors d ON u.id = d.user_id 
        WHERE u.role='doctor'
      ");
      while($row = mysqli_fetch_assoc($doctors)):
      ?>
      <tr>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['specialization']; ?></td>
        <td><?php echo $row['available_days']; ?></td>
        <td>
          <a href="/hospital-management/api/admin.php?action=delete_user&id=<?php echo $row['id']; ?>"
             onclick="return confirm('Delete this doctor?')"
             style="color:red;">Delete</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

  <!-- All Patients -->
  <h3 style="color:#2c7be5; margin-bottom:16px;">🧑‍🤝‍🧑 All Patients</h3>
  <table class="dashboard-table">
    <thead>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Registered On</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $patients = mysqli_query($conn, "SELECT * FROM users WHERE role='patient' ORDER BY created_at DESC");
      while($row = mysqli_fetch_assoc($patients)):
      ?>
      <tr>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo date('d M Y', strtotime($row['created_at'])); ?></td>
        <td>
          <a href="/hospital-management/api/admin.php?action=delete_user&id=<?php echo $row['id']; ?>"
             onclick="return confirm('Delete this patient?')"
             style="color:red;">Delete</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

</div>

<?php include '../../includes/footer.php'; ?>