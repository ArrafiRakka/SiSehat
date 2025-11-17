<?php
// controllers/AdminController.php

require_once 'models/Kalori.php';
// Jika nanti ada User Model, require juga di sini
require_once 'models/User.php'; 

class AdminController {
    
    private $kaloriModel;
    private $userModel;

    public function __construct() {
        // 1. Inisialisasi Model
        $this->kaloriModel = new Kalori();
        $this->userModel = new User();

        // 2. Cek Security (Wajib Admin)
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Jika bukan admin, tendang ke dashboard biasa
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: index.php?action=dashboard");
            exit;
        }
    }

    /**
     * Halaman Kelola User
     */
    public function handleUserManagement() {
        // --- LOGIKA HAPUS USER ---
        if (isset($_GET['delete_id'])) {
            $id = $_GET['delete_id'];
            
            // Cegah Admin menghapus dirinya sendiri (Opsional tapi penting)
            if ($id == $_SESSION['user_id']) {
                echo "<script>alert('Anda tidak bisa menghapus akun sendiri!'); window.location='index.php?action=admin_users';</script>";
                exit;
            }

            if ($this->userModel->deleteUser($id)) {
                header("Location: index.php?action=admin_users&status=deleted");
                exit;
            }
        }

        // --- AMBIL DATA ---
        $users = $this->userModel->getAllUsers();

        // Load View
        require 'views/admin/user_list.php';
    }

    /**
     * Halaman Kelola Makanan (CRUD)
     */
    public function handleFoodManagement() {
        // --- LOGIKA TAMBAH MAKANAN (POST) ---
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_food'])) {
            $name = trim($_POST['name']);
            $cal  = $_POST['calories'];
            $prot = $_POST['protein'];
            $carb = $_POST['carbs'];
            $fat  = $_POST['fats'];
            
            // Default image jika kosong
            $image = !empty($_POST['image']) ? $_POST['image'] : 'public/images/default-plate.jpg';

            // Panggil fungsi di Model (Pastikan method addFood ada di Kalori.php)
            if ($this->kaloriModel->addFood($name, $cal, $prot, $carb, $fat, $image)) {
                header("Location: index.php?action=admin_food&status=added");
                exit;
            }
        }

        // --- LOGIKA HAPUS MAKANAN (GET) ---
        if (isset($_GET['delete_id'])) {
            $id = $_GET['delete_id'];
            // Panggil fungsi delete di Model
            if ($this->kaloriModel->deleteFood($id)) {
                header("Location: index.php?action=admin_food&status=deleted");
                exit;
            }
        }

        // --- LOGIKA TAMPILKAN DATA (GET) ---
        // Ambil semua data makanan untuk ditampilkan di tabel
        $foods = $this->kaloriModel->getAllFoodsMaster();

        // Panggil View
        require 'views/admin/food_management.php';
    }

    /**
     * Halaman Kelola User (Opsional / Tahap Selanjutnya)
     */
    public function handleUserList() {
        // Contoh sederhana jika nanti mau buat list user
        // $users = $this->userModel->getAllUsers(); 
        // require 'views/admin/user_list.php';
        echo "Halaman Kelola User (Belum dibuat)";
    }

    public function handleFoodEdit() {
        $id = $_GET['id'] ?? 0;
        $food = $this->kaloriModel->getFoodById($id);

        if (!$food) {
            echo "Makanan tidak ditemukan!";
            exit;
        }

        // Jika Form Disubmit (POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $cal  = $_POST['calories'];
            $prot = $_POST['protein'];
            $carb = $_POST['carbs'];
            $fat  = $_POST['fats'];

            if ($this->kaloriModel->updateFood($id, $name, $cal, $prot, $carb, $fat)) {
                header("Location: index.php?action=admin_food&status=updated");
                exit;
            }
        }

        // Tampilkan View Edit
        require 'views/admin/food_edit.php';
    }
}
?>