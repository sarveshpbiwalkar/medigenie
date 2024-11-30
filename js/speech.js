// Check if the browser supports Web Speech API
const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
const recognition = new SpeechRecognition();

recognition.lang = 'en-US';  // Set the language
recognition.interimResults = false;  // Only get final results, not interim
recognition.maxAlternatives = 1;

const startButton = document.getElementById('start-record');
const saveButton = document.getElementById('save-text');
const transcriptArea = document.getElementById('transcript');

let recognizedText = "";

// Start speech recognition when the user clicks the button
startButton.addEventListener('click', () => {
    recognition.start();
    transcriptArea.value = "Listening...";
    startButton.innerHTML = "Listening...";
});

// Capture speech results
recognition.onresult = (event) => {
    recognizedText = event.results[0][0].transcript;
    transcriptArea.value = recognizedText;
    startButton.innerHTML = "Start Recording";
    saveButton.style.display = "inline-block";
};

// Error handling
recognition.onerror = (event) => {
    alert("Error occurred in recognition: " + event.error);
    startButton.innerHTML = "Start Recording";
};

// Save recognized text as a text file
saveButton.addEventListener('click', () => {
    const blob = new Blob([recognizedText], { type: 'text/plain' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = "recognized-speech.txt";
    link.click();
});



// Sample patient data
const patients = {
    "patient1": {
        name: "John Doe",
        age: 34,
        gender: "Male",
        bloodType: "O+",
        history: "No significant medical history.",
        conditions: "No current conditions"
    },
    "patient2": {
        name: "Sarah Smith",
        age: 28,
        gender: "Female",
        bloodType: "A-",
        history: "Has a history of asthma.",
        conditions: "Mild hypertension"
    }
};

// Function to show patient details in the modal
function showPatientDetails(patientId) {
    const patient = patients[patientId];

    // Populate modal content with patient details
    const patientDetails = `
        <h3>Patient Details:</h3>
        <p><strong>Name:</strong> ${patient.name}</p>
        <p><strong>Age:</strong> ${patient.age}</p>
        <p><strong>Gender:</strong> ${patient.gender}</p>
        <p><strong>Blood Type:</strong> ${patient.bloodType}</p>
        <p><strong>Medical History:</strong> ${patient.history}</p>
        <p><strong>Current Conditions:</strong> ${patient.conditions}</p>
    `;

    document.getElementById('patient-details').innerHTML = patientDetails;

    // Show the modal and add the blur effect to the background content (excluding modal)
    document.getElementById('patient-modal').style.display = "block";
    document.getElementById('main-content').classList.add("blur-background");
}

// Function to close the modal
function closeModal() {
    document.getElementById('patient-modal').style.display = "none";
    document.getElementById('main-content').classList.remove("blur-background");
}
