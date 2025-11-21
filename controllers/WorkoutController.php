<?php
require_once 'models/WorkoutModel.php';

class WorkoutController {
    private $model;

    public function __construct() {
        $this->model = new WorkoutModel();
    }

    /**
     * index() akan:
     * - Mengambil daftar workout dari model
     * - Mencari input dari request (POST/GET)
     * - Jika ada input, melakukan perhitungan via model
     * - Men-include view: views/workout/index.php
     *
     * View kamu TIDAK diubah — controller hanya menyiapkan variabel:
     * - $workouts (associative array key => [name, met])
     * - $selectedKey (string|null)
     * - $duration (int|null) dalam menit
     * - $weight (float|null) kg
     * - $caloriesResult (float|null) hasil hitung (kkal)
     * - $error (string|null) pesan error sederhana
     */
    public function index() {
        // Ambil daftar workout
        $workouts = $this->model->getAllWorkouts();

        // Inisialisasi variabel view
        $selectedKey = null;
        $duration = null;
        $weight = null;
        $caloriesResult = null;
        $error = null;

        // Terima input baik dari POST maupun GET (karena view form tidak memiliki method)
        $request = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $_REQUEST;

        if (!empty($request)) {
            // sanitize & baca input
            $selectedKey = isset($request['jenisWorkout']) ? trim($request['jenisWorkout']) : (isset($request['jenisworkout']) ? trim($request['jenisworkout']) : null);
            $duration = isset($request['durasi']) ? $request['durasi'] : (isset($request['duration']) ? $request['duration'] : null);
            $weight = isset($request['beratBadan']) ? $request['beratBadan'] : (isset($request['weight']) ? $request['weight'] : null);

            // Minimal validasi
            if (empty($selectedKey)) {
                $error = "Silakan pilih jenis workout.";
            } elseif (!is_numeric($duration) || (float)$duration <= 0) {
                $error = "Durasi harus berupa angka lebih dari 0.";
            } elseif (!is_numeric($weight) || (float)$weight <= 0) {
                $error = "Berat badan harus berupa angka lebih dari 0.";
            } else {
                // lakukan perhitungan
                $caloriesResult = $this->model->calculateCalories($selectedKey, $duration, $weight);
                if ($caloriesResult === null) {
                    $error = "Gagal menghitung kalori. Pastikan jenis workout valid.";
                }
            }
        }

        // sekarang include view — view akan punya akses ke variabel di atas
        // Pastikan path view relatif terhadap root project (sama seperti pola yang dipakai)
        include 'views/workout/index.php';
    }

    public function handleRecommendation() {
    $recommendationResult = null;
    $error = null;
    $request = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $_REQUEST;

    // Data dropdown untuk view (Pilihan statis untuk form)
    $tujuanOptions = ['Kardio/Stamina', 'Kekuatan', 'Fleksibilitas', 'Penurunan Berat Badan'];
    $levelOptions = ['Pemula', 'Menengah', 'Mahir'];

    // Inisialisasi variabel input untuk menyimpan nilai setelah submit
    $targetKalori = null;
    $tujuan = null;
    $level = null;
    $duration = null;
    $weight = null; 

    if (!empty($request) && isset($request['request_recommendation'])) {
        // Ambil dan validasi input
        $targetKalori = (float)($request['targetKalori'] ?? 0);
        $tujuan = trim($request['tujuan'] ?? '');
        $level = trim($request['level'] ?? '');
        $duration = (int)($request['duration'] ?? 0);
        $weight = (float)($request['beratBadan'] ?? 0); // Berat Badan wajib!
        
        // Minimal validasi
        if ($targetKalori <= 0 || $duration <= 0 || $weight <= 0 || empty($tujuan) || empty($level)) {
            $error = "Semua input (Kalori, Durasi, BB, Tujuan, Level) wajib diisi.";
        } else {
            // Panggil LOGIKA MODEL di Tahap 3
            // Kita akan buat method getRecommendation di WorkoutModel
            $recommendationResult = $this->model->getRecommendation($targetKalori, $tujuan, $level, $duration, $weight);
            
            if ($recommendationResult === null) {
                $error = "Maaf, sistem gagal membuat rekomendasi dengan parameter tersebut.";
            }
        }
    }

    // Include view
    require 'views/workout/recommendation.php';
}
}

