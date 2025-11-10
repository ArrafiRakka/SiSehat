<?php
class Kalori {
    
    private $dummyFoods = [];
    private $sessionKey = 'sisehat_intake_data';

    public function __construct() {
        $this->dummyFoods = [
            [
                'id' => 1, 'name' => 'Ayam Goreng', 'description' => 'Sepotong paha', 
                'category' => 'lunch', 'calories' => 290, 'protein' => 25, 'carbs' => 10, 'fats' => 18, 
                'image' => '/SiSehat/public/images/dummy/ayam-goreng.jpg', 'is_active' => 1,
                'base_grams' => 150
            ],
            [
                'id' => 2, 'name' => 'Nasi Putih', 'description' => 'Satu porsi', 
                'category' => 'lunch', 'calories' => 130, 'protein' => 2.7, 'carbs' => 28, 'fats' => 0.3, 
                'image' => '/SiSehat/public/images/dummy/nasi.jpg', 'is_active' => 1,
                'base_grams' => 100
            ],
            [
                'id' => 3, 'name' => 'Telur Rebus', 'description' => 'Satu butir', 
                'category' => 'breakfast', 'calories' => 78, 'protein' => 6, 'carbs' => 0.6, 'fats' => 5, 
                'image' => '/SiSehat/public/images/dummy/telur.jpg', 'is_active' => 1,
                'base_grams' => 50
            ],
            [
                'id' => 4, 'name' => 'Apel', 'description' => 'Satu buah sedang', 
                'category' => 'snack', 'calories' => 95, 'protein' => 0.5, 'carbs' => 25, 'fats' => 0.3, 
                'image' => '/SiSehat/public/images/dummy/apel.jpg', 'is_active' => 1,
                'base_grams' => 180
            ],
            [
                'id' => 5, 'name' => 'Susu Coklat', 'description' => 'Satu gelas', 
                'category' => 'beverage', 'calories' => 208, 'protein' => 8, 'carbs' => 26, 'fats' => 8, 
                'image' => '/SiSehat/public/images/dummy/susu-coklat.jpg', 'is_active' => 1,
                'base_grams' => 250
            ],
            [
                'id' => 6, 'name' => 'Roti Gandum', 'description' => 'Dua lembar', 
                'category' => 'breakfast', 'calories' => 160, 'protein' => 8, 'carbs' => 30, 'fats' => 2, 
                'image' => '/SiSehat/public/images/dummy/roti.jpg', 'is_active' => 1,
                'base_grams' => 60
            ]
        ];

        if (!isset($_SESSION[$this->sessionKey])) {
            $_SESSION[$this->sessionKey] = [
                101 => [
                    'id' => 101, 'user_id' => $_SESSION['user_id'] ?? 1, 'food_id' => 3, 'intake_date' => date('Y-m-d'),
                    'meal_type' => 'breakfast', 'portion_multiplier' => 2, 'notes' => 'Makan 2 butir',
                    'name' => 'Telur Rebus', 'calories' => 78, 'protein' => 6, 'carbs' => 0.6, 'fats' => 5,
                    'image' => '/SiSehat/public/images/dummy/telur.jpg', 'base_grams' => 50
                ],
                102 => [
                    'id' => 102, 'user_id' => $_SESSION['user_id'] ?? 1, 'food_id' => 1, 'intake_date' => date('Y-m-d'),
                    'meal_type' => 'lunch', 'portion_multiplier' => 1, 'notes' => '1 potong',
                    'name' => 'Ayam Goreng', 'calories' => 290, 'protein' => 25, 'carbs' => 10, 'fats' => 18,
                    'image' => '/SiSehat/public/images/dummy/ayam-goreng.jpg', 'base_grams' => 150
                ]
            ];
        }
    }

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

    public function getFoodById($id) {
        foreach ($this->dummyFoods as $food) {
            if ($food['id'] == $id) {
                return $food;
            }
        }
        return null;
    }

    public function getFoodsFiltered($keyword = '', $category = 'all') {
        $foods = $this->dummyFoods;
        if ($category !== 'all') {
            $foods = array_filter($foods, fn($food) => $food['category'] === $category);
        }
        if (!empty($keyword)) {
            $foods = array_filter($foods, function($food) use ($keyword) {
                $keyword = strtolower($keyword);
                return str_contains(strtolower($food['name']), $keyword) || 
                       str_contains(strtolower($food['description']), $keyword);
            });
        }
        return array_values($foods);
    }

    public function getIntakeById($intakeId, $userId) {
        if (isset($_SESSION[$this->sessionKey][$intakeId]) && $_SESSION[$this->sessionKey][$intakeId]['user_id'] == $userId) {
            return $_SESSION[$this->sessionKey][$intakeId];
        }
        return null;
    }

    public function updateIntake($intakeId, $userId, $portionMultiplier, $mealType, $notes) {
        if (isset($_SESSION[$this->sessionKey][$intakeId]) && $_SESSION[$this->sessionKey][$intakeId]['user_id'] == $userId) {
            $_SESSION[$this->sessionKey][$intakeId]['portion_multiplier'] = $portionMultiplier;
            $_SESSION[$this->sessionKey][$intakeId]['meal_type'] = $mealType;
            $_SESSION[$this->sessionKey][$intakeId]['notes'] = $notes;
            return true;
        }
        return false;
    }

    public function addIntake($userId, $foodId, $mealType, $portionMultiplier, $notes) {
        $food = $this->getFoodById($foodId);
        if (!$food) return false;

        $newId = time() . rand(100, 999); 
        
        $newItem = [
            'id' => $newId,
            'user_id' => $userId,
            'food_id' => $foodId,
            'intake_date' => date('Y-m-d'),
            'meal_type' => $mealType,
            'portion_multiplier' => $portionMultiplier,
            'notes' => $notes,
            'name' => $food['name'],
            'calories' => $food['calories'],
            'protein' => $food['protein'],
            'carbs' => $food['carbs'],
            'fats' => $food['fats'],
            'image' => $food['image'],
            'base_grams' => $food['base_grams']
        ];

        $_SESSION[$this->sessionKey][$newId] = $newItem;
        return true;
    }

    public function getTodayIntake($userId, $date) {
        $userIntake = [];
        foreach ($_SESSION[$this->sessionKey] as $item) {
            if ($item['user_id'] == $userId && $item['intake_date'] == $date) {
                $userIntake[] = $item;
            }
        }
        return $userIntake;
    }

    public function deleteIntake($id, $userId) {
        if (isset($_SESSION[$this->sessionKey][$id]) && $_SESSION[$this->sessionKey][$id]['user_id'] == $userId) {
            unset($_SESSION[$this->sessionKey][$id]);
            return true;
        }
        return false;
    }
}
?>