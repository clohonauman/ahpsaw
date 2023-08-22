<?php
// Fungsi untuk menghitung Confusion Matrix
function calculateConfusionMatrix($actualLabels, $predictedLabels, $numClasses)
{
    $confusionMatrix = array();

    // Inisialisasi Confusion Matrix dengan nilai awal 0
    for ($i = 0; $i < $numClasses; $i++) {
        $confusionMatrix[$i] = array_fill(0, $numClasses, 0);
    }

    // Menghitung Confusion Matrix
    $totalInstances = count($actualLabels);
    for ($i = 0; $i < $totalInstances; $i++) {
        $actualClass = $actualLabels[$i];
        $predictedClass = $predictedLabels[$i];

        $confusionMatrix[$actualClass][$predictedClass]++;
    }

    return $confusionMatrix;
}

// Fungsi untuk menghitung Precision
function calculatePrecision($confusionMatrix, $classIndex)
{
    $truePositives = $confusionMatrix[$classIndex][$classIndex];
    $falsePositives = 0;

    for ($i = 0; $i < count($confusionMatrix); $i++) {
        if ($i !== $classIndex) {
            $falsePositives += $confusionMatrix[$i][$classIndex];
        }
    }

    return $truePositives / ($truePositives + $falsePositives);
}

// Fungsi untuk menghitung Recall
function calculateRecall($confusionMatrix, $classIndex)
{
    $truePositives = $confusionMatrix[$classIndex][$classIndex];
    $falseNegatives = 0;

    for ($i = 0; $i < count($confusionMatrix); $i++) {
        if ($i !== $classIndex) {
            $falseNegatives += $confusionMatrix[$classIndex][$i];
        }
    }

    return $truePositives / ($truePositives + $falseNegatives);
}

// Fungsi untuk menghitung F1-Score
function calculateF1Score($confusionMatrix, $classIndex)
{
    $precision = calculatePrecision($confusionMatrix, $classIndex);
    $recall = calculateRecall($confusionMatrix, $classIndex);

    return (2 * $precision * $recall) / ($precision + $recall);
}

// Fungsi untuk membagi data set menjadi data train dan data test secara acak
function splitDataRandom($data, $trainRatio)
{
    $trainSize = (int)(count($data) * $trainRatio);
    $trainData = array();
    $testData = $data;

    for ($i = 0; $i < $trainSize; $i++) {
        $randomIndex = array_rand($testData);
        $trainData[] = $testData[$randomIndex];
        unset($testData[$randomIndex]);
    }

    $trainData = array_values($trainData);
    $testData = array_values($testData);

    return array($trainData, $testData);
}

// Fungsi untuk melakukan pengujian
function performTesting($actualLabels, $predictedLabels, $numClasses)
{
    // Menghitung Confusion Matrix
    $confusionMatrix = calculateConfusionMatrix($actualLabels, $predictedLabels, $numClasses);

    // Menghitung dan menampilkan Confusion Matrix
    echo "Confusion Matrix:\n";
    for ($i = 0; $i < $numClasses; $i++) {
        for ($j = 0; $j < $numClasses; $j++) {
            echo $confusionMatrix[$i][$j] . " ";
        }
        echo "\n";
    }
    echo "\n";

    // Menghitung dan menampilkan akurasi, precision, recall, dan f1-score
    echo "Metrics:\n";
    $totalPrecision = 0;
    $totalRecall = 0;
    $totalF1Score = 0;

    for ($classIndex = 0; $classIndex < $numClasses; $classIndex++) {
        $precision = calculatePrecision($confusionMatrix, $classIndex);
        $recall = calculateRecall($confusionMatrix, $classIndex);
        $f1Score = calculateF1Score($confusionMatrix, $classIndex);

        $totalPrecision += $precision;
        $totalRecall += $recall;
        $totalF1Score += $f1Score;

        echo "Class " . $classIndex . ":\n";
        echo "Precision: " . $precision . "\n";
        echo "Recall: " . $recall . "\n";
        echo "F1-Score: " . $f1Score . "\n\n";
    }

    $averagePrecision = $totalPrecision / $numClasses;
    $averageRecall = $totalRecall / $numClasses;
    $averageF1Score = $totalF1Score / $numClasses;

    echo "Average Precision: " . $averagePrecision . "\n";
    echo "Average Recall: " . $averageRecall . "\n";
    echo "Average F1-Score: " . $averageF1Score . "\n";
}

// Contoh data latih dan data uji
$actualLabels = [0, 1, 2, 3, 4, 2, 0, 1, 2];
$predictedLabels = [0, 1, 2, 3, 4, 2, 0, 4, 3];
$numClasses = 5;

// Memecah data set menjadi data train dan data test secara acak dengan rasio 60:40
list($trainData, $testData) = splitDataRandom($actualLabels, 0.6);

// Melakukan pengujian menggunakan data train dan data test
performTesting($testData, $predictedLabels, $numClasses);

echo "\n";

// Memecah data set menjadi data train dan data test secara acak dengan rasio 70:30
list($trainData, $testData) = splitDataRandom($actualLabels, 0.7);

// Melakukan pengujian menggunakan data train dan data test
performTesting($testData, $predictedLabels, $numClasses);

echo "\n";

// Memecah data set menjadi data train dan data test secara acak dengan rasio 80:20
list($trainData, $testData) = splitDataRandom($actualLabels, 0.8);

// Melakukan pengujian menggunakan data train dan data test
performTesting($testData, $predictedLabels, $numClasses);
?>