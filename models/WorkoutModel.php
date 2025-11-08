<?php
class WorkoutModel {
    /**
     * Key => readable name, met value (MET = metabolic equivalent)
     * keys harus sesuai dengan value di <option value="..."> pada view.
     */
    private $workouts = [
        "lari" => ["name" => "Lari", "met" => 9.8],
        "berenang" => ["name" => "Berenang", "met" => 7.0],
        "situp" => ["name" => "Sit-up", "met" => 4.0],
        "angkatBeban" => ["name" => "Angkat Beban", "met" => 6.0],
        "zumba" => ["name" => "Zumba", "met" => 8.8],
        "bersepeda" => ["name" => "Bersepeda", "met" => 8.0],
        "pushup" => ["name" => "Push-up", "met" => 3.8],
        "yoga" => ["name" => "Yoga", "met" => 2.5],
        "aerobik" => ["name" => "Aerobik", "met" => 7.3],
        "jumpingJack" => ["name" => "Jumping Jack", "met" => 9.5],
    ];

    /**
     * Return associative array of available workouts (key => data)
     */
    public function getAllWorkouts() {
        return $this->workouts;
    }

    /**
     * Get MET value by key (e.g. 'lari').
     * Returns float or null jika tidak ada.
     */
    public function getMetByKey(string $key) {
        if (isset($this->workouts[$key])) {
            return (float) $this->workouts[$key]['met'];
        }
        return null;
    }

    /**
     * Calculate burned calories.
     * Rumus: calories = MET * weightKg * durationHours
     *
     * @param string $workoutKey
     * @param float|int $durationMinutes
     * @param float|int $weightKg
     * @return float|null rounded 2 decimals, atau null jika input invalid
     */
    public function calculateCalories(string $workoutKey, $durationMinutes, $weightKg) {
        $met = $this->getMetByKey($workoutKey);

        // Validasi dasar
        if ($met === null) return null;
        $duration = (float) $durationMinutes;
        $weight = (float) $weightKg;
        if ($duration <= 0 || $weight <= 0) return null;

        $durationHours = $duration / 60.0;
        $calories = $met * $weight * $durationHours;

        // Kembalikan hasil sebagai float (2 desimal)
        return round($calories, 2);
    }
}
