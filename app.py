from flask import Flask, request, jsonify
from flask_cors import CORS
from transformers import pipeline 
import re
import speech_recognition as sr
import tempfile

app = Flask(__name__)
CORS(app)

# Load local models
summarizer = pipeline("summarization", model="facebook/bart-large-cnn")
classifier = pipeline("zero-shot-classification")

# Disease categories to match against
possible_diseases = [
    "diabetes", "hypertension", "asthma", "anemia", "tuberculosis",
    "covid-19", "migraine", "depression", "arthritis", "malaria",
    "pneumonia", "flu", "heart disease", "allergy", "thyroid disorder"
]

@app.route('/transcribe_audio', methods=['POST'])
def transcribe_audio():
    if 'file' not in request.files:
        return jsonify({"error": "No file uploaded"}), 400

    file = request.files['file']
    recognizer = sr.Recognizer()

    with tempfile.NamedTemporaryFile(delete=False, suffix=".wav") as tmp_file:
        file.save(tmp_file.name)
        with sr.AudioFile(tmp_file.name) as source:
            audio_data = recognizer.record(source)

    try:
        text = recognizer.recognize_google(audio_data)
        return jsonify({"text": text})
    except sr.UnknownValueError:
        return jsonify({"error": "Speech not recognized"})
    except sr.RequestError as e:
        return jsonify({"error": str(e)})

@app.route('/summarize', methods=['POST'])
def summarize_text():
    data = request.json
    user_input = data.get("text", "")

    if not user_input.strip():
        return jsonify({"summary": "No input text provided."})

    summary_text = summarizer(user_input, max_length=300, min_length=30, do_sample=False)[0]['summary_text']
    return jsonify({"summary": summary_text})

@app.route('/predict_disease', methods=['POST'])
def predict_disease():
    data = request.json
    user_input = data.get("text", "")

    if not user_input.strip():
        return jsonify({"predicted_diseases": "No input text provided."})

    result = classifier(user_input, possible_diseases, multi_label=True)
    predictions = sorted(zip(result['labels'], result['scores']), key=lambda x: x[1], reverse=True)
    top_diseases = [label for label, score in predictions[:5]]

    return jsonify({"predicted_diseases": ", ".join(top_diseases)})

if __name__ == '__main__':
    app.run(host="0.0.0.0", port=5000, debug=True)
