<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediGenie - AI-Powered Health Center</title>
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
            <!-- <button class="dark-mode-toggle" onclick="toggleDarkMode()">Dark Mode</button> -->
        </nav>
    </header>

    <!-- Banner Section -->
    <section class="banner">
        <div class="banner-content">
            <div class="text-content">
                <h1>AI-Powered End-to-End Clinical Intelligence and Assistance</h1>
                <p>Blending technology & care for better treatment results</p>
                <button class="cta-btn">Make an Appointment</button>
            </div>
            <div class="doctor-info">
                <p>Over 80 highly qualified specialists</p>
                <!-- <img src="doctor-placeholder.png" alt="Doctor" class="banner-image"> -->
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="main-content">
        <div class="card-section">
            <div class="card">
                <p>First visit discount: save 15% in May</p>
                <button class="special-offer">Special Offer</button>
            </div>
            <div class="card">
                <p>100+ published research papers</p>
                <button class="view-research">Publications</button>
            </div>
            <div class="card">
                <p>25 years of exciting experience</p>
                <button class="experience-btn">Experience</button>
            </div>
        </div>

        <section id="about" class="about-section">
            <h2>About MediGenie</h2>
            <p>At MediGenie, we harness the power of AI to assist healthcare providers by analyzing and summarizing clinical data. Our mission is to enhance decision-making, reduce administrative burdens, and ultimately improve patient outcomes.</p>
            <p>We integrate real-time patient interactions, medical record analysis, and AI-driven predictions to bring a seamless solution into the clinical workflow.</p>
        </section>

        <div class="benefits-section">
            <div class="benefits-card">
                <h2>AI-Powered Diagnostics</h2>
                <p>Leveraging cutting-edge AI technologies for clinical decision support.</p>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="services-section">
        <h2>Our AI-Powered Services</h2>
        <div class="service-card">
            <h3>AI-Assisted Diagnosis</h3>
            <p>We leverage AI to provide fast and accurate diagnostics, giving doctors real-time insights to make informed decisions.</p>
        </div>
        <div class="service-card">
            <h3>Personalized Treatment</h3>
            <p>Our system recommends medication based on patient history, offering personalized care plans tailored to individual needs.</p>
        </div>
        <div class="service-card">
            <h3>Data Summarization</h3>
            <p>Summarizing vast amounts of clinical data, our AI-driven technology allows doctors to quickly assess patient histories and act efficiently.</p>
        </div>
    </section>

    <script>
        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
        }
    </script>

</body>
</html>