<?php
// File: views/dashboard/BMICalculator.php
// Konten ini akan dimuat di antara header.php dan footer.php
?>

<div class="bmi-container">
    <h2>BMI Calculator</h2>
    <p class="subtitle">Calculate your Body Mass Index quickly and easily</p>

    <form class="bmi-form" action="index.php?action=bmi" method="POST">
        <div class="form-group-bmi">
            <label for="weight">Weight (kg)</label>
            <input type="number" id="weight" name="weight" placeholder="Enter your weight" step="0.1" required>
        </div>
        
        <div class="form-group-bmi">
            <label for="height">Height (cm)</label>
            <input type="number" id="height" name="height" placeholder="Enter your height" step="0.1" required>
        </div>
        
        <button type="submit" class="btn-calculate">
            Calculate BMI
        </button>
    </form>

    <?php if (isset($bmi_score) && $bmi_score !== null): ?>
        <div class="bmi-result">
            <h3>Hasil BMI Anda:</h3>
            <p class="score <?php echo strtolower($bmi_category); ?>">
                <?php echo htmlspecialchars($bmi_score); ?>
            </p>
            <p class="category">
                Kategori Anda: <strong><?php echo htmlspecialchars($bmi_category); ?></strong>
            </p>
        </div>
    <?php endif; ?>
    
    <div class="bmi-legend">
        <div class="legend-item">
            <span class="dot underweight"></span>
            <p><strong>Underweight</strong><br>&lt; 18.5</p>
        </div>
        <div class="legend-item">
            <span class="dot normal"></span>
            <p><strong>Normal</strong><br>18.5 - 24.9</p>
        </div>
        <div class="legend-item">
            <span class="dot overweight"></span>
            <p><strong>Overweight</strong><br>25 - 29.9</p>
        </div>
        <div class="legend-item">
            <span class="dot obese"></span>
            <p><strong>Obese</strong><br>&gt;= 30</p>
        </div>
    </div>
</div>