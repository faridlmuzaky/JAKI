<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Odoj Tracker</title>
    <script>
        function copyToClipboard() {
            let text = document.getElementById('odojList').innerText;
            navigator.clipboard.writeText(text).then(() => {
                alert("Daftar berhasil disalin!");
            });
        }
    </script>
</head>
<body>
    <h1>{{ $title }}</h1>
    <ul id="odojList">
        @foreach($juzAssignments as $name => $juz)
            <li>{{ $name }} = JUZ {{ $juz }}</li>
        @endforeach
    </ul>
    <button onclick="copyToClipboard()">Copy</button>
</body>
</html>
