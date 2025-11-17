<?php
require_once 'Controller.php';

class MealPlanController extends Controller {

    public function index() {

        $mealPlanModel = $this->loadModel('MealPlan');

        // User login
        $userId = $_SESSION['user_id'] ?? 1;

        // Ambil mealplan user dari DB
        $savedPlans = $mealPlanModel->getMealPlansByUser($userId);

        // FORM SUBMIT → buat mealplan baru
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $targetKalori = $_POST['target_kalori'] ?? 0;
            $namaMealPlan = $_POST['nama_mealplan'] ?? '';

            // Create mealplan (DB)
            $mealPlan = $mealPlanModel->createMealPlan($userId, $targetKalori, $namaMealPlan);

            // Redirect ke halaman hasil
            $this->loadView('mealplan/MealPlanResult', [
                'mealPlan' => $mealPlan
            ]);
            return;
        }

        // halaman daftar mealplan
        $this->loadView('mealplan/MealPlan', [
            'mealPlans' => $savedPlans
        ]);
    }

    /* ============================================
       DELETE MEALPLAN
    ============================================ */
    public function delete() {
        $mealPlanModel = $this->loadModel('MealPlan');
        $id = $_GET['id'] ?? null;

        if ($id) {
            $mealPlanModel->deleteMealPlan($id);
        }

        header("Location: index.php?action=mealplan");
        exit;
    }

    /* ============================================
       DETAIL MEALPLAN
    ============================================ */
    public function detail() {
        $mealPlanModel = $this->loadModel('MealPlan');
        $id = $_GET['id'] ?? null;

        $mealPlan = $mealPlanModel->getMealPlanById($id);

        if (!$mealPlan) {
            echo "<p>Meal plan tidak ditemukan.</p>";
            return;
        }

        // load halaman detail
        $this->loadView('mealplan/MealPlanDetail', [
            'mealPlan' => $mealPlan
        ]);
    }

    /* ============================================
       HALAMAN GANTI MAKANAN
    ============================================ */
    public function gantiMakanan() {
        $mealPlanModel = $this->loadModel('MealPlan');

        $mealPlanId = $_GET['id'] ?? null;
        $foodName   = $_GET['nama'] ?? null;

        $mealPlan = $mealPlanModel->getMealPlanById($mealPlanId);

        if (!$mealPlan || !$foodName) {
            echo "<p>Data tidak ditemukan.</p>";
            return;
        }

        $this->loadView('mealplan/GantiMakanan', [
            'mealPlan'       => $mealPlan,
            'foodName'       => $foodName,
            'availableFoods' => $mealPlanModel->getAvailableFoods()
        ]);
    }

    /* ============================================
       PROSES GANTI MAKANAN (Database)
    ============================================ */
    public function prosesGantiMakanan() {
        $mealPlanModel = $this->loadModel('MealPlan');

        $mealPlanId = $_POST['mealplan_id'] ?? null;
        $oldFood    = $_POST['old_food'] ?? null;
        $newFood    = $_POST['new_food'] ?? null;

        if ($mealPlanId && $oldFood && $newFood) {
            $mealPlanModel->replaceFood($mealPlanId, $oldFood, $newFood);
        }

        header("Location: index.php?action=mealplan_detail&id=" . urlencode($mealPlanId));
        exit;
    }

    /* ============================================
       HALAMAN SESUAIKAN DENGAN OLAHRAGA
    ============================================ */
    public function penyesuaianOlahraga() {
        $mealPlanModel = $this->loadModel('MealPlan');

        $id = $_GET['id'] ?? null;

        $mealPlan = $mealPlanModel->getMealPlanById($id);

        if (!$mealPlan) {
            echo "<p>Meal plan tidak ditemukan.</p>";
            return;
        }

        // simpan id mealplan
        $_SESSION['selected_mealplan_id'] = $id;

        $this->loadView('mealplan/PenyesuaianOlahraga', [
            'mealPlan' => $mealPlan
        ]);
    }

    /* ============================================
       PROSES PENAMBAHAN MAKANAN DARI OLAHRAGA
    ============================================ */
    public function prosesPenyesuaianOlahraga() {

        $jenis          = $_POST['jenis_olahraga'] ?? '';
        $durasi         = (int) ($_POST['durasi'] ?? 0);
        $kaloriTerbakar = (int) ($_POST['kalori_terbakar'] ?? 0);

        $mealPlanId = $_SESSION['selected_mealplan_id'] ?? null;

        if (!$mealPlanId) {
            echo "<p>Meal plan tidak ditemukan.</p>";
            return;
        }

        $mealPlanModel = $this->loadModel('MealPlan');

        // update makanan berdasarkan kalori tambahan
        $updatedMealPlan = $mealPlanModel->addFoodsForExtraCalories($mealPlanId, $kaloriTerbakar);

        // simpan ke session untuk ditampilkan di UI
        $_SESSION['olahraga'] = [
            'jenis'          => $jenis,
            'durasi'         => $durasi,
            'kalori_terbakar'=> $kaloriTerbakar
        ];

        header("Location: index.php?action=mealplan_detail&id=" . urlencode($mealPlanId));
        exit;
    }
}
?>
