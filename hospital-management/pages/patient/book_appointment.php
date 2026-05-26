<?php
include '../../includes/header.php';
if(!isset($_SESSION['user_id'])) {
  header("Location: /hospital-management/pages/login.php");
  exit();
}
include '../../config/db.php';
$patient_id = $_SESSION['user_id'];
?>

<div style="padding: 30px;">

  <!-- My Appointments -->
  <h2 style="color:#2c7be5; margin-bottom:20px;">📋 My Appointments</h2>

  <?php if(isset($_GET['success'])): ?>
    <p class="success" style="margin-bottom:16px;"><?php echo $_GET['success']; ?></p>
  <?php endif; ?>
  <?php if(isset($_GET['error'])): ?>
    <p class="error" style="margin-bottom:16px;"><?php echo $_GET['error']; ?></p>
  <?php endif; ?>

  <?php
  $my_appointments = mysqli_query($conn, "
    SELECT a.*, u.name as doctor_name, d.specialization
    FROM appointments a
    JOIN users u ON a.doctor_id = u.id
    JOIN doctors d ON a.doctor_id = d.user_id
    WHERE a.patient_id = '$patient_id'
    ORDER BY a.appointment_date DESC, a.time_slot DESC
  ");
  $count = mysqli_num_rows($my_appointments);
  ?>

  <?php if($count == 0): ?>
    <p style="color:#888; margin-bottom:30px;">You have no appointments yet.</p>
  <?php else: ?>
  <table class="dashboard-table" style="margin-bottom:40px;">
    <thead>
      <tr>
        <th>Doctor</th>
        <th>Specialization</th>
        <th>Date</th>
        <th>Time</th>
        <th>Notes</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = mysqli_fetch_assoc($my_appointments)): ?>
      <tr>
        <td><?php echo $row['doctor_name']; ?></td>
        <td><?php echo $row['specialization']; ?></td>
        <td><?php echo $row['appointment_date']; ?></td>
        <td><?php echo $row['time_slot']; ?></td>
        <td><?php echo $row['notes'] ?: '-'; ?></td>
        <td>
          <span class="status <?php echo $row['status']; ?>">
            <?php echo ucfirst($row['status']); ?>
          </span>
        </td>
        <td>
          <?php if($row['status'] != 'cancelled'): ?>
            <a href="/hospital-management/api/appointments.php?action=patient_cancel&id=<?php echo $row['id']; ?>"
               onclick="return confirm('Cancel this appointment?')"
               style="color:red;">Cancel</a>
          <?php else: ?>
            <span style="color:#ccc;">-</span>
          <?php endif; ?>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
  <?php endif; ?>

  <!-- Book New Appointment -->
  <h2 style="color:#2c7be5; margin-bottom:20px;">📅 Book New Appointment</h2>
  <div class="form-box" style="max-width:600px; margin:0;">
    <form action="http://localhost/hospital-management/api/appointments.php" method="POST">
      <input type="hidden" name="action" value="book">

      <label>Select Doctor</label>
      <select name="doctor_id" required>
        <option value="">-- Choose a Doctor --</option>
        <?php
        $result = mysqli_query($conn, "SELECT u.id, u.name, d.specialization FROM users u JOIN doctors d ON u.id = d.user_id WHERE u.role='doctor'");
        while($row = mysqli_fetch_assoc($result)) {
          echo "<option value='{$row['id']}'>{$row['name']} - {$row['specialization']}</option>";
        }
        ?>
      </select>

      <label>Appointment Date</label>
      <input type="date" name="appointment_date" required min="<?php echo date('Y-m-d'); ?>">

      <label>Time Slot</label>
      <select name="time_slot" required>
        <option value="">-- Choose a Time --</option>
        <option value="09:00">09:00 AM</option>
        <option value="10:00">10:00 AM</option>
        <option value="11:00">11:00 AM</option>
        <option value="12:00">12:00 PM</option>
        <option value="14:00">02:00 PM</option>
        <option value="15:00">03:00 PM</option>
        <option value="16:00">04:00 PM</option>
      </select>

      <label>Notes (optional)</label>
      <input type="text" name="notes" placeholder="Describe your symptoms">

      <button type="submit">Book Appointment</button>
    </form>
  </div>
</div>

<?php include '../../includes/footer.php'; ?>