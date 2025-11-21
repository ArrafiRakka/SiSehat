<?php
// controllers/AdminController.php

require_once 'models/Kalori.php';
// Jika nanti ada User Model, require juga di sini
require_once 'models/User.php'; 
require_once 'models/WorkoutModel.php';

class AdminController {
    
    private $kaloriModel;
    private $userModel;
    private $workoutModel;

    public function __construct() {
        // 1. Inisialisasi Model
        $this->kaloriModel = new Kalori();
        $this->userModel = new User();
        $this->workoutModel = new WorkoutModel();

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

    
    public function handleWorkoutManagement() {
        // --- LOGIKA TAMBAH WORKOUT (POST) ---
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_workout'])) {
            $key_slug = strtolower(str_replace(' ', '', trim($_POST['key_slug']))); // Clean slug
            $nama = trim($_POST['nama_workout']);
            $met = (float) $_POST['met_value'];
            $fokus_otot = trim($_POST['fokus_otot']);
            $tujuan_utama = trim($_POST['tujuan_utama']);

            if ($this->workoutModel->addWorkout($key_slug, $nama, $met, $fokus_otot, $tujuan_utama)) {
                header("Location: index.php?action=admin_workouts&status=added");
                exit;
            } else {
                $error = "Gagal menambahkan workout.";
            }
        }

        // --- LOGIKA HAPUS WORKOUT (Soft Delete via GET) ---
        if (isset($_GET['delete_id'])) {
            $id = (int)$_GET['delete_id'];
            if ($this->workoutModel->deleteWorkout($id)) {
                header("Location: index.php?action=admin_workouts&status=deleted");
                exit;
            } else {
                $error = "Gagal menghapus workout.";
            }
        }

        // --- LOGIKA TAMPILKAN DATA ---
        $workouts = $this->workoutModel->getAllAdminWorkouts();

        require 'views/admin/workout_management.php';
    }

public function handleWorkoutEdit() {
    $id = (int)($_GET['id'] ?? 0);
    $workout = $this->workoutModel->getWorkoutById($id);

    if (!$workout) {
        echo "Workout tidak ditemukan!";
        exit;
    }

    // Jika Form Disubmit (POST)
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_workout'])) {
        $key_slug = strtolower(str_replace(' ', '', trim($_POST['key_slug'])));
        $nama = trim($_POST['nama_workout']);
        $met = (float) $_POST['met_value'];
        $is_active = isset($_POST['is_active']) ? true : false;

        $fokus = trim($_POST['fokus_otot']);
        $tujuan = trim($_POST['tujuan_utama']);
        
        if ($this->workoutModel->updateWorkout($id, $key_slug, $nama, $met, $fokus, $tujuan, $is_active)) {
            header("Location: index.php?action=admin_workouts&status=updated");
            exit;
        } else {
            $error = "Gagal mengupdate workout.";
        }
    }
    
    require 'views/admin/workout_edit.php';
}

}
?>