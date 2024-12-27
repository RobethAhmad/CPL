import os
os.environ['TF_CPP_MIN_LOG_LEVEL'] = '2'

from flask import Flask, request, jsonify
from flask_cors import CORS
import tensorflow as tf
import cv2
import numpy as np

app = Flask(__name__)
CORS(app)  # Enable CORS for cross-origin requests

@app.route('/detect', methods=['POST'])
def detect():
    if 'file' not in request.files:
        return jsonify({'error': 'No file provided'}), 400

    file = request.files['file']
    if file:
        file_type = file.content_type
        file_bytes = np.frombuffer(file.read(), np.uint8)
        
        if "image" in file_type:
            image = cv2.imdecode(file_bytes, cv2.IMREAD_COLOR)
            result = process_image(image)
        elif "video" in file_type:
            result = process_video(file_bytes)
        else:
            return jsonify({'error': 'Unsupported file type'}), 400

        return jsonify({'result': result})
    return jsonify({'error': 'File upload failed'}), 500

def process_image(image):
    # Placeholder for CNN-based image detection logic
    return {'detections': 'Example detections for image'}

def process_video(video_bytes):
    # Load the video from bytes
    video_array = np.frombuffer(video_bytes, np.uint8)
    video = cv2.imdecode(video_array, cv2.IMREAD_COLOR)

    # Initialize video capture from the video array
    cap = cv2.VideoCapture(video)

    # Placeholder for results
    results = []

    # Load your pre-trained model (replace 'model_path' with your actual model path)
    model = tf.keras.models.load_model('model_path')  # Load your model here

    while cap.isOpened():
        ret, frame = cap.read()
        if not ret:
            break

        # Preprocess the frame for the model
        input_frame = preprocess_frame(frame)

        # Make predictions
        predictions = model.predict(input_frame)

        # Process predictions to detect motorcycles without helmets
        detections = detect_motorcycles_without_helmets(predictions)

        results.append(detections)

    cap.release()
    return {'detections': results}

def preprocess_frame(frame):
    # Resize and normalize the frame for the model
    frame_resized = cv2.resize(frame, (224, 224))  # Adjust size based on your model
    frame_normalized = frame_resized / 255.0  # Normalize to [0, 1]
    return np.expand_dims(frame_normalized, axis=0)  # Add batch dimension

def detect_motorcycles_without_helmets(predictions):
    # Process the predictions to find motorcycles without helmets
    # This is a placeholder function. You need to implement the logic based on your model's output.
    detections = []
    for prediction in predictions:
        # Assuming the model outputs bounding boxes and class labels
        # Example: if prediction contains [x, y, width, height, class_id]
        if prediction['class_id'] == 'motorcycle' and not prediction['helmet']:
            detections.append(prediction)
    return detections

if __name__ == '__main__':
    app.run(debug=True, port=5000)
