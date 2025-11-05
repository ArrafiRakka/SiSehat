<?php 
class BMIController extends Controller {
    public function calculate(Request $request) {
        $calc = BMI::calculateBMI($request->weight, $request->height);
        $targetWeight = $request->target_bmi ? BMI::calculateTargetWeight($request->target_bmi, $request->height) : null;
        BMI::create([
            'user_id' => Auth::id(),
            'weight' => $request->weight,
            'height' => $request->height,
            'bmi' => $calc['bmi'],
            'category' => $calc['category'],
            'target_bmi' => $request->target_bmi,
            'target_weight' => $targetWeight,
        ]);
        return view('bmi.result', ['bmi' => $calc['bmi'], 'category' => $calc['category'], 'target_weight' => $targetWeight]);
    }
}