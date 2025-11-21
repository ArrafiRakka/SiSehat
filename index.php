<?php
session_start();
define('BASE_URL', 'http://localhost/RSIPRAK/');

require_once 'controllers/AuthController.php';
$authController = new AuthController();

$action = $_GET['action'] ?? null;

$is_logged_in = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
$role = $_SESSION['role'] ?? 'guest';

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

    // --- RUTE USER (KESEHATAN) ---
    case 'bmi':
        if (!$is_logged_in) { header("Location: index.php?action=login"); exit; }
        require_once 'controllers/BMIController.php';
        $bmiController = new BMIController();
        $bmiController->handleBMI();
        break;
    
    case 'workout':
        if (!$is_logged_in) { header("Location: index.php?action=login"); exit; }
        require_once 'controllers/WorkoutController.php';
        $workoutController = new WorkoutController();
        $workoutController->index();
        break;

    case 'kalori':
        if (!$is_logged_in) { header("Location: index.php?action=login"); exit; }
        require_once 'controllers/KaloriController.php';
        $kaloriController = new KaloriController();
        $kaloriController->index();
        break;

    case 'kalori_add':
        if (!$is_logged_in) { header("Location: index.php?action=login"); exit; }
        require_once 'controllers/KaloriController.php';
        $kaloriController = new KaloriController();
        $kaloriController->addIntake();
        break;

    case 'kalori_delete':
        if (!$is_logged_in) { header("Location: index.php?action=login"); exit; }
        require_once 'controllers/KaloriController.php';
        $kaloriController = new KaloriController();
        $kaloriController->deleteIntake();
        break;
    
    case 'kalori_update':
        if (!$is_logged_in) { header("Location: index.php?action=login"); exit; }
        require_once 'controllers/KaloriController.php';
        $kaloriController = new KaloriController();
        $kaloriController->updateIntake();
        break;

    case 'mealplan':
        if (!$is_logged_in) { header("Location: index.php?action=login"); exit; }
        require_once 'controllers/MealPlanController.php';
        $mealPlanController = new MealPlanController();
        $mealPlanController->index();
        break;
    
    // ... (Meal plan sub-actions: save, delete, detail, ganti_makanan, dll) ...
    case 'savemealplan':
        require_once 'controllers/MealPlanController.php';
        (new MealPlanController())->save();
        break;
    case 'delete_mealplan':
        require_once 'controllers/MealPlanController.php';
        (new MealPlanController())->delete();
        break;
    case 'mealplan_detail':
        require_once 'controllers/MealPlanController.php';
        (new MealPlanController())->detail();
        break;
    case 'ganti_makanan':
        require_once 'controllers/MealPlanController.php';
        (new MealPlanController())->gantiMakanan();
        break;
    case 'proses_ganti_makanan':
        require_once 'controllers/MealPlanController.php';
        (new MealPlanController())->prosesGantiMakanan();
        break;
    case 'penyesuaian_olahraga':
        require_once 'controllers/MealPlanController.php';
        (new MealPlanController())->penyesuaianOlahraga();
        break;
    case 'proses_penyesuaian_olahraga':
        require_once 'controllers/MealPlanController.php';
        (new MealPlanController())->prosesPenyesuaianOlahraga();
        break;

    case 'consultation':
        if (!$is_logged_in) { header("Location: index.php?action=login"); exit; }
        require_once 'controllers/ConsultationController.php';
        (new ConsultationController())->index();
        break;
    case 'consultation_payment':
        require_once 'controllers/ConsultationController.php';
        (new ConsultationController())->payment();
        break;
    case 'consultation_chat':
        require_once 'controllers/ConsultationController.php';
        (new ConsultationController())->chat();
        break;
    case 'consultation_result':
        require_once 'controllers/ConsultationController.php';
        (new ConsultationController())->result();
        break;

    // --- RUTE ADMIN (BARU) ---
    case 'admin_food':
        // Cek Login & Role Admin
        if (!$is_logged_in || $role !== 'admin') { 
            header("Location: index.php?action=dashboard"); 
            exit; 
        }
        require_once 'controllers/AdminController.php';
        $adminController = new AdminController();
        $adminController->handleFoodManagement();
        break;

    case 'admin_food_edit':
        if (!$is_logged_in || $role !== 'admin') { header("Location: index.php?action=dashboard"); exit; }
        require_once 'controllers/AdminController.php';
        (new AdminController())->handleFoodEdit();
        break;
    
    case 'admin_users':
        // Cek Login & Role Admin
        if (!$is_logged_in || $role !== 'admin') { 
            header("Location: index.php?action=dashboard"); 
            exit; 
        }
        require_once 'controllers/AdminController.php';
        $adminController = new AdminController();
        $adminController->handleUserManagement();
        break;

    case 'admin_workouts':
        if (!$is_logged_in || $role !== 'admin') { 
            header("Location: index.php?action=dashboard"); 
            exit; 
        }
        require_once 'controllers/AdminController.php';
        $controller = new AdminController();
        $controller->handleWorkoutManagement();
        break; 

    case 'admin_workout_edit':
        if (!$is_logged_in || $role !== 'admin') { 
            header("Location: index.php?action=dashboard"); 
            exit; 
        }
        require_once 'controllers/AdminController.php';
        $controller = new AdminController();
        $controller->handleWorkoutEdit();
        break;

    case 'workout_recommendation':
        if (!$is_logged_in || $role !== 'user') { 
            header("Location: index.php?action=dashboard"); 
            exit; 
        }
        require_once 'controllers/WorkoutController.php';
    $controller = new WorkoutController();
    $controller->handleRecommendation();
    break;

    // --- RUTE UMUM ---
    case 'logout':
        $authController->handleLogout();
        break;

    case 'profile':
        if (!$is_logged_in) { header("Location: index.php?action=login"); exit; }
        $authController->showProfile();
        break;

    case 'update_profile':
        if (!$is_logged_in) { header("Location: index.php?action=login"); exit; }
        $authController->handleUpdateProfile();
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