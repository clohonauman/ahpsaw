<?php

// Fungsi untuk menghitung probabilitas probabilitas
function calculatePriorProbability($class, $trainingData)
{
    $classCount = 0;
    foreach ($trainingData as $data) {
        if ($data['class'] === $class) {
            $classCount++;
        }
    }
    $totalCount = count($trainingData);
    return $classCount / $totalCount;
}

// Fungsi untuk menghitung probabilitas likelihood
function calculateLikelihood($attribute, $value, $class, $trainingData)
{
    $attributeCount = 0;
    $classCount = 0;
    foreach ($trainingData as $data) {
        if ($data['class'] === $class) {
            $classCount++;
            if ($data[$attribute] === $value) {
                $attributeCount++;
            }
        }
    }
    return $attributeCount / $classCount;
}

// Fungsi untuk melakukan prediksi menggunakan Naive Bayes
function predict($sample, $trainingData)
{
    $classes = array_unique(array_column($trainingData, 'class'));
    $results = array();

    foreach ($classes as $class) {
        $prior = calculatePriorProbability($class, $trainingData);
        $likelihood = 1.0;
        foreach ($sample as $attribute => $value) {
            $likelihood *= calculateLikelihood($attribute, $value, $class, $trainingData);
        }
        $results[$class] = $prior * $likelihood;
    }

    arsort($results);
    return key($results);
}

// Contoh dataset
$trainingData = array(
    array('attribute1' => 'Normal', 'attribute2' => 'Biasa',  'attribute3' => 'Banyak Pilihan',        'attribute4' => 'Tidak Terkenal', 'class' => 'Marah'),
    array('attribute1' => 'Murah',  'attribute2' => 'Bagus',  'attribute3' => 'Sangat Banyak Pilihan', 'attribute4' => 'Terkenal',       'class' => 'Netral'),
    array('attribute1' => 'Mahal',  'attribute2' => 'Jelek',  'attribute3' => 'Kurang Pilihan',        'attribute4' => 'Tidak Terkenal', 'class' => 'Sedih'),
    array('attribute1' => 'Murah',  'attribute2' => 'Biasa',  'attribute3' => 'Kurang Pilihan',        'attribute4' => 'Tidak Terkenal', 'class' => 'Takut'),
    array('attribute1' => 'Murah',  'attribute2' => 'Bagus',  'attribute3' => 'Sangat Banyak Pilihan', 'attribute4' => 'Terkenal',       'class' => 'Senang'),
);

// Contoh data uji
$sampleData = array(
    'attribute1' => 'Normal',
    'attribute2' => 'Biasa',
    'attribute3' => 'Banyak Pilihan',
    'attribute4' => 'Tidak Terkenal',
);

// Prediksi kelas menggunakan Naive Bayes
$predictedClass = predict($sampleData, $trainingData);

// Output hasil prediksi
echo "Predicted Class: " . $predictedClass;
?>