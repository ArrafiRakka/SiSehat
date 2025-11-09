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
        $userData = $this->model->getUserById($userId);
        $foods = $this->model->getAllFoods();

        require_once __DIR__ . '/../views/kalori/Kalori.php';
    }

    public function searchFoods() {
        header('Content-Type: application/json');
        $keyword = $_GET['keyword'] ?? '';
        $category = $_GET['category'] ?? 'all';
        $foods = $this->model->getFoodsFiltered($keyword, $category);

        echo json_encode(['success' => true, 'data' => $foods]);
        exit();
    }

    public function addIntake() {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
            exit();
        }

        $userId = $_SESSION['user_id'];
        $foodId = $_POST['food_id'];
        $mealType = $_POST['meal_type'];
        $portion = $_POST['portion_multiplier'] ?? 1;
        $notes = $_POST['notes'] ?? '';

        $result = $this->model->addIntake($userId, $foodId, $mealType, $portion, $notes);

        echo json_encode([
            'success' => $result,
            'message' => $result ? 'Makanan berhasil ditambahkan!' : 'Gagal menambahkan makanan.'
        ]);
        exit();
    }

    public function getTodayIntake() {
        header('Content-Type: application/json');
        $userId = $_SESSION['user_id'];
        $date = $_GET['date'] ?? date('Y-m-d');

        $intakes = $this->model->getTodayIntake($userId, $date);
        echo json_encode(['success' => true, 'data' => $intakes]);
        exit();
    }

    public function deleteIntake() {
        header('Content-Type: application/json');
        $id = $_POST['id'] ?? null;
        $userId = $_SESSION['user_id'];

        $result = $this->model->deleteIntake($id, $userId);
        echo json_encode([
            'success' => $result,
            'message' => $result ? 'Data berhasil dihapus!' : 'Gagal menghapus data.'
        ]);
        exit();
    }
}

// router mini (opsional)
if (isset($_GET['action'])) {
    $controller = new KaloriController();
    switch ($_GET['action']) {
        case 'search': $controller->searchFoods(); break;
        case 'add': $controller->addIntake(); break;
        case 'getTodayIntake': $controller->getTodayIntake(); break;
        case 'delete': $controller->deleteIntake(); break;
        default: $controller->index(); break;
    }
} else {
    $controller = new KaloriController();
    $controller->index();
}
?>
