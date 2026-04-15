<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice Viewer</title>

    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
            background: #f5f5f5;
        }

        .pdf-container {
            width: 100%;
            height: 100vh;
        }

        iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
</head>

<body>

    <div class="pdf-container">
        <iframe src="https://docs.google.com/gview?url={{ $pdfUrl }}&embedded=true"></iframe>
    </div>

</body>

</html>
