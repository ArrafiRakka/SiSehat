<?php
require_once __DIR__ . '/../models/Kalori.php';

class KaloriController {
    
    private $model;
    
    public function __construct() {
        $this->model = new Kalori();
    }
    
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            exit();
        }

        require_once 'views/kalori/kalori.php';
    }

    public function addIntake() {
        $userId = $_SESSION['user_id'];
        $foodId = $_POST['food_id'];
        $inputGrams = $_POST['input_grams'];
        $mealType = $_POST['meal_type'] ?? 'snack'; 
        $intakeDate = $_POST['intake_date'] ?? date('Y-m-d');
        
        $food = $this->model->getFoodById($foodId);
        
        if ($food && $inputGrams > 0) {
            $portionMultiplier = $inputGrams / $food['base_grams'];
            $notes = "{$inputGrams}g";
            
            $this->model->addIntake($userId, $foodId, $mealType, $portionMultiplier, $notes, $intakeDate);
        }
        
        header('Location: index.php?action=kalori&date=' . $intakeDate);
        exit;
    }

    public function deleteIntake() {
        $userId = $_SESSION['user_id'];
        $intakeId = $_POST['intake_id'];
        $intakeDate = $_POST['intake_date'] ?? date('Y-m-d');
        
        $this->model->deleteIntake($intakeId, $userId);
        
        header('Location: index.php?action=kalori&date=' . $intakeDate);
        exit;
    }

    public function updateIntake() {
        $userId = $_SESSION['user_id'];
        $intakeId = $_POST['intake_id'];
        $inputGrams = $_POST['input_grams'];
        $mealType = $_POST['meal_type'];
        $intakeDate = $_POST['intake_date'] ?? date('Y-m-d');
        
        $item = $this->model->getIntakeById($intakeId, $userId);
        $food = $this->model->getFoodById($item['food_id']);
        
        if ($item && $food && $inputGrams > 0) {
            $portionMultiplier = $inputGrams / $food['base_grams'];
            $notes = "{$inputGrams}g (diperbarui)";
            
            $this->model->updateIntake($intakeId, $userId, $portionMultiplier, $mealType, $notes);
        }
        
        header('Location: index.php?action=kalori&date=' . $intakeDate);
        exit;
    }
}
?>