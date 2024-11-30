<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors - MediGenie</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Navigation Bar -->
    <header>
        <nav class="navbar">
            <div class="logo">
                <h1>MediGenie</h1>
            </div>
            <ul class="nav-links">
                <li><a href="index.html#about">About</a></li>
                <li><a href="index.html#services">Services</a></li>
                <li><a href="doctors.html">Doctors</a></li>
                <li><a href="research.html">Studies & Research</a></li>
            </ul>
            <div class="login">
                <a href="home.html">
                    <button class="login-btn">Login</button>
                </a>
            </div>
        </nav>
    </header>

    <section class="doctors-section">
        <h2>Our Doctors</h2>
        <div class="doctor-card">
            <h3>Dr. Sarah Thompson</h3>
            <p>Cardiologist - Expert in AI-driven heart disease predictions.</p>
        </div>
        <div class="doctor-card">
            <h3>Dr. James Rodriguez</h3>
            <p>Neurologist - Specializes in AI-assisted neurological diagnostics.</p>
        </div>
        <div class="doctor-card">
            <h3>Dr. Emily Johnson</h3>
            <p>Endocrinologist - Focuses on AI-powered hormone disorder analysis.</p>
        </div>
    </section>
</body>
</html>
