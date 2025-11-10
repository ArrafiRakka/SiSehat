<?php
// controllers/BMIController.php
require_once 'models/BMI.php';

class BMIController {

    public function handleBMI() {
        // Variabel untuk menampung hasil
        $bmi_score = null;
        $bmi_category = null;

        // Cek jika form disubmit (method POST)
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // 1. Ambil data dari form
            $weight = $_POST['weight'] ?? 0;
            $height = $_POST['height'] ?? 0;

            // 2. Panggil Model untuk menghitung
            $bmiModel = new BMI();
            $result = $bmiModel->calculateBMI((float)$weight, (float)$height);

            // 3. Simpan hasil ke variabel
            $bmi_score = $result['score'];
            $bmi_category = $result['category'];
        }

        // 4. Tampilkan View (layout + konten)
        // Variabel $bmi_score & $bmi_category akan bisa diakses di dalam view
        
        $pageTitle = "BMI Calculator"; // Set judul halaman
        $pageCSS = "bmi.css";
        
        require 'views/layouts/Header.php';
        require 'views/BMI/BMI.php';
        require 'views/layouts/Footer.php';
    }
}
?>