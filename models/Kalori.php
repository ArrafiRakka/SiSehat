<?php
class Kalori {
    
    private $db;

    public function __construct() {
        $this->db = new mysqli("localhost", "root", "", "sisehat");
        if ($this->db->connect_error) {
            die("Koneksi database gagal: " . $this->db->connect_error);
        }
    }

    public function getUserById($userId) {
        $query = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getFoodById($id) {
        $query = "SELECT * FROM foods WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getFoodsFiltered($keyword = '', $category = 'all') {
        $query = "SELECT * FROM foods WHERE is_active = 1";
        $params = [];
        $types = "";

        if (!empty($keyword)) {
            $query .= " AND (name LIKE ?)";
            $params[] = "%" . $keyword . "%";
            $types .= "s";
        }

        if ($category !== 'all') {
            $query .= " AND category = ?";
            $params[] = $category;
            $types .= "s";
        }
        
        $stmt = $this->db->prepare($query);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getIntakeById($intakeId, $userId) {
        $query = "SELECT di.*, f.base_grams 
                  FROM daily_intake di
                  JOIN foods f ON di.food_id = f.id
                  WHERE di.id = ? AND di.user_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $intakeId, $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function updateIntake($intakeId, $userId, $portionMultiplier, $mealType, $notes) {
        $query = "UPDATE daily_intake 
                  SET portion_multiplier = ?, meal_type = ?, notes = ? 
                  WHERE id = ? AND user_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("dsiii", $portionMultiplier, $mealType, $notes, $intakeId, $userId);
        return $stmt->execute();
    }

    public function addIntake($userId, $foodId, $mealType, $portionMultiplier, $notes, $intakeDate) {
        $query = "INSERT INTO daily_intake (user_id, food_id, intake_date, meal_type, portion_multiplier, notes) 
                  VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("iissds", $userId, $foodId, $intakeDate, $mealType, $portionMultiplier, $notes);
        return $stmt->execute();
    }

    public function getTodayIntake($userId, $date) {
        $query = "SELECT di.*, f.name, f.calories, f.protein, f.carbs, f.fats, f.image, f.base_grams 
                  FROM daily_intake di
                  JOIN foods f ON di.food_id = f.id
                  WHERE di.user_id = ? AND di.intake_date = ?
                  ORDER BY di.created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("is", $userId, $date);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function deleteIntake($id, $userId) {
        $query = "DELETE FROM daily_intake WHERE id = ? AND user_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $id, $userId);
        return $stmt->execute();
    }

    public function __destruct() {
        $this->db->close();
    }
}
?>