<?php
require_once 'models/WorkoutModel.php';

class WorkoutController {
    private $model;

    public function __construct() {
        $this->model = new WorkoutModel();
    }

    public function index() {
        $workouts = $this->model->getAllWorkouts();
        include 'views/workout/index.php';
    }

    public function calculate() {
        $workouts = $this->model->getAllWorkouts();
        $result = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $workoutName = $_POST['workout'];
            $duration = (float) $_POST['duration'];
            $weight = (float) $_POST['weight'];

            $met = $this->model->getMetValue($workoutName);

            if ($met && $duration > 0 && $weight > 0) {
                // Rumus: Kalori = MET × Berat Badan (kg) × Durasi (jam)
                $result = $met * $weight * ($duration / 60);
            }
        }

        include 'views/workout/index.php';
    }
}
?>
