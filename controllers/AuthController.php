<?php
// controllers/AuthController.php

require_once 'models/User.php';

class AuthController {
    
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    /* ===========================
         LOGIN
    ============================ */
    public function handleLogin() {
        $error = '';
        $success = '';

        if (isset($_GET['status']) && $_GET['status'] == 'sukses') {
            $success = "Registrasi berhasil! Silakan login.";
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email_or_username = trim($_POST['email_username']);
            $password = $_POST['password'];

            if (empty($email_or_username) || empty($password)) {
                $error = "Email/Username dan Password wajib diisi!";
            } else {
                $user = $this->userModel->getUserByEmailOrUsername($email_or_username);
                
                if ($user && password_verify($password, $user['password'])) {

                    $_SESSION['loggedin'] = true;
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['role'] = $user['role'];

                    header("Location: index.php?action=dashboard");
                    exit;

                } else {
                    $error = "Email/Username atau Password salah!";
                }
            }
        }

        // FIX MAIN PROBLEM
        require __DIR__ . '/../views/auth/index.php';
    }

    /* ===========================
         REGISTER
    ============================ */
    public function handleRegister() {
        $error = '';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            if (empty($username) || empty($email) || empty($password)) {
                $error = "Semua kolom wajib diisi!";
            } elseif ($password !== $confirm_password) {
                $error = "Password dan Konfirmasi Password tidak cocok!";
            } elseif (strlen($password) < 6) {
                $error = "Password minimal 6 karakter.";
            } else {

                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                if ($this->userModel->createUser($username, $email, $hashed_password)) {

                    header("Location: index.php?action=login&status=sukses");
                    exit;

                } else {
                    $error = "Email atau Username sudah terdaftar!";
                }
            }
        }

        // FIX MAIN PROBLEM
        require __DIR__ . '/../views/auth/index.php';
    }

    public function handleDashboard() {
        // Pastikan session aktif
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Kalau belum login, tendang ke login
        if (empty($_SESSION['loggedin'])) {
            header("Location: index.php?action=login");
            exit;
        }

        $username = $_SESSION['username'] ?? 'Guest';
        $role = $_SESSION['role'] ?? 'user';

        // --- LOGIKA PEMISAH DASHBOARD ---
        if ($role === 'admin') {
            // 1. Panggil Model User
            require_once 'models/User.php';
            $userModel = new User();
                
            // 2. Ambil Jumlah User dari Database
            $totalUsers = $userModel->getUserCount();

            // (Opsional: Ambil juga jumlah makanan biar sekalian)
            require_once 'models/Kalori.php';
            $kaloriModel = new Kalori();
            $totalFoods = count($kaloriModel->getAllFoodsMaster()); 

            // 3. Kirim ke View
            require 'views/dashboard/AdminDashboard.php';
        } else {
            // Dashboard User Biasa
            require 'views/dashboard/Dashboard.php';
        }
    }

    public function handleLogout() {
        session_unset();
        session_destroy();
        header("Location: index.php?action=login");
        exit;
    }

    public function showProfile() {
        $user_id = $_SESSION['user_id'];
        $user = $this->userModel->getUserById($user_id);
        require __DIR__ . '/../views/profile/Profile.php';
    }

    public function handleUpdateProfile() {
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            header("Location: index.php?action=profile");
            exit;
        }

        $user_id      = $_SESSION['user_id'];
        $username     = $_POST['username'];
        $email        = $_POST['email'];
        $new_password = $_POST['new_password'];

        $this->userModel->updateUserProfile($user_id, $username, $email);

        if (!empty($new_password) && strlen($new_password) >= 6) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $this->userModel->updateUserPassword($user_id, $hashed_password);
        }

        header("Location: index.php?action=profile&status=updated");
        exit;
    }

    public function updatePassword() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user_id      = $_SESSION['user_id'];
            $new_pass     = $_POST['new_password'];
            $confirm_pass = $_POST['confirm_password'];

            if ($new_pass === $confirm_pass && strlen($new_pass) >= 6) {
                $hashed_password = password_hash($new_pass, PASSWORD_DEFAULT);
                $this->userModel->updateUserPassword($user_id, $hashed_password);
            }
        }

        header("Location: index.php?action=profile&status=pass_updated");
        exit;
    }

}
?>
