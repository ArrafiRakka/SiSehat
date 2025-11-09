<?php
// controllers/AuthController.php

require_once 'models/User.php';

class AuthController {
    
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    /**
     * Menangani logika LOGIN (POST) dan tampilan (GET)
     */
    public function handleLogin() {
        $error = '';
        $success = '';

        // Cek jika ada pesan sukses dari registrasi
        if (isset($_GET['status']) && $_GET['status'] == 'sukses') {
            $success = "Registrasi berhasil! Silakan login.";
        }

        // Cek jika form disubmit
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email_or_username = trim($_POST['email_username']);
            $password = $_POST['password'];

            if (empty($email_or_username) || empty($password)) {
                $error = "Email/Username dan Password wajib diisi!";
            } else {
                $user = $this->userModel->getUserByEmailOrUsername($email_or_username);
                
                if ($user && password_verify($password, $user['password_hash'])) {
                    // Login sukses
                    $_SESSION['loggedin'] = true;
                    $_SESSION['username'] = $user['username'];
                    header("Location: index.php?action=dashboard");
                    exit;
                } else {
                    $error = "Email/Username atau Password salah!";
                }
            }
        }

        // Tampilkan view login
        // Variabel $error dan $success akan bisa diakses di dalam view
        require 'views/auth/Login.php';
    }

    /**
     * Menangani logika REGISTER (POST) dan tampilan (GET)
     */
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
                    // Sukses, arahkan ke login
                    header("Location: index.php?action=login&status=sukses");
                    exit;
                } else {
                    $error = "Email atau Username sudah terdaftar!";
                }
            }
        }

        // Tampilkan view register
        require 'views/auth/Register.php';
    }

    public function handleDashboard() {
    // Pastikan session aktif
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Kalau belum login, arahkan ke login page
    if (empty($_SESSION['loggedin'])) {
        header("Location: index.php?action=login");
        exit;
    }

    // Ambil data user dari session
    $username = $_SESSION['username'] ?? 'Guest';

    // Tampilkan view dashboard
    require 'views/dashboard/Dashboard.php';
}

}
?>