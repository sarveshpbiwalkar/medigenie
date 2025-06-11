from flask import Flask, request, jsonify
from flask_cors import CORS
import whisper
import tempfile

app = Flask(__name__)
CORS(app)

# Load Whisper model (choose: tiny, base, small, medium, large)
model = whisper.load_model("medium")

@app.route('/transcribe_audio', methods=['POST'])
def transcribe_audio():
    if 'file' not in request.files:
        return jsonify({"error": "No file uploaded"}), 400

    file = request.files['file']
    
    with tempfile.NamedTemporaryFile(delete=False, suffix=".wav") as tmp_file:
        file.save(tmp_file.name)
        result = model.transcribe(tmp_file.name)

    return jsonify({"text": result['text']})

# Keep these routes if you are still using summarization and disease prediction
from transformers import pipeline

summarizer = pipeline("summarization", model="sshleifer/distilbart-cnn-12-6")
classifier = pipeline("zero-shot-classification")
possible_diseases = [
    "diabetes", "hypertension", "asthma", "anemia", "tuberculosis",
    "covid-19", "migraine", "depression", "arthritis", "malaria",
    "pneumonia", "flu", "heart disease", "allergy", "thyroid disorder"
]

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
