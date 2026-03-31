<?php
include '../../includes/header.php';
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'doctor') {
  header("Location: /hospital-management/pages/login.php");
  exit();
}
include '../../config/db.php';
$doctor_id = $_SESSION['user_id'];
$appointments = mysqli_query($conn, "
  SELECT a.*, u.name as patient_name 
  FROM appointments a 
  JOIN users u ON a.patient_id = u.id 
  WHERE a.doctor_id = '$doctor_id' 
  ORDER BY a.appointment_date, a.time_slot
");
?>

<div class="container" style="display:block; padding:30px;">
  <h2 style="color:#2c7be5; margin-bottom:20px;">👨‍⚕️ Doctor Dashboard</h2>

  <table class="dashboard-table">
    <thead>
      <tr>
        <th>Patient</th>
        <th>Date</th>
        <th>Time</th>
        <th>Notes</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = mysqli_fetch_assoc($appointments)): ?>
      <tr>
        <td><?php echo $row['patient_name']; ?></td>
        <td><?php echo $row['appointment_date']; ?></td>
        <td><?php echo $row['time_slot']; ?></td>
        <td><?php echo $row['notes'] ?: '-'; ?></td>
        <td>
          <span class="status <?php echo $row['status']; ?>">
            <?php echo ucfirst($row['status']); ?>
          </span>
        </td>
        <td>
          <a href="/hospital-management/api/appointments.php?action=confirm&id=<?php echo $row['id']; ?>">Confirm</a> |
          <a href="/hospital-management/api/appointments.php?action=cancel&id=<?php echo $row['id']; ?>">Cancel</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php include '../../includes/footer.php'; ?>