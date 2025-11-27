<?php
require_once 'Controller.php';

class MealPlanController extends Controller {

    /* ============================================
       HALAMAN UTAMA MEALPLAN + CREATE MEALPLAN
    ============================================ */
    public function index() {

        $mealPlanModel = $this->loadModel('MealPlan');

        // user login (fallback id 1 kalau session belum ada)
        $userId = $_SESSION['user_id'] ?? 1;

        // ambil mealplan yang pernah dibuat user
        $savedPlans = $mealPlanModel->getMealPlansByUser($userId);

        // FORM SUBMIT → buat mealplan baru
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $targetKalori = (int)($_POST['target_kalori'] ?? 0);
            $namaMealPlan = trim($_POST['nama_mealplan'] ?? '');

            if ($targetKalori <= 0 || $namaMealPlan === '') {
                // kalau input kosong / tidak valid, balik ke form
                $this->loadView('mealplan/MealPlan', [
                    'mealPlans' => $savedPlans,
                    'error' => 'Target kalori dan nama mealplan wajib diisi.'
                ]);
                return;
            }

            // create mealplan (DB + snapshot foods)
            $mealPlan = $mealPlanModel->createMealPlan($userId, $targetKalori, $namaMealPlan);

            // tampilkan hasil
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
       mealplan_foods auto kehapus (FK CASCADE)
    ============================================ */
    public function delete() {
        $mealPlanModel = $this->loadModel('MealPlan');
        $id = $_GET['id'] ?? null;

        if ($id) {
            $mealPlanModel->deleteMealPlan((int)$id);
        }

        header("Location: index.php?action=mealplan");
        exit;
    }

    /* ============================================
       DETAIL MEALPLAN
       ambil header + snapshot foods
    ============================================ */
    public function detail() {
        $mealPlanModel = $this->loadModel('MealPlan');
        $id = $_GET['id'] ?? null;

        if (!$id) {
            echo "<p>Meal plan tidak ditemukan.</p>";
            return;
        }

        $mealPlan = $mealPlanModel->getMealPlanById((int)$id);

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
       snapshot_id = id row mealplan_foods
    ============================================ */
    public function gantiMakanan() {
    $mealPlanModel = $this->loadModel('MealPlan');

    // ambil mealplan id dari URL
    $mealPlanId = $_GET['id'] ?? null;

    // ambil nama makanan dari URL (fallback kalau param beda)
    $foodName = $_GET['nama'] ?? $_GET['food'] ?? $_GET['food_name'] ?? null;

    if (!$mealPlanId || !$foodName) {
        echo "<p>Data tidak ditemukan.</p>";
        return;
    }

    $mealPlan = $mealPlanModel->getMealPlanById($mealPlanId);

    if (!$mealPlan) {
        echo "<p>Meal plan tidak ditemukan.</p>";
        return;
    }

    $this->loadView('mealplan/GantiMakanan', [
        'mealPlan'       => $mealPlan,
        'foodName'       => $foodName,
        'availableFoods' => $mealPlanModel->getAvailableFoods()
    ]);
}



    /* ============================================
       PROSES GANTI MAKANAN
       update snapshot row mealplan_foods
    ============================================ */
    public function prosesGantiMakanan() {
        $mealPlanModel = $this->loadModel('MealPlan');

        $mealPlanId = $_POST['mealplan_id'] ?? null;
        $snapshotId = $_POST['snapshot_id'] ?? null;
        $newFoodId  = $_POST['new_food_id'] ?? null;

        if ($mealPlanId && $snapshotId && $newFoodId) {
            $mealPlanModel->replaceFoodBySnapshotId(
                (int)$mealPlanId,
                (int)$snapshotId,
                (int)$newFoodId
            );
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
        if (!$id) {
            echo "<p>Meal plan tidak ditemukan.</p>";
            return;
        }

        $mealPlan = $mealPlanModel->getMealPlanById((int)$id);

        if (!$mealPlan) {
            echo "<p>Meal plan tidak ditemukan.</p>";
            return;
        }

        // simpan id mealplan yg dipilih
        $_SESSION['selected_mealplan_id'] = (int)$id;

        $this->loadView('mealplan/PenyesuaianOlahraga', [
            'mealPlan' => $mealPlan
        ]);
    }

    /* ============================================
       PROSES PENYESUAIAN OLAHRAGA
       tambah snapshot foods baru
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

        // tambah makanan berdasarkan extraCalories (snapshot insert)
        $mealPlanModel->addFoodsForExtraCalories((int)$mealPlanId, $kaloriTerbakar);

        // simpan info olahraga buat UI detail
        $_SESSION['olahraga'] = [
            'jenis'           => $jenis,
            'durasi'          => $durasi,
            'kalori_terbakar' => $kaloriTerbakar
        ];

        header("Location: index.php?action=mealplan_detail&id=" . urlencode($mealPlanId));
        exit;
    }
}
?>
