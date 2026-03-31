<?php
include '../../includes/header.php';
if(!isset($_SESSION['user_id'])) {
  header("Location: /hospital-management/pages/login.php");
  exit();
}
?>

<div class="container">
  <div class="form-box" style="max-width:600px">
    <h2>Book an Appointment</h2>

    <?php if(isset($_GET['success'])): ?>
      <p class="success"><?php echo $_GET['success']; ?></p>
    <?php endif; ?>
    <?php if(isset($_GET['error'])): ?>
      <p class="error"><?php echo $_GET['error']; ?></p>
    <?php endif; ?>

    <form action="/hospital-management/api/appointments.php" method="POST">
      <input type="hidden" name="action" value="book">

      <label>Select Doctor</label>
      <select name="doctor_id" required>
        <option value="">-- Choose a Doctor --</option>
        <?php
        include '../../config/db.php';
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