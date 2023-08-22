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

// Fungsi untuk mencetak Confusion Matrix dengan format yang lebih baik
function printConfusionMatrix($confusionMatrix)
{
    $numClasses = count($confusionMatrix);

    // Menentukan lebar kolom terpanjang
    $maxWidth = strlen($numClasses - 1);
    for ($i = 0; $i < $numClasses; $i++) {
        for ($j = 0; $j < $numClasses; $j++) {
            $valueWidth = strlen((string) $confusionMatrix[$i][$j]);
            if ($valueWidth > $maxWidth) {
                $maxWidth = $valueWidth;
            }
        }
    }

    // Membuat tampilan Confusion Matrix dengan CSS dan HTML
    echo '<table>';
        echo '<tr>
                <th colspan="4">Confusion Matrix</th>
              </tr>';
    for ($i = 0; $i < $numClasses; $i++) {
        echo '<tr>';
        for ($j = 0; $j < $numClasses; $j++) {
            $value = ($confusionMatrix[$i][$j]);
            echo '<td width="100">' . $value . '</td>';
        }
        echo '</tr>';
    }
    echo '</table>';
}

function calculateAccuracy($confusionMatrix)
{
    $correctPredictions = 0;
    $totalPredictions = 0;

    $numClasses = count($confusionMatrix);

    for ($i = 0; $i < $numClasses; $i++) {
        for ($j = 0; $j < $numClasses; $j++) {
            $totalPredictions += $confusionMatrix[$i][$j];
            if ($i === $j) {
                $correctPredictions += $confusionMatrix[$i][$j];
            }
        }
    }

    return $correctPredictions / $totalPredictions;
}

// Contoh data latih dan data uji
$actualLabels = [0, 1, 2, 3, 4, 2, 0, 1, 2];
$predictedLabels = [0, 1, 2, 3, 4, 2, 0, 1, 3];
$numClasses = 5;

// Menghitung Confusion Matrix
$totalPrecision = 0;
$totalRecall = 0;
$totalF1Score = 0;
$confusionMatrix = calculateConfusionMatrix($actualLabels, $predictedLabels, $numClasses);
for ($classIndex = 0; $classIndex < $numClasses; $classIndex++) {
    $precision = calculatePrecision($confusionMatrix, $classIndex);
    $recall = calculateRecall($confusionMatrix, $classIndex);
    $f1Score = calculateF1Score($confusionMatrix, $classIndex);

    $totalPrecision += $precision;
    $totalRecall += $recall;
    $totalF1Score += $f1Score;
}

$averagePrecision = $totalPrecision / $numClasses;
$averageRecall = $totalRecall / $numClasses;
$averageF1Score = $totalF1Score / $numClasses;
$accuracy = calculateAccuracy($confusionMatrix);

// Menampilkan Confusion Matrix dengan CSS dan HTML
printConfusionMatrix($confusionMatrix);
echo '<br>';

// Menghitung dan menampilkan Precision, Recall, dan F1-Score
echo '<table>';
echo '<tr><th>Precision</th><th>Recall</th><th>F1-Score</th><th>Accuracy</th></tr>';

echo '<tr>';
echo '<td>' . $averagePrecision . '</td>';
echo '<td>' . $averageRecall . '</td>';
echo '<td>' . $averageF1Score . '</td>';
echo '<td>' . $accuracy . '</td>';
echo '</tr>';

echo '</table>';

?>
