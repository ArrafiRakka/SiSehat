<?php
class WorkoutModel {
    private $workouts = [
        ["name" => "Lari", "met" => 9.8],
        ["name" => "Bersepeda", "met" => 8.0],
        ["name" => "Renang", "met" => 7.0],
        ["name" => "Push-up", "met" => 3.8],
        ["name" => "Sit-up", "met" => 4.0],
        ["name" => "Yoga", "met" => 2.5],
        ["name" => "Angkat Beban", "met" => 6.0],
        ["name" => "Aerobik", "met" => 7.3],
        ["name" => "Zumba", "met" => 8.8],
        ["name" => "Jumping Jack", "met" => 9.5],
    ];

    public function getAllWorkouts() {
        return $workouts = $this->workouts;
    }

    public function getMetValue($name) {
        foreach ($this->workouts as $workout) {
            if ($workout['name'] === $name) {
                return $workout['met'];
            }
        }
        return null;
    }
}
?>
