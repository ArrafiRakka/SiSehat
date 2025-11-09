<?php
class ConsultationModel {
    private $db;

    public function __construct() {
        // dummy connection, nanti bisa diganti dengan koneksi DB asli
        $this->db = null;
    }

    // contoh fungsi dummy biar tidak error
    public function getAllNutritionists() {
        return [
            ['id' => 1, 'name' => 'Dr. Fitri', 'specialty' => 'Gizi Umum'],
            ['id' => 2, 'name' => 'Dr. Yoga', 'specialty' => 'Diet Sehat'],
        ];
    }

    public function getNutritionistById($id) {
        $all = $this->getAllNutritionists();
        foreach ($all as $n) {
            if ($n['id'] == $id) return $n;
        }
        return null;
    }
}
?>
