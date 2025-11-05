<?php 

class BMI extends Model {
    protected $fillable = ['user_id', 'weight', 'height', 'bmi', 'category', 'target_bmi', 'target_weight'];
    public function user() {
        return $this->belongsTo(User::class);
    }
    public static function calculateBMI($weight, $height) {
        $bmi = $weight / (($height / 100) ** 2);
        $category = $bmi < 18.5 ? 'underweight' : ($bmi < 25 ? 'normal' : ($bmi < 30 ? 'overweight' : 'obese'));
        return ['bmi' => round($bmi, 2), 'category' => $category];
    }
    public static function calculateTargetWeight($targetBMI, $height) {
        return round($targetBMI * (($height / 100) ** 2), 2);
    }
}