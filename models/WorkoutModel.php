<?php
// models/WorkoutModel.php
// Pastikan file Model.php (koneksi) sudah di-require atau autoload di sistemmu
require_once 'Model.php'; 

class WorkoutModel extends Model {

    public function __construct() {
        // Panggil constructor Model dasar untuk membuat koneksi $this->dbconn
        parent::__construct(); 
    }

    // ===================================
    // FUNGSIONALITAS USER (HITUNG KALORI)
    // ===================================

    /**
     * Mengambil semua workout aktif dari database untuk user.
     * Mengembalikan associative array (key_slug => [name, met]).
     */
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

    /**
     * Get MET value by key (e.g. 'lari').
     * Returns float or null jika tidak ada.
     */
    public function getMetByKey(string $key) {
        // Menggunakan prepared statement untuk keamanan (PENTING!)
        $stmt = $this->dbconn->prepare("SELECT met_value FROM workouts WHERE key_slug = ? AND is_active = TRUE LIMIT 1");
        $stmt->bind_param("s", $key);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result && $result->num_rows === 1) {
            return (float) $result->fetch_assoc()['met_value'];
        }
        return null;
    }

    /**
     * Calculate burned calories. (Logika tetap sama)
     */
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

    // models/WorkoutModel.php (di dalam kelas WorkoutModel)

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

    // 1. Ambil SEMUA data workout yang aktif
    $sql = "SELECT key_slug, nama_workout, met_value, fokus_otot, tujuan_utama FROM workouts WHERE is_active = TRUE";
    $result = $this->dbconn->query($sql);
    $allWorkouts = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $row['met_value'] = (float)$row['met_value']; // Pastikan float
            $allWorkouts[] = $row;
        }
    }

    // Jika tidak ada data workout, langsung return null
    if (empty($allWorkouts)) {
        return null;
    }

    // 2. Menentukan Batasan Intensitas (METs) berdasarkan Level
    // Ini membantu menyaring workout yang terlalu berat/ringan.
    $minMet = 0;
    if ($level === 'Pemula') $minMet = 2.0; // Aktivitas ringan
    if ($level === 'Menengah') $minMet = 4.0; // Aktivitas sedang
    if ($level === 'Mahir') $minMet = 7.0; // Aktivitas berat

    // 3. Menghitung Alokasi Waktu
    // Pemanasan (Warm-up) dan Pendinginan (Cool-down)
    $durationWarmup = round($durationTersedia * 0.10); // 10%
    $durationCooldown = round($durationTersedia * 0.10); // 10%
    $durationInti = $durationTersedia - $durationWarmup - $durationCooldown; // 80%

    // Pastikan durasi inti minimal 1 menit
    if ($durationInti <= 0) {
        return null;
    }

    // 4. Filter dan Kategorisasi Workout Sesi Inti
    $filteredWorkouts = [];
    $prioritasFokus = [];
    
    // Tentukan kriteria fokus berdasarkan tujuan
    if (in_array($tujuan, ['Kardio/Stamina', 'Penurunan Berat Badan'])) {
        $prioritasFokus = ['Kardio'];
    } elseif ($tujuan === 'Kekuatan') {
        $prioritasFokus = ['Tubuh Atas', 'Kaki & Glutes', 'Inti (Core)'];
    } elseif ($tujuan === 'Fleksibilitas') {
        $prioritasFokus = ['Fleksibilitas'];
    }

    foreach ($allWorkouts as $w) {
        // Filter: Hanya workout dengan METs yang sesuai level & sesuai tujuan utama
        if ($w['met_value'] >= $minMet && 
            (in_array($w['tujuan_utama'], [$tujuan, 'Full Body']) || 
             in_array($w['fokus_otot'], $prioritasFokus))) {
            $filteredWorkouts[] = $w;
        }
    }

    // Jika tidak ada workout yang cocok
    if (empty($filteredWorkouts)) {
        return null; 
    }

    // Urutkan berdasarkan METs tertinggi (agar efisien kalori)
    usort($filteredWorkouts, function($a, $b) {
        return $b['met_value'] <=> $a['met_value'];
    });

    // 5. Membuat Rencana Sesi Inti
    $sesiInti = [];
    $kaloriTerkumpul = 0;
    $durasiTerpakai = 0;

    // Durasi minimum per item workout di sesi inti
    $minDurationPerItem = 5; 
    $numItems = floor($durationInti / $minDurationPerItem); 
    if ($numItems < 1) $numItems = 1; // Minimal satu item

    $remainingDuration = $durationInti;
    $remainingCalories = $targetKalori;

    // Logika Alokasi Waktu Inti (membagi waktu rata-rata, lalu menyesuaikan durasi)
    $workoutsToUse = array_slice($filteredWorkouts, 0, $numItems);
    if (empty($workoutsToUse)) $workoutsToUse = $filteredWorkouts; // fallback

    // Jika tujuannya Kekuatan, rotasi fokus otot untuk latihan yang seimbang
    if ($tujuan === 'Kekuatan' && count($workoutsToUse) > 1) {
        // Kelompokkan berdasarkan fokus otot dan ambil 1 terbaik dari setiap fokus
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
    
    // Alokasikan waktu inti secara merata ke item yang terpilih
    $durationPerSelectedItem = floor($remainingDuration / count($workoutsToUse));
    if ($durationPerSelectedItem < $minDurationPerItem && count($workoutsToUse) > 1) {
         // Jika waktu per item terlalu kecil, kurangi jumlah item
         $workoutsToUse = array_slice($workoutsToUse, 0, floor($remainingDuration / $minDurationPerItem));
         $durationPerSelectedItem = floor($remainingDuration / count($workoutsToUse));
    }
    $remainingDuration = $durationInti; // Reset durasi inti
    $durasiItem = $durationPerSelectedItem;
    
    if ($durasiItem > 0) {
        foreach ($workoutsToUse as $w) {
            $durasi = min($durasiItem, $remainingDuration);
            if ($durasi <= 0) break;
            
            // Hitung kalori untuk durasi ini
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


    // 6. Menyusun Rencana Final (Pemanasan, Inti, Pendinginan)
    
    // Definisikan Warm-up dan Cool-down
    $warmupWorkout = [
        'fase' => 'Pemanasan',
        'nama' => 'Peregangan Dinamis & Jogging Ringan',
        'durasi' => $durationWarmup,
        'kalori' => $this->calculateCalories('yoga', $durationWarmup, $weight) * 0.5, // Estimasi 50% dari MET Yoga
    ];

    $cooldownWorkout = [
        'fase' => 'Pendinginan',
        'nama' => 'Peregangan Statis & Relaksasi',
        'durasi' => $durationCooldown,
        'kalori' => $this->calculateCalories('yoga', $durationCooldown, $weight) * 0.3, // Estimasi 30% dari MET Yoga
    ];

    // Gabungkan semua menjadi rencana sesi final
    $finalPlan = [];
    if ($durationWarmup > 0) $finalPlan[] = $warmupWorkout;
    $finalPlan = array_merge($finalPlan, $sesiInti);
    if ($durationCooldown > 0) $finalPlan[] = $cooldownWorkout;

    // Hitung total akhir
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

    // READ ALL WORKOUTS (untuk tampilan list Admin, termasuk yang tidak aktif)
    // models/WorkoutModel.php
// ...
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

    // READ SINGLE WORKOUT by ID (untuk Edit)
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
        // Konversi boolean ke integer (0 atau 1) untuk MySQL
        $active_int = $is_active ? 1 : 0; 
        
        $stmt = $this->dbconn->prepare("UPDATE workouts SET key_slug = ?, nama_workout = ?, met_value = ?, fokus_otot = ?, tujuan_utama = ?, is_active = ? WHERE id = ?");
        $stmt->bind_param("ssdssii", $key_slug, $nama_workout, $met_value, $fokus_otot, $tujuan_utama, $active_int, $id);
        return $stmt->execute();
    }

    // DELETE WORKOUT (Soft Delete)
    public function deleteWorkout(int $id) {
        // Kita hanya set is_active menjadi FALSE (Soft Delete)
        $stmt = $this->dbconn->prepare("UPDATE workouts SET is_active = 0 WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}