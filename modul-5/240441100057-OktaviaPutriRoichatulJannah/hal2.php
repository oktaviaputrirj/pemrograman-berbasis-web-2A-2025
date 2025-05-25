<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Timeline Pengalaman Kuliah</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #eaf7ec;
            color: #333;
        }

        h1 {
            font-size: 45px;
            color: #2e7d32;
            text-align: center;
            margin-bottom: 30px;
        }

        nav {
            text-align: center;
        }

        nav a {
            display: inline-block;
            background-color:#388e3c;
            color: white;
            padding: 10px 20px;
            margin: 5px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s;
        }

        nav a:hover {
            background-color:  #66bb6a;
        }

        .timeline-container {
            max-width: 700px;
            margin: 0 auto;
            position: relative;
            padding-left: 30px;
        }
        
        .timeline-item {
            margin-bottom: 30px;
            position: relative;
            padding-left: 25px;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 8px;
            width: 12px;
            height: 12px;
            background-color: #2e7d32;
            border-radius: 50%;
        }

        .timeline-item h3 {
            margin-bottom: 5px;
            color: #2e7d32;
        }

        .timeline-item p {
            margin: 0;
            background: #f1f8f2;
            padding: 10px 15px;
            border-radius: 8px;
        }

        .timeline-line {
            position: absolute;
            left: 5px;
            top: 0;
            bottom: 0;
            width: 2px;
            background-color: #a5d6a7;
        }

        blockquote {
            text-align:center; 
            font-style: italic; 
            color: #4caf50;
        }
    </style>
</head>
<body>
        
    <h1>Timeline Pengalaman Kuliah</h1>

    <nav>
        <a href="hal1.php">🏠 Profil Interaktif</a>
        <a href="hal2.php">Timeline Kuliah</a>
        <a href="hal3.php">Blog Reflektif</a>
    </nav>

    <div class="timeline-container">
        <div class="timeline-line"></div>

        <?php

        $timeline = [
            "Agustus 2024" => "🎓 Masuk kuliah di Universitas Trunojoyo Madura, jurusan Sistem Informasi.",
            "Oktober 2024" => "🤝 Mulai aktif berpartisipasi dalam organisasi eksternal, yakni IKMARO.",
            "November 2024" => "💻 Mengerjakan proyek aplikasi sistem kasir berbasis python untuk transaksi jual beli sederhana.",
            "Maret 2025" => "🌐 Mengerjakan tugas membuat portofolio profesional, website restoran, berita dll."
        ];

        function tampilkanTimeline($timeline) {
            foreach ($timeline as $tahun => $pengalaman) {
                echo "<div class='timeline-item'>";
                echo "<h3>$tahun</h3>";
                echo "<p>$pengalaman</p>";
                echo "</div>";
            }
        }

        tampilkanTimeline($timeline);
        ?>
    </div>

    <blockquote>
        "You don’t have to be great to start, but you have to start to be great." - Zig Ziglar
    </blockquote>

</body>
</html>
