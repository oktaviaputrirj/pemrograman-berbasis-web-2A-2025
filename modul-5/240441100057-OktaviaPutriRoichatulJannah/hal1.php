<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Interaktif Mahasiswa</title>
    <style>

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #eaf7ec;
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
            background-color:rgb(53, 133, 58);
            color: white;
            padding: 10px 20px;
            margin: 5px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s;
        }

        nav a:hover {
            background-color:rgb(119, 187, 122);
        }

        .biodata {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }

        .biodata h2 {
            color: #2e7d32;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            margin-bottom: 30px;
            border-spacing: 0;
            background-color: #f6fff7;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border-radius: 15px;
        }

        th {
            background-color: #388e3c;
            color: white;
            font-weight: bold;
            text-align: left;
            padding: 12px 15px;
            border-bottom: 2px solid #4caf50;
        }

        td {
            padding: 12px 15px;
            border: 1px solid #d0e6d2;
            color: #333;
        }

        form div {
            margin-bottom: 20px;
        }

        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            border: 2px solid #c8e6c9;
            border-radius: 8px;
            background: #f9fff9;
        }

        input[type="checkbox"],
        input[type="radio"] {
            margin-right: 15px;
        }

        input[type="submit"] {
            background-color: #388e3c;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s;
        }

        input[type="submit"]:hover {
            background-color:rgb(79, 180, 84);
        }

        .message {
            margin-top: 20px;
            padding: 15px;
            border-radius: 8px;
            background-color: #c8e6c9;
            color: #1b5e20;
        }

        .error {
            background-color: #ffcdd2;
            color: #c62828;
        }
    </style>
</head>
<body>

    <h1>Profil Mahasiswa</h1>

    <nav>
        <a href="hal1.php">🏠 Profil Interaktif</a>
        <a href="hal2.php">Timeline Kuliah</a>
        <a href="hal3.php">Blog Reflektif</a>
    </nav>

    <div class="biodata">
        <h2>Biodata Mahasiswa</h2>
        <table>
            <tr><th>Nama</th><td>Oktavia Putri R J</td></tr>
            <tr><th>NIM</th><td>240441100057</td></tr>
            <tr><th>Tempat, Tanggal Lahir</th><td>Tuban, 11 Oktober 2005</td></tr>
            <tr><th>Email</th><td>oktaviaputrirj@gmail.com</td></tr>
            <tr><th>Nomor HP</th><td>085233058202</td></tr>
        </table>

        <h2>Form Skill & Tools</h2>
        <form method="post">
            <div>
                <label>Bahasa Pemrograman yang Dikuasai:</label><br>
                <input type="text" name="bahasa[]" placeholder="Contoh: PHP"><br><br>
                <input type="text" name="bahasa[]" placeholder="Contoh: Python"><br><br>
                <input type="text" name="bahasa[]" placeholder="Contoh: JavaScript">
            </div>
            <div>
                <label>Pengalaman Proyek Pribadi:</label>
                <textarea name="pengalaman" rows="5" placeholder="Ceritakan proyek pribadimu..."></textarea>
            </div>
            <div>
                <label>Software yang Sering Digunakan:</label><br>
                <input type="checkbox" name="software[]" value="VS Code">VS Code
                <input type="checkbox" name="software[]" value="XAMPP">XAMPP
                <input type="checkbox" name="software[]" value="Git">Git
                <input type="checkbox" name="software[]" value="Figma">Figma
            </div>
            <div>
                <label>Sistem Operasi yang Digunakan:</label><br>
                <input type="radio" name="os" value="Windows">Windows
                <input type="radio" name="os" value="Linux">Linux
                <input type="radio" name="os" value="Mac">Mac
            </div>
            <div>
                <label>Tingkat Penguasaan PHP:</label><br>
                <select name="tingkat">
                    <option value="">--Pilih Tingkat--</option>
                    <option value="Pemula">Pemula</option>
                    <option value="Menengah">Menengah</option>
                    <option value="Mahir">Mahir</option>
                </select>
            </div>
            <input type="submit" name="submit" value="Kirim">
        </form>

        <?php
        function tampilkanData($data) {
            return join(', ', array_filter($data));
        }

        if (!empty($_POST['submit'])) {
            $bahasa = array_filter($_POST['bahasa']);
            $pengalaman = trim($_POST['pengalaman']);
            $software = $_POST['software'] ?? [];
            $os = $_POST['os'] ?? '';
            $tingkat = $_POST['tingkat'];

            if (count($bahasa) < 1 || empty($pengalaman) || empty($software) || empty($os) || empty($tingkat)) {
                echo "<div class='message error'><strong>Semua input wajib diisi!</strong></div>";
            } else {
                echo "<div class='message'>";
                echo "<h3>Hasil Input:</h3>";

                echo "<table border='1' cellpadding='8' cellspacing='0' style='border-collapse: collapse;'>";
                echo "<tr><td>Bahasa Pemrograman</td><td>" . tampilkanData($bahasa) . "</td></tr>";
                echo "<tr><td>Software</td><td>" . tampilkanData($software) . "</td></tr>";
                echo "<tr><td>Sistem Operasi</td><td>" . ($os) . "</td></tr>";
                echo "<tr><td>Tingkat PHP</td><td>" . ($tingkat) . "</td></tr>";
                echo "</table>";
                echo "<p><strong>Pengalaman:</strong> " . ($pengalaman) . "</p>";

                if (count($bahasa) > 2) {
                    echo "<p><strong>✅ Anda cukup berpengalaman dalam pemrograman!</strong></p>";
                }

                echo "</div>";
            }

        }
        ?>
    </div>
</body>
</html>
