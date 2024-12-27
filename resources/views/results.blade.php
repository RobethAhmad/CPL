<!DOCTYPE html>
<html lang="en">
@php
    dd($violations);
@endphp

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Traffic Violation Monitoring</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/video.js/8.0.4/video-js.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
            text-align: center;
        }

        header {
            background-color:rgb(76, 99, 175);
            color: white;
            padding: 1em 0;
        }

        .container {
            margin: 20px auto;
            max-width: 800px;
        }

        .counter {
            margin-top: 20px;
            font-size: 1.5em;
            color: #333;
        }

        .video-container {
            position: relative;
            width: 100%;
            max-width: 800px;
            margin: auto;
        }

        video {
            width: 100%;
            border: 2px solid #ddd;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<header>
    <h1>Traffic Violation Monitoring</h1>
</header>

<div class="container">
    <!-- Video Section -->
    <div class="video-container">
        <iframe src="https://drive.google.com/file/d/1brrn5ep02vbPi8K6Mu6ouUTRwRFTL8zC/preview" width="640" height="480" allow="autoplay"></iframe>    </div>
    <div>
        <form action="{{ route('analyze.video') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label for="video">Upload Video:</label>
            <input type="file" name="video" id="video" accept="video/*" required>
            <button type="submit">Analyze</button>
        </form>
    </div>


    <!-- Counter Section -->
    <div class="counter">
        Total Pelanggaran: <span id="violation-count">0</span>
    </div>
</div>

<!-- <script>
    // Simulate real-time violation count updates
    let violationCount = 0;

    function updateViolationCount() {
        // Simulated increment (in real implementation, fetch from your backend API)
        violationCount += Math.floor(Math.random() * 2); // Increment by 0 or 1 randomly
        document.getElementById('violation-count').innerText = violationCount;
    }

    // Update violation count every 5 seconds
    setInterval(updateViolationCount, 5000);
</script> -->

</body>
</html>