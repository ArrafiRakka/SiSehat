<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/ConsultationModel.php';

class ConsultationController extends Controller {
    private $model;

    public function __construct() {
        $this->model = new ConsultationModel();
    }

    // Halaman daftar ahli gizi
    public function index() {
        $data = [
            'pageTitle' => 'Konsultasi',
            'nutritionists' => $this->model->getAllNutritionists()
        ];
        $this->loadView('consultation/Consultation', $data);
    }

    // Halaman pembayaran
    public function payment() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nutritionistId = $_POST['doctor_id'] ?? null;
            
            if (!$nutritionistId) {
                header('Location: index.php?action=consultation');
                exit;
            }

            $nutritionist = $this->model->getNutritionistById($nutritionistId);
            
            if (!$nutritionist) {
                header('Location: index.php?action=consultation');
                exit;
            }

            $data = [
                'pageTitle' => 'Pembayaran Konsultasi',
                'nutritionist' => $nutritionist
            ];
            
            $this->loadView('consultation/ConsultationPayment', $data);
        } else {
            header('Location: index.php?action=consultation');
            exit;
        }
    }

    // Proses pembayaran dan buat konsultasi
    public function processPayment() {
        error_log("=== PROCESS PAYMENT DEBUG ===");
        error_log("Method: " . $_SERVER['REQUEST_METHOD']);
        error_log("POST Data: " . print_r($_POST, true));
        error_log("Session Data: " . print_r($_SESSION, true));
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_id'] ?? $_SESSION['id'] ?? null;
            
            if (!$userId) {
                error_log("User not logged in - redirecting to login");
                $_SESSION['error'] = 'Silakan login terlebih dahulu';
                header('Location: index.php?action=login');
                exit;
            }
            
            error_log("User ID found: " . $userId);

            $nutritionistId = $_POST['nutritionist_id'] ?? null;
            $paymentMethod = $_POST['payment_method'] ?? null;
            $note = $_POST['note'] ?? '';
            
            error_log("Nutritionist ID: " . $nutritionistId);
            error_log("Payment Method: " . $paymentMethod);

            if (!$nutritionistId) {
                error_log("Nutritionist ID missing");
                $_SESSION['error'] = 'ID ahli gizi tidak ditemukan';
                header('Location: index.php?action=consultation');
                exit;
            }

            if (!$paymentMethod) {
                error_log("Payment method missing");
                $_SESSION['error'] = 'Silakan pilih metode pembayaran';
                header('Location: index.php?action=consultation_payment');
                exit;
            }

            $nutritionist = $this->model->getNutritionistById($nutritionistId);
            error_log("Nutritionist data: " . print_r($nutritionist, true));
            
            if (!$nutritionist) {
                error_log("Nutritionist not found in database");
                $_SESSION['error'] = 'Ahli gizi tidak ditemukan';
                header('Location: index.php?action=consultation');
                exit;
            }

            $consultationData = [
                'user_id' => $userId,
                'nutritionist_id' => $nutritionistId,
                'payment_method' => $paymentMethod,
                'note' => $note,
                'price' => $nutritionist['price']
            ];
            
            error_log("Consultation data to save: " . print_r($consultationData, true));

            $consultationId = $this->model->createConsultation($consultationData);
            error_log("Consultation ID created: " . $consultationId);

            if ($consultationId) {
                $this->model->incrementNutritionistConsultations($nutritionistId);
                $this->model->updateConsultationStatus($consultationId, 'active');

                $_SESSION['success'] = 'Pembayaran berhasil! Konsultasi Anda sedang aktif.';
                error_log("Success! Redirecting to chat with ID: " . $consultationId);
                header('Location: index.php?action=consultation_chat&id=' . $consultationId);
                exit;
            } else {
                error_log("Failed to create consultation");
                $_SESSION['error'] = 'Gagal membuat konsultasi. Silakan coba lagi.';
                header('Location: index.php?action=consultation');
                exit;
            }
        } else {
            error_log("Not a POST request - redirecting");
            header('Location: index.php?action=consultation');
            exit;
        }
    }

    // Halaman chat konsultasi - FIXED: Kirim consultation_id ke view
    public function chat() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $consultationId = $_GET['id'] ?? null;
        
        if (!$consultationId) {
            header('Location: index.php?action=consultation');
            exit;
        }

        $consultation = $this->model->getConsultationById($consultationId);
        
        if (!$consultation || $consultation['user_id'] != $_SESSION['user_id']) {
            $_SESSION['error'] = 'Akses ditolak';
            header('Location: index.php?action=consultation');
            exit;
        }

        $messages = $this->model->getMessages($consultationId);

        // PERBAIKAN: Kirim consultation_id ke view
        $data = [
            'pageTitle' => 'Chat Konsultasi',
            'consultation' => $consultation,
            'messages' => $messages,
            'consultation_id' => $consultationId  // TAMBAHKAN INI
        ];
        
        $this->loadView('consultation/ConsultationChat', $data);
    }

    // Kirim pesan chat (AJAX)
    public function sendMessage() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
            $consultationId = $_POST['consultation_id'] ?? null;
            $message = trim($_POST['message'] ?? '');

            if (!$consultationId || !$message) {
                echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
                exit;
            }

            $consultation = $this->model->getConsultationById($consultationId);
            
            if (!$consultation || $consultation['user_id'] != $_SESSION['user_id']) {
                echo json_encode(['success' => false, 'message' => 'Akses ditolak']);
                exit;
            }

            $result = $this->model->saveMessage($consultationId, 'user', $message);
            
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Pesan terkirim']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Gagal mengirim pesan']);
            }
            exit;
        }
    }

    // Halaman hasil konsultasi
    public function result() {
        // Cek dua kemungkinan key session
        $userId = $_SESSION['user_id'] ?? $_SESSION['id'] ?? null;
        
        if (!$userId) {
            header('Location: index.php?action=login');
            exit;
        }

        $consultationId = $_GET['id'] ?? null;
        
        if (!$consultationId) {
            $_SESSION['error'] = 'ID Konsultasi tidak ditemukan.';
            header('Location: index.php?action=consultation_history');
            exit;
        }

        // Coba ambil hasil konsultasi dari database
        $result = $this->model->getConsultationResultAndDetails($consultationId, $userId); 
        
        // Jika tidak ada hasil, tetap tampilkan halaman dengan dummy data
        // View akan handle jika result null
        $data = [
            'pageTitle' => 'Hasil Konsultasi',
            'result' => $result,
            'consultation_id' => $consultationId
        ];
        
        $this->loadView('consultation/ConsultationResult', $data);
    }

    // Daftar riwayat konsultasi user
    public function history() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $consultations = $this->model->getConsultationsByUserId($_SESSION['user_id']);

        $data = [
            'pageTitle' => 'Riwayat Konsultasi',
            'consultations' => $consultations
        ];
        
        $this->loadView('consultation/ConsultationHistory', $data);
    }

    // Akhiri Konsultasi (Dipanggil via AJAX)
    public function endConsultation() {
        // Set header JSON di awal
        header('Content-Type: application/json');
        
        // Log untuk debugging
        error_log("=== END CONSULTATION DEBUG ===");
        error_log("Method: " . $_SERVER['REQUEST_METHOD']);
        error_log("Session: " . print_r($_SESSION, true));
        
        // Validasi request method dan session
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Method tidak diizinkan.']);
            exit;
        }
        
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Sesi berakhir, silakan login kembali.']);
            exit;
        }

        // Ambil input JSON
        $input = file_get_contents('php://input');
        error_log("Raw input: " . $input);
        
        $data = json_decode($input, true);
        error_log("Decoded data: " . print_r($data, true));
        
        $consultationId = $data['consultation_id'] ?? null;
        $userId = $_SESSION['user_id'];
        
        error_log("Consultation ID: " . $consultationId);
        error_log("User ID: " . $userId);

        if (!$consultationId) {
            echo json_encode(['success' => false, 'message' => 'ID Konsultasi tidak ditemukan.']);
            exit;
        }

        // Ambil data konsultasi
        $consultation = $this->model->getConsultationById($consultationId);
        error_log("Consultation data: " . print_r($consultation, true));
        
        if (!$consultation) {
            echo json_encode(['success' => false, 'message' => 'Konsultasi tidak ditemukan.']);
            exit;
        }
        
        if ($consultation['user_id'] != $userId) {
            echo json_encode(['success' => false, 'message' => 'Akses ditolak.']);
            exit;
        }
        
        if ($consultation['status'] !== 'active') {
            echo json_encode(['success' => false, 'message' => 'Konsultasi sudah berakhir atau belum dimulai.']);
            exit;
        }
        
        // Hitung durasi - PERBAIKAN: Cek apakah start_time ada
        $duration = 0;
        if (!empty($consultation['start_time'])) {
            try {
                $startTime = new DateTime($consultation['start_time']);
                $endTime = new DateTime();
                $duration = $startTime->diff($endTime)->i; // dalam menit
            } catch (Exception $e) {
                error_log("Error calculating duration: " . $e->getMessage());
            }
        }

        $updateData = [
            'status' => 'completed',
            'end_time' => date('Y-m-d H:i:s'), 
            'duration_minutes' => $duration
        ];
        
        error_log("Update data: " . print_r($updateData, true));
        
        // Update database
        $updateSuccess = $this->model->updateConsultationFields($consultationId, $updateData);
        error_log("Update success: " . ($updateSuccess ? 'yes' : 'no'));
        
        if ($updateSuccess) {
            echo json_encode([
                'success' => true, 
                'message' => 'Konsultasi berhasil diakhiri.',
                'consultation_id' => $consultationId 
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal memperbarui status di database.']);
        }
        exit;
    }

    // Method testing (HAPUS setelah selesai debugging)
    public function endConsultationTest() {
        $consultationId = $_GET['id'] ?? null;
        if (!$consultationId) {
            $_SESSION['error'] = "TEST GAGAL: ID tidak terbaca dari GET.";
            header('Location: index.php?action=consultation');
            exit;
        }
        header('Location: index.php?action=consultation_result&id=' . $consultationId);
        exit;
    }
}
?>