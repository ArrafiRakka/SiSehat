<?php
class ConsultationModel {
    public function __construct() {
        // Tidak ada koneksi ke database
    }

    // Dummy data ahli gizi
    public function getAllNutritionists() {
        return [
            [
                'id' => 1,
                'name' => 'Dr. Fitri Ananda, S.Gz',
                'gender' => 'Wanita',
                'city' => 'Jakarta',
                'exp' => '5 tahun',
                'price' => 30000,
                'img' => 'https://via.placeholder.com/120x120.png?text=Fitri'
            ],
            [
                'id' => 2,
                'name' => 'Dr. Yoga Pratama, S.Gz',
                'gender' => 'Pria',
                'city' => 'Bandung',
                'exp' => '3 tahun',
                'price' => 25000,
                'img' => 'https://via.placeholder.com/120x120.png?text=Yoga'
            ],
            [
                'id' => 3,
                'name' => 'Dr. Lala Widya, S.Gz',
                'gender' => 'Wanita',
                'city' => 'Surabaya',
                'exp' => '7 tahun',
                'price' => 50000,
                'img' => 'https://via.placeholder.com/120x120.png?text=Lala'
            ]
        ];
    }

    // Dummy: ambil satu ahli gizi
    public function getNutritionistById($id) {
        foreach ($this->getAllNutritionists() as $n) {
            if ($n['id'] == $id) {
                return $n;
            }
        }
        return null;
    }

    // Dummy hasil konsultasi
    public function getConsultationResult($userId) {
        return [
            'nutritionist' => 'Dr. Fitri Ananda, S.Gz',
            'result' => 'Rekomendasi pola makan tinggi protein dan rendah lemak.',
            'date' => '2025-11-09'
        ];
    }
}
?>
