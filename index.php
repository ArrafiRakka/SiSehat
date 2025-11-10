<?php
// index.php
session_start();

// Dummy login sementara
// $_SESSION['loggedin'] = true;
// $_SESSION['username'] = 'dev';
// $_SESSION['user_id'] = 1;

require_once 'controllers/AuthController.php';
$authController = new AuthController();

// Tentukan 'action' (rute)
$action = $_GET['action'] ?? null;

// Cek status login
$is_logged_in = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;

switch ($action) {
    case 'login':
        if ($is_logged_in) {
            header("Location: index.php?action=dashboard");
            exit;
        }
        $authController->handleLogin();
        break;

    case 'register':
        if ($is_logged_in) {
            header("Location: index.php?action=dashboard");
            exit;
        }
        $authController->handleRegister();
        break;

    case 'dashboard':
        require_once 'controllers/AuthController.php';
        $auth = new AuthController();
        $auth->handleDashboard();
        break;

    case 'bmi':
        if (!$is_logged_in) {
            header("Location: index.php?action=login");
            exit;
        }
        require_once 'controllers/BMIController.php';
        $bmiController = new BMIController();
        $bmiController->handleBMI();
        break;
    
    case 'workout':
        if (!$is_logged_in) {
            header("Location: index.php?action=login");
            exit;
        }
        require_once 'controllers/WorkoutController.php';
        $workoutController = new WorkoutController();
        $workoutController->index();
        break;

    case 'kalori':
        if (!$is_logged_in) {
            header("Location: index.php?action=login");
            exit;
        }
        require_once 'controllers/KaloriController.php';
        $kaloriController = new KaloriController();
        $kaloriController->index();
        break;

    case 'kalori_add':
        if (!$is_logged_in) {
            header("Location: index.php?action=login");
            exit;
        }
        require_once 'controllers/KaloriController.php';
        $kaloriController = new KaloriController();
        $kaloriController->addIntake();
        break;

    case 'kalori_delete':
        if (!$is_logged_in) {
            header("Location: index.php?action=login");
            exit;
        }
        require_once 'controllers/KaloriController.php';
        $kaloriController = new KaloriController();
        $kaloriController->deleteIntake();
        break;
    
    case 'kalori_update':
        if (!$is_logged_in) {
            header("Location: index.php?action=login");
            exit;
        }
        require_once 'controllers/KaloriController.php';
        $kaloriController = new KaloriController();
        $kaloriController->updateIntake();
        break;

    case 'mealplan':
        if (!$is_logged_in) {
            header("Location: index.php?action=login");
            exit;
        }
        require_once 'controllers/MealPlanController.php';
        $mealPlanController = new MealPlanController();
        $mealPlanController->index();
        break;

    case 'savemealplan':
        require_once 'controllers/MealPlanController.php';
        $controller = new MealPlanController();
        $controller->save();
        break;

    case 'delete_mealplan':
        require_once 'controllers/MealPlanController.php';
        $controller = new MealPlanController();
        $controller->delete();
        break;

    case 'mealplan_detail':
        require_once 'controllers/MealPlanController.php';
        $controller = new MealPlanController();
        $controller->detail();
        break;

    case 'ganti_makanan':
        require_once 'controllers/MealPlanController.php';
        $controller = new MealPlanController();
        $controller->gantiMakanan();
        break;

    case 'proses_ganti_makanan':
        require_once 'controllers/MealPlanController.php';
        $controller = new MealPlanController();
        $controller->prosesGantiMakanan();
        break;

    case 'penyesuaian_olahraga':
        require_once 'controllers/MealPlanController.php';
        $controller = new MealPlanController();
        $controller->penyesuaianOlahraga();
        break;

    case 'proses_penyesuaian_olahraga':
        require_once 'controllers/MealPlanController.php';
        $controller = new MealPlanController();
        $controller->prosesPenyesuaianOlahraga();
        break;


    case 'consultation':
        if (!$is_logged_in) {
            header("Location: index.php?action=login");
            exit;
        }
        require_once 'controllers/ConsultationController.php';
        $controller = new ConsultationController();
        $controller->index();
        break;

    case 'consultation_payment':
        require_once 'controllers/ConsultationController.php';
        $controller = new ConsultationController();
        $controller->payment();
        break;

    case 'consultation_chat':
        require_once 'controllers/ConsultationController.php';
        $controller = new ConsultationController();
        $controller->chat();
        break;

    case 'consultation_result':
        require_once 'controllers/ConsultationController.php';
        $controller = new ConsultationController();
        $controller->result();
        break;
        
    case 'logout':
        $authController->handleLogout();
        break;

    case 'profile':
        if (!$is_logged_in) {
            header("Location: index.php?action=login");
            exit;
        }
        $authController->showProfile();
        break;

    case 'update_profile':
        $authController->updateProfile();
        break;

    case 'update_password':
        $authController->updatePassword();
        break;

    default:
        if ($is_logged_in) {
            header("Location: index.php?action=dashboard");
        } else {
            header("Location: index.php?action=login");
        }
        exit;
}
?>
