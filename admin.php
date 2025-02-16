<?php
include 'config.php';
session_start();

// Redirect if not logged in as admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: signup-signin.php");
    exit();
}

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle add doctor form
    if (isset($_POST['add_doctor'])) {
        $name = $_POST['doctor_name'];
        $specialization = $_POST['specialization'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "INSERT INTO doctors (name, specialization, username, password) 
                VALUES ('$name', '$specialization', '$username', '$password')";
        
        if ($conn->query($sql) === TRUE) {
            $success_message = "Doctor added successfully!";
        } else {
            $error_message = "Error adding doctor: " . $conn->error;
        }
    }

    // Handle remove doctor form
    if (isset($_POST['remove_doctor'])) {
        $doctor_id = $_POST['doctor_id'];
        
        $sql = "DELETE FROM doctors WHERE doctor_id = $doctor_id";
        
        if ($conn->query($sql) === TRUE) {
            $success_message = "Doctor removed successfully!";
        } else {
            $error_message = "Error removing doctor: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - MediGenie</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <h1>MediGenie Admin</h1>
            </div>
            <ul class="nav-links">
                <li><a href="admin.php">Dashboard</a></li>
                <li><a href="doctors.php">Doctors</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main class="admin-container">
        <section class="add-doctor">
            <h2>Add New Doctor</h2>
            <form method="POST" action="">
                <input type="text" name="doctor_name" placeholder="Doctor Name" required>
                <input type="text" name="specialization" placeholder="Specialization" required>
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="add_doctor">Add Doctor</button>
            </form>
        </section>

        <section class="remove-doctor">
            <h2>Remove Doctor</h2>
            <form method="POST" action="">
                <select name="doctor_id" required>
                    <?php
                    $sql = "SELECT doctor_id, name FROM doctors";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='{$row['doctor_id']}'>{$row['name']}</option>";
                    }
                    ?>
                </select>
                <button type="submit" name="remove_doctor">Remove Doctor</button>
            </form>
        </section>

        <?php if (isset($success_message)): ?>
            <div class="message success"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="message error"><?php echo $error_message; ?></div>
        <?php endif; ?>
    </main>

    <script src="js/admin.js"></script>
</body>
</html>
