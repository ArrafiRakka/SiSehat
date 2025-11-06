<?php
// models/BMI.php

class BMI {

    /**
     * Menghitung BMI dan menentukan kategori.
     *
     * @param float $weight Berat dalam KG
     * @param float $height Tinggi dalam CM
     * @return array Mengandung 'score' (float) dan 'category' (string)
     */
    public function calculateBMI($weight, $height) {
        if ($height <= 0 || $weight <= 0) {
            return [
                'score' => null,
                'category' => 'Input tidak valid.'
            ];
        }

        // Ubah tinggi dari CM ke Meter
        $heightInMeters = $height / 100;

        // Rumus BMI: berat(kg) / (tinggi(m) * tinggi(m))
        $bmi = $weight / ($heightInMeters * $heightInMeters);
        $bmiScore = round($bmi, 1); // Bulatkan 1 angka desimal

        $category = '';

        // Tentukan kategori
        if ($bmiScore < 18.5) {
            $category = "Underweight";
        } elseif ($bmiScore >= 18.5 && $bmiScore <= 24.9) {
            $category = "Normal";
        } elseif ($bmiScore >= 25 && $bmiScore <= 29.9) {
            $category = "Overweight";
        } else { // $bmiScore >= 30
            $category = "Obese";
        }

        return [
            'score' => $bmiScore,
            'category' => $category
        ];
    }
}
?>