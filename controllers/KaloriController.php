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

        $userId = $_SESSION['user_id'];
        $currentDate = $_GET['date'] ?? date('Y-m-d');
        
        $pageTitle = "Kalori Harian";
        $userData = $this->model->getUserById($userId);
        $intakeItems = $this->model->getTodayIntake($userId, $currentDate);

        $keyword = $_GET['keyword'] ?? '';
        $category = $_GET['category'] ?? 'all';
        $filteredFoods = [];
        if (!empty($keyword)) {
            $filteredFoods = $this->model->getFoodsFiltered($keyword, $category);
        }

        $edit_id = $_GET['edit_id'] ?? null;
        $item_to_edit = null;
        if ($edit_id) {
            $item_to_edit = $this->model->getIntakeById($edit_id, $userId);
        }

        require_once 'views/layouts/header.php';
        require_once 'views/kalori/kalori.php';
        require_once 'views/layouts/footer.php';
    }

    public function addIntake() {
        $userId = $_SESSION['user_id'];
        $foodId = $_POST['food_id'];
        $inputGrams = $_POST['input_grams'];
        $mealType = $_POST['meal_type'] ?? 'snack'; 
        
        $food = $this->model->getFoodById($foodId);
        
        if ($food && $inputGrams > 0) {
            $portionMultiplier = $inputGrams / $food['base_grams'];
            $notes = "{$inputGrams}g";
            
            $this->model->addIntake($userId, $foodId, $mealType, $portionMultiplier, $notes);
        }
        
        header('Location: index.php?action=kalori');
        exit;
    }

    public function deleteIntake() {
        $userId = $_SESSION['user_id'];
        $intakeId = $_POST['intake_id'];
        
        $this->model->deleteIntake($intakeId, $userId);
        
        header('Location: index.php?action=kalori');
        exit;
    }

    public function updateIntake() {
        $userId = $_SESSION['user_id'];
        $intakeId = $_POST['intake_id'];
        $inputGrams = $_POST['input_grams'];
        $mealType = $_POST['meal_type'];
        
        $item = $this->model->getIntakeById($intakeId, $userId);
        $food = $this->model->getFoodById($item['food_id']);
        
        if ($item && $food && $inputGrams > 0) {
            $portionMultiplier = $inputGrams / $food['base_grams'];
            $notes = "{$inputGrams}g (diperbarui)";
            
            $this->model->updateIntake($intakeId, $userId, $portionMultiplier, $mealType, $notes);
        }
        
        header('Location: index.php?action=kalori');
        exit;
    }
}
?>