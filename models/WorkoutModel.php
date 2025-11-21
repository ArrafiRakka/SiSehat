<?php

require_once 'Model.php'; 

class WorkoutModel extends Model {

    public function __construct() {
        parent::__construct(); 
    }

    public function getAllWorkouts() {
        $sql = "SELECT key_slug, nama_workout, met_value FROM workouts WHERE is_active = TRUE ORDER BY nama_workout ASC";
        $result = $this->dbconn->query($sql);
        
        $workouts = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $workouts[$row['key_slug']] = [
                    'name' => $row['nama_workout'],
                    'met' => (float) $row['met_value'],
                ];
            }
        }
        return $workouts;
    }


    public function getMetByKey(string $key) {
        $stmt = $this->dbconn->prepare("SELECT met_value FROM workouts WHERE key_slug = ? AND is_active = TRUE LIMIT 1");
        $stmt->bind_param("s", $key);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result && $result->num_rows === 1) {
            return (float) $result->fetch_assoc()['met_value'];
        }
        return null;
    }

    public function calculateCalories(string $workoutKey, $durationMinutes, $weightKg) {
        $met = $this->getMetByKey($workoutKey);

        if ($met === null) return null;
        $duration = (float) $durationMinutes;
        $weight = (float) $weightKg;
        if ($duration <= 0 || $weight <= 0) return null;

        $durationHours = $duration / 60.0;
        $calories = $met * $weight * $durationHours;

        return round($calories, 2);
    }

/**
 * Mendapatkan rekomendasi rencana workout berdasarkan input pengguna.
 * @param float $targetKalori
 * @param string $tujuan (Kardio/Stamina, Kekuatan, Fleksibilitas, Penurunan Berat Badan)
 * @param string $level (Pemula, Menengah, Mahir)
 * @param int $durationTersedia (menit)
 * @param float $weight (kg)
 * @return array|null Rencana sesi atau null jika gagal.
 */
public function getRecommendation(float $targetKalori, string $tujuan, string $level, int $durationTersedia, float $weight) {
    $sql = "SELECT key_slug, nama_workout, met_value, fokus_otot, tujuan_utama FROM workouts WHERE is_active = TRUE";
    $result = $this->dbconn->query($sql);
    $allWorkouts = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $row['met_value'] = (float)$row['met_value']; 
            $allWorkouts[] = $row;
        }
    }

    if (empty($allWorkouts)) {
        return null;
    }

    $minMet = 0;
    if ($level === 'Pemula') $minMet = 2.0; 
    if ($level === 'Menengah') $minMet = 4.0; 
    if ($level === 'Mahir') $minMet = 7.0; 

    $durationWarmup = round($durationTersedia * 0.10); 
    $durationCooldown = round($durationTersedia * 0.10); 
    $durationInti = $durationTersedia - $durationWarmup - $durationCooldown;

    if ($durationInti <= 0) {
        return null;
    }

    $filteredWorkouts = [];
    $prioritasFokus = [];
    
    if (in_array($tujuan, ['Kardio/Stamina', 'Penurunan Berat Badan'])) {
        $prioritasFokus = ['Kardio'];
    } elseif ($tujuan === 'Kekuatan') {
        $prioritasFokus = ['Tubuh Atas', 'Kaki & Glutes', 'Inti (Core)'];
    } elseif ($tujuan === 'Fleksibilitas') {
        $prioritasFokus = ['Fleksibilitas'];
    }

    foreach ($allWorkouts as $w) {
        if ($w['met_value'] >= $minMet && 
            (in_array($w['tujuan_utama'], [$tujuan, 'Full Body']) || 
             in_array($w['fokus_otot'], $prioritasFokus))) {
            $filteredWorkouts[] = $w;
        }
    }

    if (empty($filteredWorkouts)) {
        return null; 
    }

    usort($filteredWorkouts, function($a, $b) {
        return $b['met_value'] <=> $a['met_value'];
    });

    $sesiInti = [];
    $kaloriTerkumpul = 0;
    $durasiTerpakai = 0;

    $minDurationPerItem = 5; 
    $numItems = floor($durationInti / $minDurationPerItem); 
    if ($numItems < 1) $numItems = 1; 

    $remainingDuration = $durationInti;
    $remainingCalories = $targetKalori;

    $workoutsToUse = array_slice($filteredWorkouts, 0, $numItems);
    if (empty($workoutsToUse)) $workoutsToUse = $filteredWorkouts; 

    if ($tujuan === 'Kekuatan' && count($workoutsToUse) > 1) {
        $strengthWorkouts = [];
        foreach ($workoutsToUse as $w) {
            if (!isset($strengthWorkouts[$w['fokus_otot']])) {
                $strengthWorkouts[$w['fokus_otot']] = $w;
            }
        }
        $workoutsToUse = array_values($strengthWorkouts);
        if (count($workoutsToUse) > $numItems) {
            $workoutsToUse = array_slice($workoutsToUse, 0, $numItems);
        }
    }
    
    $durationPerSelectedItem = floor($remainingDuration / count($workoutsToUse));
    if ($durationPerSelectedItem < $minDurationPerItem && count($workoutsToUse) > 1) {
         $workoutsToUse = array_slice($workoutsToUse, 0, floor($remainingDuration / $minDurationPerItem));
         $durationPerSelectedItem = floor($remainingDuration / count($workoutsToUse));
    }
    $remainingDuration = $durationInti; 
    $durasiItem = $durationPerSelectedItem;
    
    if ($durasiItem > 0) {
        foreach ($workoutsToUse as $w) {
            $durasi = min($durasiItem, $remainingDuration);
            if ($durasi <= 0) break;
            
            $caloriesBurned = $this->calculateCalories($w['key_slug'], $durasi, $weight);
            
            $sesiInti[] = [
                'fase' => 'Sesi Inti',
                'nama' => $w['nama_workout'],
                'durasi' => $durasi,
                'kalori' => $caloriesBurned,
                'fokus' => $w['fokus_otot'],
            ];
            
            $kaloriTerkumpul += $caloriesBurned;
            $durasiTerpakai += $durasi;
            $remainingDuration -= $durasi;
        }
    }

    $warmupWorkout = [
        'fase' => 'Pemanasan',
        'nama' => 'Peregangan Dinamis & Jogging Ringan',
        'durasi' => $durationWarmup,
        'kalori' => $this->calculateCalories('yoga', $durationWarmup, $weight) * 0.5, 
    ];

    $cooldownWorkout = [
        'fase' => 'Pendinginan',
        'nama' => 'Peregangan Statis & Relaksasi',
        'durasi' => $durationCooldown,
        'kalori' => $this->calculateCalories('yoga', $durationCooldown, $weight) * 0.3, 
    ];

    $finalPlan = [];
    if ($durationWarmup > 0) $finalPlan[] = $warmupWorkout;
    $finalPlan = array_merge($finalPlan, $sesiInti);
    if ($durationCooldown > 0) $finalPlan[] = $cooldownWorkout;

    $totalDurasi = $durationWarmup + $durasiTerpakai + $durationCooldown;
    $totalKalori = $kaloriTerkumpul + $warmupWorkout['kalori'] + $cooldownWorkout['kalori'];
    
    return [
        'total_kalori' => $totalKalori,
        'total_durasi' => $totalDurasi,
        'target_kalori_user' => $targetKalori,
        'sesi' => $finalPlan,
    ];
}

    // ===================================
    // FUNGSIONALITAS ADMIN (CRUD WORKOUT)
    // ===================================
        public function getAllAdminWorkouts() {
            $sql = "SELECT id, key_slug, nama_workout, met_value, fokus_otot, tujuan_utama, is_active FROM workouts ORDER BY id DESC"; // Kolom baru ditambahkan
            $result = $this->dbconn->query($sql);
            
            $workouts = [];
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $workouts[] = $row;
                }
            }
            return $workouts;
        }

    public function getWorkoutById(int $id) {
        $stmt = $this->dbconn->prepare("SELECT id, key_slug, nama_workout, met_value, is_active FROM workouts WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // CREATE / ADD WORKOUT
    public function addWorkout(string $key_slug, string $nama_workout, float $met_value, string $fokus_otot, string $tujuan_utama) {
        $stmt = $this->dbconn->prepare("INSERT INTO workouts (key_slug, nama_workout, met_value, fokus_otot, tujuan_utama) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdss", $key_slug, $nama_workout, $met_value, $fokus_otot, $tujuan_utama); // s=string, d=double/float
        return $stmt->execute([$key_slug, $nama_workout, $met_value, $fokus_otot, $tujuan_utama]);
    }

    // UPDATE WORKOUT
    public function updateWorkout(int $id, string $key_slug, string $nama_workout, float $met_value, string $fokus_otot, string $tujuan_utama, bool $is_active) {
        $active_int = $is_active ? 1 : 0; 
        
        $stmt = $this->dbconn->prepare("UPDATE workouts SET key_slug = ?, nama_workout = ?, met_value = ?, fokus_otot = ?, tujuan_utama = ?, is_active = ? WHERE id = ?");
        $stmt->bind_param("ssdssii", $key_slug, $nama_workout, $met_value, $fokus_otot, $tujuan_utama, $active_int, $id);
        return $stmt->execute();
    }

    // DELETE WORKOUT (Soft Delete)
    public function deleteWorkout(int $id) {
        $stmt = $this->dbconn->prepare("UPDATE workouts SET is_active = 0 WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}