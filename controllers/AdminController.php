<?php
// controllers/AdminController.php

require_once 'models/Kalori.php';
require_once 'models/User.php'; 
require_once 'models/WorkoutModel.php';
require_once 'models/ConsultationModel.php';

class AdminController {
    
    private $kaloriModel;
    private $userModel;
    private $workoutModel;
    private $consultationModel;

    public function __construct() {
        // 1. Inisialisasi Model
        $this->kaloriModel = new Kalori();
        $this->userModel = new User();
        $this->workoutModel = new WorkoutModel();
        $this->consultationModel = new ConsultationModel();

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
     * Halaman Dashboard Admin
     */
    public function handleDashboard() {
        // Ambil total users
        $totalUsers = $this->userModel->getTotalUsers();
        
        // Ambil statistik konsultasi
        $consultationStats = $this->consultationModel->getConsultationStats();
        
        // Load View Dashboard
        require 'views/admin/dashboard.php';
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
     * Halaman Edit Makanan
     */
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

    /**
     * Halaman Kelola Workout
     */
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

    /**
     * Halaman Edit Workout
     */
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

    /**
     * Halaman Kelola Konsultasi - List Semua Konsultasi
     */
    public function handleConsultationManagement() {
        // Filter berdasarkan status (opsional)
        $status = $_GET['status_filter'] ?? 'all';
        
        // Ambil semua konsultasi dengan detail
        $consultations = $this->consultationModel->getAllConsultationsForAdmin($status);
        
        // Load View
        require 'views/admin/consultation_management.php';
    }

    /**
     * Detail Konsultasi Spesifik
     */
    public function handleConsultationDetail() {
        $id = $_GET['id'] ?? 0;
        
        if (!$id) {
            header("Location: index.php?action=admin_consultations");
            exit;
        }
        
        // Ambil detail lengkap konsultasi
        $consultation = $this->consultationModel->getConsultationById($id);
        
        if (!$consultation) {
            echo "Konsultasi tidak ditemukan!";
            exit;
        }
        
        // Ambil pesan-pesan chat
        $messages = $this->consultationModel->getMessages($id);
        
        // Ambil hasil konsultasi (jika ada)
        $result = $this->consultationModel->getConsultationResult($id);
        
        // Load View
        require 'views/admin/consultation_detail.php';
    }

    /**
     * Halaman Kelola Ahli Gizi (CRUD)
     */
    public function handleNutritionistManagement() {
        // --- LOGIKA TAMBAH AHLI GIZI (POST) ---
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_nutritionist'])) {
            $name = trim($_POST['name']);
            $specialty = trim($_POST['specialty']);
            $city = trim($_POST['city']);
            $experience = (int)$_POST['experience'];
            $price = (float)$_POST['price'];
            $gender = $_POST['gender'];
            $img = !empty($_POST['img']) ? $_POST['img'] : 'public/images/default-doctor.jpg';
            
            if ($this->consultationModel->addNutritionist($name, $specialty, $city, $experience, $price, $gender, $img)) {
                header("Location: index.php?action=admin_nutritionists&status=added");
                exit;
            }
        }
        
        // --- LOGIKA HAPUS AHLI GIZI (GET) ---
        if (isset($_GET['delete_id'])) {
            $id = (int)$_GET['delete_id'];
            
            // Cek apakah masih ada konsultasi aktif
            $activeCount = $this->consultationModel->countActiveConsultationsByNutritionist($id);
            
            if ($activeCount > 0) {
                echo "<script>alert('Tidak bisa menghapus ahli gizi yang masih memiliki konsultasi aktif!'); window.location='index.php?action=admin_nutritionists';</script>";
                exit;
            }
            
            if ($this->consultationModel->deleteNutritionist($id)) {
                header("Location: index.php?action=admin_nutritionists&status=deleted");
                exit;
            }
        }
        
        // --- AMBIL DATA ---
        $nutritionists = $this->consultationModel->getAllNutritionists();
        
        // Load View
        require 'views/admin/nutritionist_management.php';
    }

    /**
     * Edit Ahli Gizi
     */
    public function handleNutritionistEdit() {
        $id = (int)($_GET['id'] ?? 0);
        $nutritionist = $this->consultationModel->getNutritionistById($id);
        
        if (!$nutritionist) {
            echo "Ahli gizi tidak ditemukan!";
            exit;
        }
        
        // Jika Form Disubmit (POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_nutritionist'])) {
            $name = trim($_POST['name']);
            $specialty = trim($_POST['specialty']);
            $city = trim($_POST['city']);
            $experience = (int)$_POST['experience'];
            $price = (float)$_POST['price'];
            $gender = $_POST['gender'];
            $img = !empty($_POST['img']) ? $_POST['img'] : $nutritionist['img'];
            
            if ($this->consultationModel->updateNutritionist($id, $name, $specialty, $city, $experience, $price, $gender, $img)) {
                header("Location: index.php?action=admin_nutritionists&status=updated");
                exit;
            } else {
                $error = "Gagal mengupdate ahli gizi.";
            }
        }
        
        require 'views/admin/nutritionist_edit.php';
    }

    /**
     * Update Status Konsultasi (AJAX atau GET)
     */
    public function handleConsultationUpdateStatus() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['consultation_id'] ?? 0;
            $newStatus = $_POST['new_status'] ?? '';
            
            if ($id && in_array($newStatus, ['pending', 'active', 'completed', 'cancelled'])) {
                if ($this->consultationModel->updateConsultationStatus($id, $newStatus)) {
                    echo json_encode(['success' => true, 'message' => 'Status berhasil diupdate']);
                    exit;
                }
            }
            echo json_encode(['success' => false, 'message' => 'Gagal update status']);
            exit;
        }
    }
}
?>