<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Juz 30 Hari</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h2 { display: inline-block; margin-right: 10px; }
        button {
            padding: 5px 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 14px;
        }
        button:hover { background-color: #0056b3; }
        pre { background: #f4f4f4; padding: 10px; border-radius: 5px; }
    </style>
</head>
<body>
    <h1>Jadwal Juz 30 Hari</h1>
    @php
        setlocale(LC_TIME, 'id_ID.utf8'); // Pastikan nama bulan dalam bahasa Indonesia
        $startDate = strtotime("2025-03-01"); // 1 Maret 2025 = 1 Ramadhan 1446 H
    @endphp

    @foreach ($schedule as $hari => $juzList)
        @php
            $currentDate = strftime("%e %B %Y", strtotime("+".($hari - 1)." days", $startDate));
            $currentDate = trim($currentDate); // Hapus spasi ekstra sebelum tanggal
            $title = "Odoj $hari Ramadhan 1446 H ($currentDate)";
        @endphp
        <div style="margin-top: 20px;">
            <h2>{{ $title }}</h2>
            <button onclick="copyToClipboard('juz-{{ $hari }}', '{{ $title }}')">Copy</button>
        </div>
        <pre id="juz-{{ $hari }}">{{ implode("\n", $juzList) }}</pre>
    @endforeach

    <script>
        function copyToClipboard(elementId, title) {
            let text = document.getElementById(elementId).innerText;
            let fullText = title + "\n\n" + text; // Tambahkan judul di awal
            navigator.clipboard.writeText(fullText).then(() => {
                alert("Jadwal berhasil disalin!");
            }).catch(err => {
                console.error("Gagal menyalin:", err);
            });
        }
    </script>
</body>
</html>
