<?php
require_once 'Controller.php';

class MealPlanController extends Controller {

    public function index() {
        
        $mealPlanModel = $this->loadModel('MealPlan');

        // Ambil semua meal plan user (dummy userId = 1)
        $userId = $_SESSION['user_id'] ?? 1;
        $savedPlans = $mealPlanModel->getMealPlansByUser($userId);

        // Kalau form disubmit → buat meal plan baru
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $targetKalori = $_POST['target_kalori'] ?? 0;
            $namaMealPlan = $_POST['nama_mealplan'] ?? '';

            $mealPlan = $mealPlanModel->createMealPlan($userId, $targetKalori, $namaMealPlan);

            // Arahkan ke halaman hasil
            $this->loadView('mealplan/MealPlanResult', [
                'mealPlan' => $mealPlan
            ]);
            return;
        }

        // Halaman awal (list meal plan)
        $this->loadView('mealplan/MealPlan', [
            'savedPlans' => $savedPlans
        ]);
    }

    // Simpan meal plan dari AJAX (buat future kalau mau pisahkan)
    public function save() {
        echo json_encode(['success' => true]);
    }
}
?>
