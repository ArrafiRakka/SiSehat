<?php
// index.php
session_start();

require_once 'controllers/AuthController.php';

$authController = new AuthController();

// Tentukan 'action' (rute)
// Jika tidak ada action, default-nya 'null'
$action = $_GET['action'] ?? null;

// Cek status login
$is_logged_in = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;

switch ($action) {
    case 'login':
        if ($is_logged_in) {
            header("Location: index.php?action=dashboard"); // Jika sudah login, lempar ke dashboard
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
        if (!$is_logged_in) {
            header("Location: index.php?action=login"); // Jika belum login, lempar ke login
            exit;
        }
        $authController->handleDashboard();
        break;

    case 'bmi':
        if (!$is_logged_in) {
            header("Location: index.php?action=login");
            exit;
        }
        // Panggil BMI Controller
        require_once 'controllers/BMIController.php';
        $bmiController = new BMIController();
        $bmiController->handleBMI();
        break;

    case 'logout':
        $authController->handleLogout();
        break;

    default:
        // Aksi default: Cek login
        if ($is_logged_in) {
            header("Location: index.php?action=dashboard");
        } else {
            header("Location: index.php?action=login");
        }
        exit;
}
?>