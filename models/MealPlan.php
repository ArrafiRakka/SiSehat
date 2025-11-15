<?php
class MealPlan {
    private $foods = [
    [
        "nama" => "Oatmeal",
        "kalori" => 200,
        "gula" => 5,
        "lemak" => 3,
        "protein" => 6,
        "serat" => 4,
        "gambar" => "public/images/oatmeal.jpg",
        "porsi" => "150g"
    ],
    [
        "nama" => "Susu",
        "kalori" => 180,
        "gula" => 8,
        "lemak" => 5,
        "protein" => 8,
        "serat" => 0,
        "gambar" => "public/images/susu.jpg",
        "porsi" => "200ml"
    ],
    [
        "nama" => "Nasi Goreng",
        "kalori" => 360,
        "gula" => 3,
        "lemak" => 12,
        "protein" => 10,
        "serat" => 2,
        "gambar" => "public/images/nasigoreng.jpg",
        "porsi" => "250g"
    ],
    [
        "nama" => "Bayam Rebus",
        "kalori" => 70,
        "gula" => 1,
        "lemak" => 0,
        "protein" => 2,
        "serat" => 3,
        "gambar" => "public/images/bayam.jpg",
        "porsi" => "100g"
    ],
    [
        "nama" => "Sate Padang",
        "kalori" => 400,
        "gula" => 2,
        "lemak" => 18,
        "protein" => 20,
        "serat" => 1,
        "gambar" => "public/images/satepadang.jpg",
        "porsi" => "200g"
    ],
    [
        "nama" => "Soto Betawi",
        "kalori" => 320,
        "gula" => 3,
        "lemak" => 14,
        "protein" => 15,
        "serat" => 2,
        "gambar" => "public/images/sotobetawi.jpg",
        "porsi" => "250g"
    ],
    [
        "nama" => "Ayam Panggang",
        "kalori" => 250,
        "gula" => 0,
        "lemak" => 10,
        "protein" => 30,
        "serat" => 0,
        "gambar" => "public/images/ayampanggang.jpg",
        "porsi" => "150g"
    ],
    [
        "nama" => "Tempe Goreng",
        "kalori" => 180,
        "gula" => 0,
        "lemak" => 9,
        "protein" => 10,
        "serat" => 2,
        "gambar" => "public/images/tempegoreng.jpg",
        "porsi" => "100g"
    ],
    [
        "nama" => "Tahu Kukus",
        "kalori" => 120,
        "gula" => 0,
        "lemak" => 6,
        "protein" => 12,
        "serat" => 1,
        "gambar" => "public/images/tahukukus.jpg",
        "porsi" => "100g"
    ],
    [
        "nama" => "Ikan Bakar",
        "kalori" => 220,
        "gula" => 0,
        "lemak" => 8,
        "protein" => 25,
        "serat" => 0,
        "gambar" => "public/images/ikanbakar.jpg",
        "porsi" => "150g"
    ],
    [
        "nama" => "Telur Rebus",
        "kalori" => 75,
        "gula" => 0,
        "lemak" => 5,
        "protein" => 6,
        "serat" => 0,
        "gambar" => "public/images/telurrebus.jpg",
        "porsi" => "1 butir"
    ],
    [
        "nama" => "Salad Sayur",
        "kalori" => 90,
        "gula" => 4,
        "lemak" => 3,
        "protein" => 2,
        "serat" => 3,
        "gambar" => "public/images/salad.jpg",
        "porsi" => "120g"
    ],
    [
        "nama" => "Smoothie Buah",
        "kalori" => 150,
        "gula" => 20,
        "lemak" => 2,
        "protein" => 3,
        "serat" => 2,
        "gambar" => "public/images/smoothie.jpg",
        "porsi" => "250ml"
    ],
    [
        "nama" => "Kentang Rebus",
        "kalori" => 160,
        "gula" => 1,
        "lemak" => 0,
        "protein" => 4,
        "serat" => 3,
        "gambar" => "public/images/kentangrebus.jpg",
        "porsi" => "200g"
    ],
    [
        "nama" => "Roti Gandum",
        "kalori" => 130,
        "gula" => 4,
        "lemak" => 2,
        "protein" => 5,
        "serat" => 3,
        "gambar" => "public/images/rotigandum.jpg",
        "porsi" => "2 lembar"
    ],
    [
        "nama" => "Yogurt Plain",
        "kalori" => 100,
        "gula" => 7,
        "lemak" => 3,
        "protein" => 8,
        "serat" => 0,
        "gambar" => "public/images/yogurt.jpg",
        "porsi" => "150ml"
    ],
    [
        "nama" => "Chia Pudding",
        "kalori" => 180,
        "gula" => 5,
        "lemak" => 6,
        "protein" => 4,
        "serat" => 6,
        "gambar" => "public/images/chiapudding.jpg",
        "porsi" => "100g"
    ],
    [
        "nama" => "Jus Jeruk",
        "kalori" => 90,
        "gula" => 16,
        "lemak" => 0,
        "protein" => 2,
        "serat" => 1,
        "gambar" => "public/images/jusjeruk.jpg",
        "porsi" => "200ml"
    ],
    [
        "nama" => "Alpukat Lumat",
        "kalori" => 200,
        "gula" => 1,
        "lemak" => 18,
        "protein" => 3,
        "serat" => 5,
        "gambar" => "public/images/alpukat.jpg",
        "porsi" => "100g"
    ],
    [
        "nama" => "Sup Sayur",
        "kalori" => 110,
        "gula" => 3,
        "lemak" => 4,
        "protein" => 5,
        "serat" => 2,
        "gambar" => "public/images/supsayur.jpg",
        "porsi" => "250ml"
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

    // Hitung batas jumlah makanan berdasarkan total kalori
    $maxFoods = 6;
    if ($targetKalori > 2000 && $targetKalori <= 3000) $maxFoods = 8;
    elseif ($targetKalori > 3000 && $targetKalori <= 5000) $maxFoods = 10;
    elseif ($targetKalori > 5000) $maxFoods = 12;

    foreach ($foods as $food) {
        if ($total + $food['kalori'] <= $targetKalori && count($selected) < $maxFoods) {
            $selected[] = $food;
            $total += $food['kalori'];
        }
    }

    return $selected;
}

public function addFoodsForExtraCalories($mealPlanId, $extraCalories) {
    foreach ($_SESSION['mealplans'] as &$plan) {
        if ($plan['id'] === $mealPlanId) {
            $foods = $this->foods;
            shuffle($foods);

            $totalAdded = 0;
            $addedFoods = [];

            foreach ($foods as $food) {
                if ($totalAdded + $food['kalori'] <= $extraCalories) {
                    $addedFoods[] = $food;
                    $totalAdded += $food['kalori'];
                }
                if ($totalAdded >= $extraCalories) break;
            }

            // Gabungkan makanan baru dengan yang lama
            $plan['foods'] = array_merge($plan['foods'], $addedFoods);
            $plan['target_kalori'] += $extraCalories;

            return $plan;
        }
    }

    return null;
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

public function replaceFood($mealPlanId, $oldFoodName, $newFoodName) {
    foreach ($_SESSION['mealplans'] as &$plan) {
        if ($plan['id'] === $mealPlanId) {
            foreach ($plan['foods'] as &$food) {
                if ($food['nama'] === $oldFoodName) {
                    // Cari data makanan baru dari daftar default
                    foreach ($this->foods as $f) {
                        if (strcasecmp($f['nama'], $newFoodName) === 0) {
                            $food = $f;
                            break;
                        }
                    }
                    break;
                }
            }
        }
    }
}

public function getAvailableFoods() {
    return $this->foods;
}



}