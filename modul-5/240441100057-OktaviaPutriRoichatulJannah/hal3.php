<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Blog Reflektif Mahasiswa</title>
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

        h2 {
            color: #2e7d32;
            margin-bottom: 15px;
        }

        nav {
            text-align: center;
            margin-bottom: 40px;
        }

        nav a {
            display: inline-block;
            background-color: #388e3c;
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

        .artikel {
            max-width: 700px;
            margin: 0 auto;
            background: #f1f8f2;
            padding: 25px;
            border-radius: 10px;
        }

        .artikel img {
            max-width: 100%;
            border-radius: 10px;
            margin-top: 15px;
        }

        blockquote {
            font-style: italic;
            color: #4e944f;
            margin: 20px 0;
            padding-left: 15px;
            border-left: 4px solid #66bb6a;
        }

        .sumber a {
            color: #388e3c;
        }

        .artikel-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 300px;
            transition: transform 0.3s ease;
            text-decoration: none;
            color: inherit;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .card-content {
            padding: 15px;
        }

        .card-title {
            color: #2e7d32;
            margin: 0 0 10px 0;
        }

        .card-date {
            font-size: 15px;
            color: #777;
        }
    </style>
</head>
<body>

    <h1>Blog Reflektif Mahasiswa</h1>

    <nav>
        <a href="hal1.php">🏠 Profil Interaktif</a>
        <a href="hal2.php">Timeline Kuliah</a>
        <a href="hal3.php">Blog Reflektif</a>
    </nav>

        <?php
        $kutipan = [
            "“Belajarlah dari kemarin, hiduplah untuk hari ini, berharaplah untuk besok.”",
            "“Kesuksesan bukanlah kebetulan, itu adalah kerja keras dan ketekunan.”",
            "“Setiap tantangan adalah kesempatan untuk tumbuh.”",
            "“Jangan takut untuk memulai sesuatu yang besar.”",
            "“Konsistensi adalah kunci menuju keunggulan.”"
        ];

        $blog = [
            1 => [
                "judul" => "Pengalaman Belajar HTML & CSS",
                "tanggal" => "12 Januari 2025",
                "refleksi" => "Saya mulai memahami pentingnya struktur dan desain dalam pengembangan web. HTML memberi fondasi yang kokoh, sedangkan CSS mempercantik dan menghidupkan tampilan. Dari pengalaman membuat sebuah halaman website sederhana, saya sadar bahwa setiap tag dan style memiliki peran penting untk menciptakan pengalaman pengguna yanag nyaman dan menarik.",
                "gambar" => "1HTML.jpg",
                "sumber" => "https://www.w3schools.com"
            ],
            2 => [
                "judul" => "Mengenal Lebih Jauh Pemrograman Berbasis Objek",
                "tanggal" => "5 Januari 2025",
                "refleksi" => "Saya mulai mengenal konsep OOP seperti class, objek, inheritance, dan encapsulation. Ini membuka wawasan saya tentang bagaimana membangun program yang modular dan mudah dikembangkan. Belajar OOP bukan hanya tentang menulis kode, tapi juga tentang berpikir secara sistematis dan menyelesaikan masalah dengan cara yang lebih cerdas.",
                "gambar" => "2OBJEK.png",
                "sumber" => "https://www.petanikode.com/python-oop/"
            ],
            3 => [
                "judul" => "Menemukan Hiburan Lewat Buku",
                "tanggal" => "2 Mei 2025",
                "refleksi" => "Di sela-sela kesibukan kuliah dan proyek, membaca buku menjadi cara terbaik saya untuk beristirahat sejenak dari dunia nyata. Melalui cerita-cerita fiksi yang sederhana tapi penuh makna, saya bisa larut dalam alur, tertawa, menangis, bahkan merasa lebih dekat dengan diri sendiri. Buku menjadi teman diam yang selalu bisa diandalkan.",
                "gambar" => "3BUKU.jpg",
                "sumber" => "https://www.goodreads.com"
            ]
        ];

        function tampilkanArtikel($artikel, $kutipan) {
            echo "<div class='artikel'>";
            echo "<h2>{$artikel['judul']}</h2>";
            echo "<p><em>{$artikel['tanggal']}</em></p>";
            echo "<p>{$artikel['refleksi']}</p>";
            echo "<img src='{$artikel['gambar']}' alt='Gambar Artikel'>";
            echo "<blockquote>" . $kutipan[array_rand($kutipan)] . "</blockquote>";
            echo "<p class='sumber'>Sumber: <a href='{$artikel['sumber']}' target='_blank'>{$artikel['sumber']}</a></p>";
            echo "</div>";
        }

        if (isset($_GET['id']) && isset($blog[$_GET['id']])) {
            $id = $_GET['id'];
            tampilkanArtikel($blog[$id], $kutipan);
        } else {
            echo "<div class='artikel-list'>";
            foreach ($blog as $id => $data) {
                echo "
                <a class='card' href='hal3.php?id=$id'>
                    <img src='{$data['gambar']}' alt='Thumbnail Artikel'>
                    <div class='card-content'>
                        <h3 class='card-title'>{$data['judul']}</h3>
                        <p class='card-date'>{$data['tanggal']}</p>
                        
                    </div>
                </a>
                ";
            } 
            echo "</div>";
        }
        ?>
</body>
</html>
