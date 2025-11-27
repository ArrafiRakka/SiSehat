<?php
require_once 'Model.php';

class MealPlan extends Model {

    /* ======================
       GET ALL FOODS (MASTER)
       dari tabel foods (English) → alias jadi Indo
       ====================== */
    public function getAvailableFoods() {
        $sql = "SELECT 
                  id,
                  name        AS nama,
                  calories    AS kalori,
                  protein     AS protein,
                  carbs       AS gula,      -- carbs kita treat sebagai gula biar ada nilai
                  fats        AS lemak,
                  base_grams  AS porsi,
                  image       AS gambar,
                  category    AS kategori
                FROM foods
                WHERE is_active = 1";
        
        $res = $this->dbconn->query($sql);
        $foods = $res->fetch_all(MYSQLI_ASSOC);

        foreach ($foods as &$f) {
            // porsi angka → jadikan "xxx gram"
            if (isset($f['porsi']) && is_numeric($f['porsi'])) {
                $f['porsi'] = $f['porsi'] . " gram";
            }

            // gambar sudah full path (/SiSehat/public/img/xxx.jpg)
            if (empty($f['gambar'])) {
                $f['gambar'] = "/SiSehat/public/img/duh.jpg";
            }
        }

        return $foods;
    }

    /* ======================
       GENERATE RANDOM MEALPLAN
       pakai data Indo hasil alias
       ====================== */
    private function generateMeals($targetKalori) {
        $foods = $this->getAvailableFoods();
        shuffle($foods);

        $selected = [];
        $total = 0;

        foreach ($foods as $food) {
            if ($total + (int)$food['kalori'] <= $targetKalori) {
                $selected[] = $food;
                $total += (int)$food['kalori'];
            }
        }
        return $selected;
    }

    /* ======================
       CREATE MEALPLAN
       insert snapshot ke mealplan_foods (Indo)
       ====================== */
    public function createMealPlan($userId, $targetKalori, $namaMealPlan) {

        // insert header mealplans
        $stmt = $this->dbconn->prepare(
            "INSERT INTO mealplans (user_id, nama_mealplan, target_kalori)
             VALUES (?, ?, ?)"
        );
        $stmt->bind_param("isi", $userId, $namaMealPlan, $targetKalori);
        $stmt->execute();
        $mealPlanId = $stmt->insert_id;

        // generate makanan dari master foods
        $foods = $this->generateMeals($targetKalori);

        // insert snapshot ke mealplan_foods
        $insertItem = $this->dbconn->prepare(
            "INSERT INTO mealplan_foods
             (mealplan_id, nama, kalori, gula, lemak, protein, serat, porsi, gambar, kategori)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );

        foreach ($foods as $f) {
            $nama     = $f['nama'];
            $kalori   = (int)$f['kalori'];
            $gula     = (float)($f['gula'] ?? 0);
            $lemak    = (float)($f['lemak'] ?? 0);
            $protein  = (float)($f['protein'] ?? 0);
            $serat    = 0; // master foods tidak punya fiber → default 0
            $porsi    = $f['porsi'] ?? null;
            $gambar   = $f['gambar'] ?? null;
            $kategori = $f['kategori'] ?? null;

            $insertItem->bind_param(
                "isiddddsss",
                $mealPlanId, $nama, $kalori, $gula, $lemak,
                $protein, $serat, $porsi, $gambar, $kategori
            );
            $insertItem->execute();
        }

        return $this->getMealPlanById($mealPlanId);
    }

    /* ======================
       GET ALL MEALPLANS (BY USER)
       ====================== */
    public function getMealPlansByUser($userId) {
        $stmt = $this->dbconn->prepare(
            "SELECT * FROM mealplans WHERE user_id=? ORDER BY id DESC"
        );
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /* ======================
       DETAIL MEALPLAN
       ambil snapshot foods tanpa join
       ====================== */
    public function getMealPlanById($id) {
        $stmt = $this->dbconn->prepare("SELECT * FROM mealplans WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $header = $stmt->get_result()->fetch_assoc();

        if (!$header) return null;

        $stmt2 = $this->dbconn->prepare(
            "SELECT * FROM mealplan_foods WHERE mealplan_id = ?"
        );
        $stmt2->bind_param("i", $id);
        $stmt2->execute();
        $foods = $stmt2->get_result()->fetch_all(MYSQLI_ASSOC);


        // fallback gambar kalau kosong
        foreach ($foods as &$f) {
            if (empty($f['gambar'])) {
                $f['gambar'] = "/SiSehat/public/img/duh.jpg";
            }
        }

        $header['foods'] = $foods;
        return $header;
    }

    /* ======================
       DELETE MEALPLAN
       mealplan_foods auto kehapus (FK CASCADE)
       ====================== */
    public function deleteMealPlan($id) {
        $stmt = $this->dbconn->prepare("DELETE FROM mealplans WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    /* ======================
       GANTI MAKANAN
       update snapshot by nama lama → snapshot baru
       ====================== */
    public function replaceFood($mealPlanId, $oldFoodName, $newFoodName) {

        // ambil makanan baru dari master foods (English)
        $stmt = $this->dbconn->prepare(
            "SELECT name, calories, protein, carbs, fats, base_grams, image, category
             FROM foods WHERE name = ? AND is_active=1"
        );
        $stmt->bind_param("s", $newFoodName);
        $stmt->execute();
        $new = $stmt->get_result()->fetch_assoc();
        if (!$new) return false;

        $nama     = $new['name'];
        $kalori   = (int)$new['calories'];
        $gula     = (float)($new['carbs'] ?? 0);
        $lemak    = (float)($new['fats'] ?? 0);
        $protein  = (float)($new['protein'] ?? 0);
        $serat    = 0;
        $porsi    = ($new['base_grams'] ?? 0) . " gram";
        $gambar   = $new['image'] ?? "/SiSehat/public/img/duh.jpg";
        $kategori = $new['category'] ?? null;

        // update 1 snapshot row yang namanya lama
        $u = $this->dbconn->prepare(
            "UPDATE mealplan_foods
             SET nama=?, kalori=?, gula=?, lemak=?, protein=?, serat=?, porsi=?, gambar=?, kategori=?
             WHERE mealplan_id=? AND nama=? 
             LIMIT 1"
        );
        $u->bind_param(
            "siddddsssis",
            $nama, $kalori, $gula, $lemak, $protein, $serat,
            $porsi, $gambar, $kategori,
            $mealPlanId, $oldFoodName
        );

        return $u->execute();
    }

    /* ======================
       TAMBAH MAKANAN KARENA OLAHRAGA
       insert snapshot juga
       ====================== */
    public function addFoodsForExtraCalories($mealPlanId, $extraCalories) {
        $foods = $this->getAvailableFoods();
        shuffle($foods);

        $added = 0;
        $addedNames = [];

        $insert = $this->dbconn->prepare(
            "INSERT INTO mealplan_foods
             (mealplan_id, nama, kalori, gula, lemak, protein, serat, porsi, gambar, kategori)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );

        foreach ($foods as $f) {
            if ($added + (int)$f['kalori'] <= $extraCalories) {

                $nama     = $f['nama'];
                $kalori   = (int)$f['kalori'];
                $gula     = (float)($f['gula'] ?? 0);
                $lemak    = (float)($f['lemak'] ?? 0);
                $protein  = (float)($f['protein'] ?? 0);
                $serat    = 0;
                $porsi    = $f['porsi'] ?? null;
                $gambar   = $f['gambar'] ?? "/SiSehat/public/img/duh.jpg";
                $kategori = $f['kategori'] ?? null;

                $insert->bind_param(
                    "isiddddsss",
                    $mealPlanId, $nama, $kalori, $gula, $lemak,
                    $protein, $serat, $porsi, $gambar, $kategori
                );
                $insert->execute();

                $added += $kalori;
                $addedNames[] = $nama;
            }
        }

        $_SESSION['added_foods'] = $addedNames;
        return $this->getMealPlanById($mealPlanId);
    }
}
?>
