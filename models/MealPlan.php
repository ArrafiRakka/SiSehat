<?php
require_once 'Model.php';

class MealPlan extends Model {

    /* ======================
       GET ALL FOODS
       ====================== */
    public function getAvailableFoods() {
        $sql = "SELECT * FROM foods_mealplan";
        $res = $this->dbconn->query($sql);
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    /* ======================
       GENERATE RANDOM MEALPLAN
       ====================== */
    private function generateMeals($targetKalori) {
        $foods = $this->getAvailableFoods();
        shuffle($foods);

        $selected = [];
        $total = 0;

        foreach ($foods as $food) {
            if ($total + $food['kalori'] <= $targetKalori) {
                $selected[] = $food;
                $total += $food['kalori'];
            }
        }

        return $selected;
    }

    /* ======================
       CREATE MEALPLAN
       ====================== */
    public function createMealPlan($userId, $targetKalori, $namaMealPlan) {

        // insert header
        $stmt = $this->dbconn->prepare(
            "INSERT INTO mealplans (user_id, nama_mealplan, target_kalori) VALUES (?, ?, ?)"
        );
        $stmt->bind_param("isi", $userId, $namaMealPlan, $targetKalori);
        $stmt->execute();

        $mealPlanId = $stmt->insert_id;

        // generate foods
        $foods = $this->generateMeals($targetKalori);

        $insertItem = $this->dbconn->prepare(
            "INSERT INTO mealplan_foods (mealplan_id, food_id) VALUES (?, ?)"
        );

        foreach ($foods as $f) {
            $insertItem->bind_param("ii", $mealPlanId, $f['id']);
            $insertItem->execute();
        }

        return $this->getMealPlanById($mealPlanId);
    }

    /* ======================
       GET ALL MEALPLANS (BY USER)
       ====================== */
    public function getMealPlansByUser($userId) {
        $stmt = $this->dbconn->prepare(
            "SELECT * FROM mealplans WHERE user_id = ? ORDER BY id DESC"
        );
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /* ======================
       DETAIL MEALPLAN (HEADER + FOODS)
       ====================== */
    public function getMealPlanById($id) {
        // header
        $stmt = $this->dbconn->prepare("SELECT * FROM mealplans WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $header = $stmt->get_result()->fetch_assoc();

        if (!$header) return null;

        // items
        $sql = "
            SELECT f.*
            FROM mealplan_foods mp
            JOIN foods_mealplan f ON mp.food_id = f.id
            WHERE mp.mealplan_id = ?
        ";
        $s2 = $this->dbconn->prepare($sql);
        $s2->bind_param("i", $id);
        $s2->execute();

        $foods = $s2->get_result()->fetch_all(MYSQLI_ASSOC);

        $header['foods'] = $foods;
        return $header;
    }

    /* ======================
       DELETE MEALPLAN
       ====================== */
    public function deleteMealPlan($id) {
        $stmt = $this->dbconn->prepare(
            "DELETE FROM mealplans WHERE id = ?"
        );
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    /* ======================
       GANTI MAKANAN
       ====================== */
    public function replaceFood($mealPlanId, $oldFoodName, $newFoodName) {

        // get old food id
        $stmt = $this->dbconn->prepare("SELECT id FROM foods_mealplan WHERE nama = ?");
        $stmt->bind_param("s", $oldFoodName);
        $stmt->execute();
        $old = $stmt->get_result()->fetch_assoc();
        if (!$old) return;

        // get new food id
        $stmt2 = $this->dbconn->prepare("SELECT id FROM foods_mealplan WHERE nama = ?");
        $stmt2->bind_param("s", $newFoodName);
        $stmt2->execute();
        $new = $stmt2->get_result()->fetch_assoc();
        if (!$new) return;

        // update mealplan_foods
        $u = $this->dbconn->prepare(
            "UPDATE mealplan_foods SET food_id = ? WHERE mealplan_id = ? AND food_id = ?"
        );
        $u->bind_param("iii", $new['id'], $mealPlanId, $old['id']);
        $u->execute();
    }

    /* ======================
       TAMBAH MAKANAN KARENA OLAHRAGA
       ====================== */
    public function addFoodsForExtraCalories($mealPlanId, $extraCalories) {
        $foods = $this->getAvailableFoods();
        shuffle($foods);

        $added = 0;

        $insert = $this->dbconn->prepare(
            "INSERT INTO mealplan_foods (mealplan_id, food_id) VALUES (?, ?)"
        );

        foreach ($foods as $f) {
            if ($added + $f['kalori'] <= $extraCalories) {
                $insert->bind_param("ii", $mealPlanId, $f['id']);
                $insert->execute();
                $added += $f['kalori'];
            }
        }

        return $this->getMealPlanById($mealPlanId);
    }
}
?>
