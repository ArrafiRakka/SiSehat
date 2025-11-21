<?php
require_once 'models/WorkoutModel.php';

class WorkoutController {
    private $model;

    public function __construct() {
        $this->model = new WorkoutModel();
    }

    public function index() {
        $workouts = $this->model->getAllWorkouts();
        $selectedKey = null;
        $duration = null;
        $weight = null;
        $caloriesResult = null;
        $error = null;

        $request = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $_REQUEST;

        if (!empty($request)) {
            $selectedKey = isset($request['jenisWorkout']) ? trim($request['jenisWorkout']) : (isset($request['jenisworkout']) ? trim($request['jenisworkout']) : null);
            $duration = isset($request['durasi']) ? $request['durasi'] : (isset($request['duration']) ? $request['duration'] : null);
            $weight = isset($request['beratBadan']) ? $request['beratBadan'] : (isset($request['weight']) ? $request['weight'] : null);

            if (empty($selectedKey)) {
                $error = "Silakan pilih jenis workout.";
            } elseif (!is_numeric($duration) || (float)$duration <= 0) {
                $error = "Durasi harus berupa angka lebih dari 0.";
            } elseif (!is_numeric($weight) || (float)$weight <= 0) {
                $error = "Berat badan harus berupa angka lebih dari 0.";
            } else {
                $caloriesResult = $this->model->calculateCalories($selectedKey, $duration, $weight);
                if ($caloriesResult === null) {
                    $error = "Gagal menghitung kalori. Pastikan jenis workout valid.";
                }
            }
        }

         include 'views/workout/index.php';
    }

    public function handleRecommendation() {
    $recommendationResult = null;
    $error = null;
    $request = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $_REQUEST;

    $tujuanOptions = ['Kardio/Stamina', 'Kekuatan', 'Fleksibilitas', 'Penurunan Berat Badan'];
    $levelOptions = ['Pemula', 'Menengah', 'Mahir'];

    $targetKalori = null;
    $tujuan = null;
    $level = null;
    $duration = null;
    $weight = null; 

    if (!empty($request) && isset($request['request_recommendation'])) {
        $targetKalori = (float)($request['targetKalori'] ?? 0);
        $tujuan = trim($request['tujuan'] ?? '');
        $level = trim($request['level'] ?? '');
        $duration = (int)($request['duration'] ?? 0);
        $weight = (float)($request['beratBadan'] ?? 0); 
        
        if ($targetKalori <= 0 || $duration <= 0 || $weight <= 0 || empty($tujuan) || empty($level)) {
            $error = "Semua input (Kalori, Durasi, BB, Tujuan, Level) wajib diisi.";
        } else {
            $recommendationResult = $this->model->getRecommendation($targetKalori, $tujuan, $level, $duration, $weight);
            
            if ($recommendationResult === null) {
                $error = "Maaf, sistem gagal membuat rekomendasi dengan parameter tersebut.";
            }
        }
    }

    require 'views/workout/recommendation.php';
}
}

