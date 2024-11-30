<?php 
include 'config.php'; 

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login_type'])) {
        $login_type = $_POST['login_type'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        if ($login_type == 'doctor') {
            // Doctor login
            $sql = "SELECT * FROM doctors WHERE username='$username' AND password='$password'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo "Doctor login successful!";
                // Redirect to doctor's dashboard or another page
            } else {
                echo "Invalid doctor credentials.";
            }
        } elseif ($login_type == 'patient') {
            // Patient sign-in
            $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo "Patient sign-in successful!";
                // Redirect to patient's dashboard or another page
            } else {
                echo "Invalid patient credentials.";
            }
        }
    } elseif (isset($_POST['signup'])) {
        // Patient signup
        $username = $_POST['signup_username'];
        $password = $_POST['signup_password'];

        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        if ($conn->query($sql) === TRUE) {
            echo "Patient signup successful!";
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
    <title>MediGenie - Login & Signup</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <h1>MediGenie</h1>
            </div>
        </nav>
    </header>

    <main>
        <section class="login-signup-section">
            <h2>Welcome to MediGenie</h2>

            <!-- Doctor Login Form -->
            <div class="form-container">
                <h3>Doctor Login</h3>
                <form method="POST" action="">
                    <input type="hidden" name="login_type" value="doctor">
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit">Login</button>
                </form>
            </div>

            <!-- Patient Sign In Form -->
            <div class="form-container">
                <h3>Patient Sign In</h3>
                <form method="POST" action="">
                    <input type="hidden" name="login_type" value="patient">
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit">Sign In</button>
                </form>
            </div>

            <!-- Patient Sign Up Form -->
            <div class="form-container">
                <h3>Patient Sign Up</h3>
                <form method="POST" action="">
                    <input type="text" name="signup_username" placeholder="Username" required>
                    <input type="password" name="signup_password" placeholder="Password" required>
                    <button type="submit" name="signup">Sign Up</button>
                </form>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2023 MediGenie. All Rights Reserved.</p>
    </footer>
</body>
</html>