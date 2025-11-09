<?php
class Kalori {
    
    private $dummyFoods = [];

    public function __construct() {
        // DATA DUMMY BARU DENGAN 'base_grams' (WAJIB)
        $this->dummyFoods = [
            [
                'id' => 1, 'name' => 'Ayam Goreng', 'description' => 'Sepotong paha', 
                'category' => 'lunch', 'calories' => 290, 'protein' => 25, 'carbs' => 10, 'fats' => 18, 
                'image' => '/SiSehat/public/images/dummy/ayam-goreng.jpg', 'is_active' => 1,
                'base_grams' => 150 // Info berat dasar
            ],
            [
                'id' => 2, 'name' => 'Nasi Putih', 'description' => 'Satu porsi', 
                'category' => 'lunch', 'calories' => 130, 'protein' => 2.7, 'carbs' => 28, 'fats' => 0.3, 
                'image' => '/SiSehat/public/images/dummy/nasi.jpg', 'is_active' => 1,
                'base_grams' => 100 // Info berat dasar
            ],
            [
                'id' => 3, 'name' => 'Telur Rebus', 'description' => 'Satu butir', 
                'category' => 'breakfast', 'calories' => 78, 'protein' => 6, 'carbs' => 0.6, 'fats' => 5, 
                'image' => '/SiSehat/public/images/dummy/telur.jpg', 'is_active' => 1,
                'base_grams' => 50 // Info berat dasar
            ],
            [
                'id' => 4, 'name' => 'Apel', 'description' => 'Satu buah sedang', 
                'category' => 'snack', 'calories' => 95, 'protein' => 0.5, 'carbs' => 25, 'fats' => 0.3, 
                'image' => '/SiSehat/public/images/dummy/apel.jpg', 'is_active' => 1,
                'base_grams' => 180 // Info berat dasar
            ],
            [
                'id' => 5, 'name' => 'Susu Coklat', 'description' => 'Satu gelas', 
                'category' => 'beverage', 'calories' => 208, 'protein' => 8, 'carbs' => 26, 'fats' => 8, 
                'image' => '/SiSehat/public/images/dummy/susu-coklat.jpg', 'is_active' => 1,
                'base_grams' => 250 // Info berat dasar
            ],
            [
                'id' => 6, 'name' => 'Roti Gandum', 'description' => 'Dua lembar', 
                'category' => 'breakfast', 'calories' => 160, 'protein' => 8, 'carbs' => 30, 'fats' => 2, 
                'image' => '/SiSehat/public/images/dummy/roti.jpg', 'is_active' => 1,
                'base_grams' => 60 // Info berat dasar
            ]
        ];
    }

    // --- FUNGSI-FUNGSI DI BAWAH INI SAMA, TAPI DISESUAIKAN ---

    public function getUserById($userId) {
        return [
            'id' => $userId, 'username' => 'dev_user',
            'target_calories' => 2200, 'target_protein' => 150,
            'target_carbs' => 250, 'target_fats' => 70
        ];
    }

    public function getAllFoods() {
        return $this->dummyFoods;
    }

    public function getFoodsFiltered($keyword = '', $category = 'all') {
        $foods = $this->dummyFoods;
        if ($category !== 'all') {
            $foods = array_filter($foods, fn($food) => $food['category'] === $category);
        }
        if (!empty($keyword)) {
            $foods = array_filter($foods, function($food) use ($keyword) {
                $keyword = strtolower($keyword);
                // str_contains() adalah fungsi PHP 8+
                return str_contains(strtolower($food['name']), $keyword) || 
                       str_contains(strtolower($food['description']), $keyword);
            });
        }
        return array_values($foods);
    }

    public function addIntake($userId, $foodId, $mealType, $portionMultiplier, $notes) {
        // JS akan mengirim 'portionMultiplier' yang sudah dihitung dari gram, jadi ini aman.
        return true; 
    }

    public function getTodayIntake($userId, $date) {
        // Kita tambahkan base_grams di sini agar JS bisa hitung total
        return [
            [
                'id' => 101, 'user_id' => $userId, 'food_id' => 3, 'intake_date' => $date,
                'meal_type' => 'breakfast', 'portion_multiplier' => 2, 'notes' => 'Makan 2 butir',
                'name' => 'Telur Rebus', 'calories' => 78, 'protein' => 6, 'carbs' => 0.6, 'fats' => 5,
                'image' => '/SiSehat/public/images/dummy/telur.jpg', 'base_grams' => 50
            ],
            [
                'id' => 102, 'user_id' => $userId, 'food_id' => 1, 'intake_date' => $date,
                'meal_type' => 'lunch', 'portion_multiplier' => 1, 'notes' => '1 potong',
                'name' => 'Ayam Goreng', 'calories' => 290, 'protein' => 25, 'carbs' => 10, 'fats' => 18,
                'image' => '/SiSehat/public/images/dummy/ayam-goreng.jpg', 'base_grams' => 150
            ]
        ];
    }

    public function deleteIntake($id, $userId) {
        return true;
    }
}
?>