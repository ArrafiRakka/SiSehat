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
        'mealPlans' => $savedPlans
        ]);

    }

    // Simpan meal plan dari AJAX (buat future kalau mau pisahkan)
    public function save() {
        echo json_encode(['success' => true]);
    }

  public function delete() {
    $mealPlanModel = $this->loadModel('MealPlan');
    $id = $_GET['id'] ?? null;

    if ($id) {
        $mealPlanModel->deleteMealPlan($id);
    }

    header("Location: index.php?action=mealplan");
    exit;
}

public function detail() {
    $mealPlanModel = $this->loadModel('MealPlan');
    $id = $_GET['id'] ?? null;
    $mealPlan = $mealPlanModel->getMealPlanById($id);

    if (!$mealPlan) {
        echo "<p>Meal plan tidak ditemukan.</p>";
        return;
    }

    // langsung load tanpa layout
    $this->loadView('mealplan/MealPlanDetail', ['mealPlan' => $mealPlan]);
}

public function gantiMakanan() {
    $mealPlanModel = $this->loadModel('MealPlan');
    $id = $_GET['id'] ?? null;          // ID meal plan
    $foodName = $_GET['nama'] ?? null;  // nama makanan yang mau diganti

    $mealPlan = $mealPlanModel->getMealPlanById($id);

    if (!$mealPlan || !$foodName) {
        echo "<p>Data tidak ditemukan.</p>";
        return;
    }

    $this->loadView('mealplan/GantiMakanan', [
        'mealPlan'        => $mealPlan,
        'foodName'        => $foodName,
        'availableFoods'  => $mealPlanModel->getAvailableFoods(), // <— KIRIM INI
    ]);
}

public function prosesGantiMakanan() {
    $mealPlanModel = $this->loadModel('MealPlan');
    $mealPlanId = $_POST['mealplan_id'] ?? null;
    $oldFood = $_POST['old_food'] ?? null;
    $newFood = $_POST['new_food'] ?? null;

    if ($mealPlanId && $oldFood && $newFood) {
        $mealPlanModel->replaceFood($mealPlanId, $oldFood, $newFood);
    }

    header("Location: index.php?action=mealplan_detail&id=" . urlencode($mealPlanId));
    exit;
}

public function penyesuaianOlahraga() {
    $id = $_GET['id'] ?? null;
    $mealPlanModel = $this->loadModel('MealPlan');
    $mealPlan = $mealPlanModel->getMealPlanById($id);

    if (!$mealPlan) {
        echo "<p>Meal plan tidak ditemukan.</p>";
        return;
    }

    // simpan ID meal plan ke session
    $_SESSION['selected_mealplan_id'] = $id;

    $this->loadView('mealplan/PenyesuaianOlahraga', [
        'mealPlan' => $mealPlan
    ]);
}

public function prosesPenyesuaianOlahraga() {
    $jenis = $_POST['jenis_olahraga'] ?? '';
    $durasi = (int)($_POST['durasi'] ?? 0);
    $kaloriTerbakar = (int)($_POST['kalori_terbakar'] ?? 0);
    $mealPlanId = $_SESSION['selected_mealplan_id'] ?? null;

    if (!$mealPlanId) {
        echo "<p>Meal plan tidak ditemukan.</p>";
        return;
    }

    $mealPlanModel = $this->loadModel('MealPlan');
    $mealPlan = $mealPlanModel->getMealPlanById($mealPlanId);

    if (!$mealPlan) {
        echo "<p>Data meal plan tidak ditemukan.</p>";
        return;
    }

    // Hitung target baru
    $targetKaloriBaru = $mealPlan['target_kalori'] + $kaloriTerbakar;

    // Tambahkan makanan baru ke meal plan lama
    $updatedMealPlan = $mealPlanModel->addFoodsForExtraCalories(
        $mealPlanId,
        $kaloriTerbakar
    );

    // Simpan info olahraga di session
    $_SESSION['olahraga'] = [
        'jenis' => $jenis,
        'durasi' => $durasi,
        'kalori_terbakar' => $kaloriTerbakar
    ];

    // Redirect ke halaman detail meal plan yang diperbarui
    header("Location: index.php?action=mealplan_detail&id=" . urlencode($updatedMealPlan['id']));
    exit;
}




}
?>