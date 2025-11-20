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

    // ===================================
    // FUNGSIONALITAS ADMIN (CRUD WORKOUT)
    // ===================================

    // READ ALL WORKOUTS (untuk tampilan list Admin, termasuk yang tidak aktif)
    public function getAllAdminWorkouts() {
        $sql = "SELECT id, key_slug, nama_workout, met_value, is_active FROM workouts ORDER BY id DESC";
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
    public function addWorkout(string $key_slug, string $nama_workout, float $met_value) {
        $stmt = $this->dbconn->prepare("INSERT INTO workouts (key_slug, nama_workout, met_value) VALUES (?, ?, ?)");
        $stmt->bind_param("ssd", $key_slug, $nama_workout, $met_value); // s=string, d=double/float
        return $stmt->execute();
    }

    // UPDATE WORKOUT
    public function updateWorkout(int $id, string $key_slug, string $nama_workout, float $met_value, bool $is_active) {
        // Konversi boolean ke integer (0 atau 1) untuk MySQL
        $active_int = $is_active ? 1 : 0; 
        
        $stmt = $this->dbconn->prepare("UPDATE workouts SET key_slug = ?, nama_workout = ?, met_value = ?, is_active = ? WHERE id = ?");
        $stmt->bind_param("ssdii", $key_slug, $nama_workout, $met_value, $active_int, $id);
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