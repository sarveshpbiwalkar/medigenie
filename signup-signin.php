<?php 
include 'config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login_type'])) {
        $login_type = $_POST['login_type'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        if ($login_type == 'patient') {
            // Patient sign-in
            $sql = "SELECT * FROM users WHERE username='$username' AND password_hash='$password'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                $dob = new DateTime($user['dob']);
                $today = new DateTime();
                $age = $today->diff($dob)->y;
                $_SESSION['user'] = [
                    'name' => $user['name'],
                    'age' => $age,
                    'gender' => $user['gender'],
                    'history' => $user['chronic_diseases'],
                ];
                header("Location: home.php");
                exit();
            } else {
                echo "Invalid patient credentials.";
            }
        } elseif ($login_type == 'doctor') {
            // Doctor login
            $sql = "SELECT * FROM doctors WHERE username='$username' AND password='$password'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                header("Location: home.php");
                exit();
            } else {
                echo "Invalid doctor credentials.";
            }
        } elseif ($login_type == 'admin') {
            // Admin login
            $sql = "SELECT * FROM admins WHERE username='$username' AND password='$password'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $_SESSION['admin_logged_in'] = true;
                header("Location: /admin");

                exit();
            } else {
                echo "Invalid admin credentials.";
            }
        }
    } elseif (isset($_POST['signup'])) {
        // Patient signup
        $username = $_POST['signup_username'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $dob = $_POST['dob'];
        $gender = $_POST['gender'];
        $chronic_diseases = $_POST['chronic_diseases'];
        $password = $_POST['signup_password'];

        $sql = "INSERT INTO users (username, name, email, phone_number, dob, gender, chronic_diseases, password_hash) VALUES ('$username', '$name', '$email', '$phone_number', '$dob', '$gender', '$chronic_diseases', '$password')";
        if ($conn->query($sql) === TRUE) {
            $_SESSION['signup_success'] = "Patient signup successful!";
            header("Location: /signup-signin");

            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediGenie - User Login</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="css/signup-in.css">
</head>
<body>
    <h2>Login to MediGenie</h2>
    <div class="form-container">
        <h2>Patient Login</h2>
        <form method="POST" action="">
            <input type="hidden" name="login_type" value="patient">
            <label for="username">Username:</label>
            <input type="text" name="username" placeholder="Username" required>
            <br><br>
            <label for="password">Password:</label>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <span class="signup-link" id="signupBtn">Not registered? Sign Up</span>
        <span class="doctor-login-link" id="doctorLoginBtn">Login as Doctor</span>
        <span class="admin-login-link" id="adminLoginBtn">Login as Admin</span>
    </div>

    <!-- Modal for User Signup -->
    <div id="signupModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" id="closeSignupModal">&times;</span>
            <h3>Patient Sign Up</h3>
            <form method="POST" action="">
                <input type="text" name="signup_username" placeholder="Username" required>
                <input type="text" name="name" placeholder="Full Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="phone_number" placeholder="Phone Number" required>
                <input type="date" name="dob" placeholder="Date of Birth" required>
                <select name="gender" required>
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
                <input type="text" name="chronic_diseases" placeholder="Chronic Diseases (if any)">
                <input type="password" name="signup_password" placeholder="Password" required>
                <button type="submit" name="signup">Sign Up</button>
            </form>
        </div>
    </div>

    <!-- Modal for Doctor Login -->
    <div id="doctorLoginModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" id="closeDoctorLoginModal">&times;</span>
            <h3>Doctor Login</h3>
            <br><br>
            <form method="POST" action="">
                <input type="hidden" name="login_type" value="doctor">
                <label for="username">Username:</label>
                <input type="text" name="username" placeholder="Username" required>
                <br><br>
                <label for="password">Password:</label>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>

    <!-- Modal for Admin Login -->
    <div id="adminLoginModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" id="closeAdminLoginModal">&times;</span>
            <h3>Admin Login</h3>
            <br><br>
            <form method="POST" action="">
                <input type="hidden" name="login_type" value="admin">
                <label for="username">Username:</label>
                <input type="text" name="username" placeholder="Username" required>
                <br><br>
                <label for="password">Password:</label>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>

    <script>
        // Get modal elements
        var signupModal = document.getElementById("signupModal");
        var doctorLoginModal = document.getElementById("doctorLoginModal");
        var adminLoginModal = document.getElementById("adminLoginModal");
        var signupBtn = document.getElementById("signupBtn");
        var doctorLoginBtn = document.getElementById("doctorLoginBtn");
        var adminLoginBtn = document.getElementById("adminLoginBtn");
        var closeSignupModal = document.getElementById("closeSignupModal");
        var closeDoctorLoginModal = document.getElementById("closeDoctorLoginModal");
        var closeAdminLoginModal = document.getElementById("closeAdminLoginModal");

        // Open modals on button clicks
        signupBtn.onclick = function() { signupModal.style.display = "flex"; }
        doctorLoginBtn.onclick = function() { doctorLoginModal.style.display = "flex"; }
        adminLoginBtn.onclick = function() { adminLoginModal.style.display = "flex"; }

        // Close modals on close button clicks
        closeSignupModal.onclick = function() { signupModal.style.display = "none"; }
        closeDoctorLoginModal.onclick = function() { doctorLoginModal.style.display = "none"; }
        closeAdminLoginModal.onclick = function() { adminLoginModal.style.display = "none"; }

        // Close modals when clicking outside
        window.onclick = function(event) {
            if (event.target == signupModal) signupModal.style.display = "none";
            if (event.target == doctorLoginModal) doctorLoginModal.style.display = "none";
            if (event.target == adminLoginModal) adminLoginModal.style.display = "none";
        }
    </script>
</body>
</html>
