<?php
class MealPlan {
    private $foods = [
        [
            "nama" => "Oatmeal",
            "kalori" => 200,
            "gula" => 5,
            "lemak" => 0,
            "protein" => 3,
            "serat" => 4,
            "gambar" => "public/images/oatmeal.jpg",
            "porsi" => "150g"
        ],
        [
            "nama" => "Susu",
            "kalori" => 200,
            "gula" => 5,
            "lemak" => 0,
            "protein" => 3,
            "serat" => 4,
            "gambar" => "public/images/susu.jpg",
            "porsi" => "200ml"
        ],
        [
            "nama" => "Nasi Goreng",
            "kalori" => 200,
            "gula" => 5,
            "lemak" => 0,
            "protein" => 3,
            "serat" => 4,
            "gambar" => "public/images/nasigoreng.jpg",
            "porsi" => "500g"
        ],
        [
            "nama" => "Bayam",
            "kalori" => 80,
            "gula" => 1,
            "lemak" => 0,
            "protein" => 2,
            "serat" => 2,
            "gambar" => "public/images/bayam.jpg",
            "porsi" => "100g"
        ],
        [
            "nama" => "Sate Padang",
            "kalori" => 350,
            "gula" => 2,
            "lemak" => 15,
            "protein" => 20,
            "serat" => 1,
            "gambar" => "public/images/satepadang.jpg",
            "porsi" => "200g"
        ],
        [
            "nama" => "Soto Betawi",
            "kalori" => 300,
            "gula" => 3,
            "lemak" => 12,
            "protein" => 18,
            "serat" => 2,
            "gambar" => "public/images/sotobetawi.jpg",
            "porsi" => "250g"
        ]
    ];

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['mealplans'])) {
            $_SESSION['mealplans'] = [];
        }
    }

    public function createMealPlan($userId, $targetKalori, $namaMealPlan) {
        $selectedFoods = $this->generateMeals($targetKalori);

        $mealPlan = [
            'id' => uniqid(),
            'user_id' => $userId,
            'nama_mealplan' => $namaMealPlan,
            'target_kalori' => $targetKalori,
            'foods' => $selectedFoods
        ];

        $_SESSION['mealplans'][] = $mealPlan;
        return $mealPlan;
    }

    private function generateMeals($targetKalori) {
        $total = 0;
        $selected = [];
        $foods = $this->foods;
        shuffle($foods);

        foreach ($foods as $food) {
            if ($total + $food['kalori'] <= $targetKalori) {
                $selected[] = $food;
                $total += $food['kalori'];
            }
        }

        return $selected;
    }

    public function getMealPlansByUser($userId) {
        return $_SESSION['mealplans'] ?? [];
    }

    public function getMealPlanById($id) {
        foreach ($_SESSION['mealplans'] as $mp) {
            if ($mp['id'] === $id) return $mp;
        }
        return null;
    }

    public function deleteMealPlan($id) {
    if (!isset($_SESSION['mealplans'])) return;

    foreach ($_SESSION['mealplans'] as $key => $mp) {
        if ($mp['id'] === $id) {
            unset($_SESSION['mealplans'][$key]);
            $_SESSION['mealplans'] = array_values($_SESSION['mealplans']); // reset index array
            break;
        }
    }
}

}
