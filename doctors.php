<?php 
include 'config.php';
session_start();
// Check if admin is logged in
$isAdmin = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;

// Fetch doctors from database
$doctors = [];
$sql = "SELECT * FROM doctors";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $doctors[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors - MediGenie</title>
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="/css/admin.css">

</head>
<body>
    <!-- Navigation Bar -->
    <header>
        <nav class="navbar">
            <div class="logo">
                <h1>MediGenie</h1>
            </div>
            <ul class="nav-links">
                <li><a href="index.php#about">About</a></li>
                <li><a href="index.php#services">Services</a></li>
                <li><a href="/doctors">Doctors</a></li>
                <li><a href="/research">Studies & Research</a></li>
            </ul>
            <div class="login">
                <a href="home.php">
                    <button class="login-btn">Login</button>
                </a>
            </div>
        </nav>
    </header>

    <section class="doctors-section">
        <h2>Our Doctors</h2>
        <?php if ($isAdmin): ?>
        <div class="admin-actions">
            <h3>Admin Actions</h3>
            <button class="styled-btn" onclick="openAddDoctorModal()">Add New Doctor</button>
        </div>
        <?php endif; ?>
        <?php foreach ($doctors as $doctor): ?>
        <div class="doctor-card">
            <h3><?php echo isset($doctor['dr_name']) ? $doctor['dr_name'] : ''; ?></h3>
            <p><?php echo isset($doctor['specialization']) ? $doctor['specialization'] : ''; ?></p>

            <?php if ($isAdmin): ?>
            <div class="doctor-actions">
                <button class="styled-btn" onclick="editDoctor(<?php echo $doctor['doctor_id']; ?>)">Edit</button>
                <button class="styled-btn" onclick="deleteDoctor(<?php echo $doctor['doctor_id']; ?>)">Delete</button>
            </div>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </section>

    <?php if ($isAdmin): ?>
    <!-- Add Doctor Modal -->
    <div id="addDoctorModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeAddDoctorModal()">&times;</span>
            <h3>Add New Doctor</h3>
            <form id="addDoctorForm" method="POST" action="admin.php">
                <input type="text" name="name" placeholder="Doctor Name" required>
                <input type="text" name="specialization" placeholder="Specialization" required>
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button class="styled-btn" type="submit">Add Doctor</button>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <script>
        // Doctor management functions
        function openAddDoctorModal() {
            document.getElementById('addDoctorModal').style.display = 'block';
        }

        function closeAddDoctorModal() {
            document.getElementById('addDoctorModal').style.display = 'none';
        }

        function editDoctor(doctorId) {
            // Implement edit functionality
            alert('Edit doctor with ID: ' + doctorId);
        }

        function deleteDoctor(doctorId) {
            if (confirm('Are you sure you want to delete this doctor?')) {
                // Implement delete functionality
                window.location.href = 'admin.php?action=delete&id=' + doctorId;
            }
        }
    </script>
</body>
</html>
