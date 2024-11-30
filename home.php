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
        </nav>
    </header>

    <section class="speech-section">
        <h2>Speech-to-Text</h2>
        <p>Click the button below to start speaking, and your speech will be converted into text.</p>
    
        <button id="start-record" class="cta-btn">Start Recording</button>
        <button id="save-text" class="cta-btn" style="display:none;">Save as Text File</button>
    
        <div id="transcript-container">
            <h3>Recognized Text:</h3>
            <textarea id="transcript" rows="10" placeholder="Your speech will appear here..." readonly></textarea>
        </div>
    </section>

    <section class="main-content">
        <section class="patient-list-section">
            <h3>Patient:</h3>
            <div class="patient-list">
                <!-- Short patient info displayed -->
                <div class="patient-card" onclick="showPatientDetails('patient1')">
                    <p>Name: John Doe</p>
                    <p>Age: 34</p>
                    <p>Click for more details...</p>
                </div>
                <!-- <div class="patient-card" onclick="showPatientDetails('patient2')">
                    <p>Name: Sarah Smith</p>
                    <p>Age: 28</p>
                    <p>Click for more details...</p>
                </div> -->
            </div>
        </section>
    </section>
    
    <!-- Modal Popup for detailed patient info -->
    <div id="patient-modal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <div id="patient-details">
                <!-- Dynamic content will be injected here based on selection -->
            </div>
        </div>
    </div>
    <script src="speech.js"></script>    

</body>
</html>

