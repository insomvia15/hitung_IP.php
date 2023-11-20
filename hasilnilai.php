<?php
// Mulai sesi
session_start();

// Inisialisasi variabel $nama dan $nim
$nama = isset($_SESSION['nama']) ? $_SESSION['nama'] : "";
$nim = isset($_SESSION['nim']) ? $_SESSION['nim'] : "";

// Proses formulir registrasi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = isset($_POST["nama"]) ? $_POST["nama"] : "";
    $nim = isset($_POST["nim"]) ? $_POST["nim"] : "";

    // Menyimpan data dalam sesi
    $_SESSION['nama'] = $nama;
    $_SESSION['nim'] = $nim;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hasil Nilai</title>
    <style>
        table {
            border-collapse: collapse;
            width: 50%;
            margin-top: 20px;
        }

        table, th, td {
            border: none;
            padding: 10px;
            text-align: left;
        }

        th, td {
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <h2>Selamat datang, <?php echo $nama; ?> (NIM: <?php echo $nim; ?>)!</h2>

    <table>
        <tr>
            <th>Nama:</th>
            <td><?php echo $nama; ?></td>
        </tr>
        <tr>
            <th>NIM:</th>
            <td><?php echo $nim; ?></td>
        </tr>
    </table>

    <h3>Formulir Hasil Nilai</h3>
    <form action="" method="post">
        <!-- Input tersembunyi untuk menyimpan nama dan nim -->
        <input type="hidden" name="nama" value="<?php echo $nama; ?>">
        <input type="hidden" name="nim" value="<?php echo $nim; ?>">

        <table>
            <tr>
                <th>Nama Mata Kuliah</th>
                <th>SKS</th>
                <th>Nilai</th>
            </tr>
            <?php
            for ($i = 1; $i <= 3; $i++) {
                echo "<tr>";
                echo "<td><select name='mata_kuliah[]' required>
                        <option value='matkul$i'>Mata Kuliah $i</option>
                        <!-- Tambahkan mata kuliah lain yang dibutuhin -->
                    </select></td>";
                echo "<td><input type='number' name='sks[]' required></td>";
                echo "<td>
                        <input type='radio' name='nilai$i' value='A' required> A
                        <input type='radio' name='nilai$i' value='B' required> B
                        <input type='radio' name='nilai$i' value='C' required> C
                        <input type='radio' name='nilai$i' value='D' required> D
                        <input type='radio' name='nilai$i' value='E' required> E
                    </td>";
                echo "</tr>";
            }
            ?>
        </table>
        <br>
        <input type="submit" name="hitung" value="Hitung">
        <input type="reset" value="Reset">
    </form>

    <?php
    // Inisialisasi variabel $bobot_nilai
    $bobot_nilai = ['A' => 4, 'B' => 3, 'C' => 2, 'D' => 1, 'E' => 0];

    // Proses perhitungan hasil
    if (isset($_POST["hitung"])) {
        $total_sks = 0;
        $total_nilai = 0;

        for ($i = 1; $i <= 3; $i++) {
            $mata_kuliah = $_POST["mata_kuliah"][$i - 1];
            $sks = $_POST["sks"][$i - 1];
            $nilai = isset($_POST["nilai$i"]) ? $_POST["nilai$i"] : '';

            $total_sks += $sks;
            $total_nilai += ($sks * $bobot_nilai[$nilai]);
        }

        $hasil = $total_nilai / $total_sks;
        echo "<h3>Hasil Perhitungan: $hasil</h3>";
    }

    // Selesai sesi
    session_write_close();
    ?>
</body>
</html>
