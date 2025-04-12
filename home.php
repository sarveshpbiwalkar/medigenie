<?php 
include 'config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediGenie - AI-Powered Health Center</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 20px; }
        textarea { width: 80%; height: 100px; }
        button { padding: 10px; margin: 10px; }
        #summary, #disease { font-size: 18px; font-weight: bold; color: green; }
    </style>
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
                <li><a href="doctors.php">Doctors</a></li>
                <li><a href="research.php">Studies & Research</a></li>
            </ul>
        </nav>
    </header>

    <section class="speech-section">
        <h2>Speech-to-Text</h2>
        <p>Click the button below to start speaking, and your speech will be converted into text.</p>

        <button id="start-record" class="cta-btn" onclick="startRecording()">Start Recording</button>
        <button id="stop-record" class="cta-btn" onclick="stopRecording()" style="display:inline-block;">Stop Recording</button>
        <button id="save-text" class="cta-btn" onclick="saveTextAsFile()">Save as Text File</button>
        <button id="reset-page" class="cta-btn" onclick="resetPage()">Reset</button>

        <div id="transcript-container">
            <h3>Recognized Text:</h3>
            <textarea id="transcript" rows="10" placeholder="Your speech will appear here..."></textarea>
        </div>
    </section>
    <br><br>

    <button class="cta-btn" onclick="summarizeText()">Summarize</button>
    <button class="cta-btn" onclick="predictDisease()">Predict Disease</button>
    <br><br>
    <p><strong>Summary:</strong> <span id="summary"></span></p>
    <br><br>
    <p><strong>Predicted Diseases:</strong> <span id="disease"></span></p>

    <section class="main-content">
        <section class="patient-list-section">
            <h3>Patient:</h3>
            <div class="patient-list">
                <?php if (isset($_SESSION['user'])): ?>
                    <div class="patient-card" onclick="showPatientDetails('patient1')">
                        <p>Name: <?php echo htmlspecialchars($_SESSION['user']['name']); ?></p>
                        <p>Age: <?php echo htmlspecialchars($_SESSION['user']['age']); ?> years</p>
                        <p>Click for more details...</p>
                    </div>
                <?php else: ?>
                    <p>Please log in to see your details.</p>
                <?php endif; ?>
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

    <script>
        let mediaRecorder;
        let audioChunks = [];

        function startRecording() {
            navigator.mediaDevices.getUserMedia({ audio: true })
                .then(stream => {
                    mediaRecorder = new MediaRecorder(stream);
                    mediaRecorder.start();
                    audioChunks = [];

                    mediaRecorder.addEventListener("dataavailable", event => {
                        audioChunks.push(event.data);
                    });

                    mediaRecorder.addEventListener("stop", () => {
                        const audioBlob = new Blob(audioChunks);
                        const formData = new FormData();
                        formData.append("file", audioBlob, "recording.wav");

                        fetch("http://localhost:5000/transcribe_audio", {
                            method: "POST",
                            body: formData
                        })
                        .then(res => res.json())
                        .then(data => {
                            document.getElementById("transcript").value = data.text;
                        });
                    });
                })
                .catch(error => console.error("Microphone access denied or error:", error));
        }

        function stopRecording() {
            if (mediaRecorder && mediaRecorder.state === "recording") {
                mediaRecorder.stop();
            }
        }

        function summarizeText() {
            let text = document.getElementById("transcript").value;

            fetch("http://localhost:5000/summarize", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ text: text })
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById("summary").innerText = data.summary;
            })
            .catch(error => console.error("Error:", error));
        }

        function predictDisease() {
            let text = document.getElementById("transcript").value;

            fetch("http://localhost:5000/predict_disease", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ text: text })
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById("disease").innerText = data.predicted_diseases;
            })
            .catch(error => console.error("Error:", error));
        }

        function resetPage() {
            window.location.reload();
        }

        function saveTextAsFile() {
            const text = document.getElementById("transcript").value;
            const blob = new Blob([text], { type: "text/plain" });
            const link = document.createElement("a");
            link.href = URL.createObjectURL(blob);
            link.download = "transcript.txt";
            link.click();
        }
    </script>
    <script src="js/speech.js"></script>

</body>
</html>
