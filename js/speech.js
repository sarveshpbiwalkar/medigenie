// Web Speech API setup
const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
const recognition = new SpeechRecognition();

// Configuration for long conversations
recognition.lang = 'en-US';
recognition.interimResults = true;  // Show interim results
recognition.continuous = true;      // Enable continuous recognition
recognition.maxAlternatives = 1;

const startButton = document.getElementById('start-record');
const saveButton = document.getElementById('save-text');
const transcriptArea = document.getElementById('transcript');

let recognizedText = "";

// Handle speech start/end events
recognition.onspeechstart = () => {
    console.log('Speech started');
};

recognition.onspeechend = () => {
    console.log('Speech ended');
};

// Start speech recognition when the user clicks the button
startButton.addEventListener('click', () => {
    recognition.start();
    transcriptArea.value = "Listening...";
    startButton.innerHTML = "Listening...";
});

// Handle recognition results
recognition.onresult = (event) => {
    let interimTranscript = '';
    let finalTranscript = '';

    for (let i = event.resultIndex; i < event.results.length; ++i) {
        if (event.results[i].isFinal) {
            finalTranscript += event.results[i][0].transcript;
        } else {
            interimTranscript += event.results[i][0].transcript;
        }
    }

    recognizedText = finalTranscript || interimTranscript;
    transcriptArea.value = recognizedText;
    saveButton.style.display = "inline-block";
};

// Error handling
recognition.onerror = (event) => {
    if (event.error !== 'no-speech') {
        alert("Error occurred in recognition: " + event.error);
    }
    startButton.innerHTML = "Start Recording";
};

// Handle when recognition ends
recognition.onend = () => {
    if (recognizedText) {
        saveButton.style.display = "inline-block";
    }
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
    "patient1": userData
};

// Function to show patient details in the modal
function showPatientDetails(patientId) {
    const patient = patients[patientId];

    // Populate modal content with patient details
    const patientDetails = `
        <h3>Patient Details:</h3>
        <p><strong>Name:</strong> ${patient.name}</p>
        <p><strong>Age:</strong> ${patient.age} years</p>
        <p><strong>Gender:</strong> ${patient.gender}</p>
        <p><strong>Blood Type:</strong> ${patient.bloodType || 'N/A'}</p>
        <p><strong>Medical History:</strong> ${patient.history || 'N/A'}</p>
        <p><strong>Current Conditions:</strong> ${patient.conditions || 'N/A'}</p>
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
