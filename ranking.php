<!DOCTYPE html>
<html>
<head>
    <title>Hasil Perankingan Karyawan</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Hasil Perankingan Karyawan</h1>

    <?php
    // Fungsi untuk menghitung matriks
    function calculateMatrix($criteria, $employees)
    {
        $matrix = array();

        // Mendefinisikan bobot kriteria
        $criteriaWeights = array(
            array(1, 3), // Bobot kriteria 1 terhadap kriteria 2
            array(1/3, 1) // Bobot kriteria 2 terhadap kriteria 1
        );

        // Menghitung nilai matriks
        foreach ($employees as $employee) {
            foreach ($criteria as $cIndex => $cValue) {
                $matrix[$employee][$cValue] = 0;
                foreach ($criteria as $innerIndex => $innerValue) {
                    $matrix[$employee][$cValue] += $criteriaWeights[$cIndex][$innerIndex] * rand(1, 5);
                }
            }
        }

        return $matrix;
    }

    // Fungsi untuk menghitung peringkat menggunakan metode SAW
    function calculateRanking($matrix)
    {
        $ranking = array();

        // Mendefinisikan bobot kriteria
        $criteriaWeights = array(
            'kriteria1' => 0.6,
            'kriteria2' => 0.4
        );

        // Menghitung nilai total kinerja karyawan
        $totalPerformances = array();
        foreach ($matrix as $employee => $criteria) {
            $totalPerformance = 0;
            foreach ($criteria as $cValue => $cWeight) {
                $totalPerformance += $cWeight * $criteriaWeights[$cValue];
            }
            $totalPerformances[$employee] = $totalPerformance;
        }

        // Mengurutkan karyawan berdasarkan nilai total kinerja secara menurun
        arsort($totalPerformances);

        // Menentukan peringkat
        $rank = 1;
        foreach ($totalPerformances as $employee => $totalPerformance) {
            $ranking[$employee] = $rank;
            $rank++;
        }

        return $ranking;
    }

    // Mendapatkan data dari form
    $karyawan1 = $_POST['karyawan1'];
    $karyawan2 = $_POST['karyawan2'];
    $kriteria1 = $_POST['kriteria1'];
    $kriteria2 = $_POST['kriteria2'];

    // Memasukkan data ke dalam array
    $employees = array($karyawan1, $karyawan2);
    $criteria = array($kriteria1, $kriteria2);

    // Menghitung matriks menggunakan metode AHP
    $matrix = calculateMatrix($criteria, $employees);

    // Menghitung peringkat menggunakan metode SAW
    $ranking = calculateRanking($matrix);

    // Menampilkan hasil peringkat
    echo "<h2>Hasil Peringkat:</h2>";
    foreach ($ranking as $key => $value) {
        echo "<p>Peringkat " . ($key + 1) . ": " . $value . "</p>";
    }
    ?>

</body>
</html>
