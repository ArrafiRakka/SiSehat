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
        // ⚠️ Ubah layout jadi NULL supaya gak cuma muncul header doang
        $this->loadView('consultation/Consultation', $data);
    }

    public function payment() {
        $id = $_GET['id'] ?? 1;
        $nutritionist = $this->model->getNutritionistById($id);

        $data = [
            'pageTitle' => 'Pembayaran Konsultasi',
            'nutritionist' => $nutritionist
        ];
        $this->loadView('consultation/ConsultationPayment', $data);
    }

    public function chat() {
        $data = ['pageTitle' => 'Chat Konsultasi'];
        $this->loadView('consultation/ConsultationChat', $data);
    }

    public function result() {
        $result = $this->model->getConsultationResult(1); // dummy userId
        $data = [
            'pageTitle' => 'Hasil Konsultasi',
            'result' => $result
        ];
        $this->loadView('consultation/ConsultationResult', $data);
    }
}
?>
