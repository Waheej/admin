<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>Test GitHub to cPanel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            text-align: center;
            margin-top: 100px;
        }
        .card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
            display: inline-block;
        }
        h1 {
            color: #0073e6;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>🚀 Hello from GitHub & cPanel!</h1>
        <p>الربط بين <b>GitHub</b> و <b>cPanel</b> شغال 100%</p>
        <p>التاريخ: <span id="date"></span></p>
    </div>

    <script>
        document.getElementById("date").innerText = new Date().toLocaleString();
    </script>
</body>
</html>
