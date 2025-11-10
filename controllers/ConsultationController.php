<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/ConsultationModel.php';

class ConsultationController extends Controller {
    private $model;

    public function __construct() {
        $this->model = new ConsultationModel();
    }

    public function index() {
        $data = [
            'pageTitle' => 'Konsultasi',
            'nutritionists' => $this->model->getAllNutritionists()
        ];
        $this->loadView('consultation/Consultation', $data);
    }

    public function payment() {
        // PERBAIKI INI - Ambil dari POST, bukan GET
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Data dari form POST
            $data = [
                'pageTitle' => 'Pembayaran Konsultasi',
                'nutritionist' => [
                    'id' => $_POST['doctor_id'] ?? '1',
                    'name' => $_POST['doctor_name'] ?? 'Dr. Fitri Ananda, S.Gz',
                    'city' => $_POST['doctor_city'] ?? 'Jakarta',
                    'exp' => $_POST['doctor_experience'] ?? '5 Tahun',
                    'price' => $_POST['doctor_price'] ?? '25000',
                    'specialty' => $_POST['doctor_specialty'] ?? 'Gizi Klinis',
                ]
            ];
        } else {
            // Fallback jika akses langsung
            $id = $_GET['id'] ?? 1;
            $nutritionist = $this->model->getNutritionistById($id);
            $data = [
                'pageTitle' => 'Pembayaran Konsultasi',
                'nutritionist' => $nutritionist
            ];
        }
        
        $this->loadView('consultation/ConsultationPayment', $data);
    }

    public function chat() {
        $data = ['pageTitle' => 'Chat Konsultasi'];
        $this->loadView('consultation/ConsultationChat', $data);
    }

    public function result() {
        $result = $this->model->getConsultationResult(1);
        $data = [
            'pageTitle' => 'Hasil Konsultasi',
            'result' => $result
        ];
        $this->loadView('consultation/ConsultationResult', $data);
    }

}
?>
```

