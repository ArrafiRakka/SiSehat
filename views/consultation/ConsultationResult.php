<?php include 'views/layouts/header.php'; ?>

<link rel="stylesheet" href="public/css/consultationresult.css">

<?php
// Ambil data konsultasi dari controller
$consultationId = $data['consultation_id'] ?? $_GET['id'] ?? null;
$userId = $_SESSION['user_id'] ?? $_SESSION['id'] ?? null;

// Untuk testing, buat dummy data jika belum ada hasil konsultasi
$consultation = $data['result'] ?? null;

// Jika tidak ada data, gunakan dummy
if (!$consultation && $consultationId) {
    // Ambil info konsultasi dari database untuk info dokter
    require_once __DIR__ . '/../../models/ConsultationModel.php';
    $model = new ConsultationModel();
    $consultationData = $model->getConsultationById($consultationId);
    
    if (!$consultationData) {
        echo '<div class="result-wrapper"><div class="result-container">';
        echo '<div class="result-card"><div class="result-card-body">';
        echo '<p style="text-align:center;color:#e74c3c;padding:40px;">Data konsultasi tidak ditemukan.</p>';
        echo '<div style="text-align:center;"><a href="index.php?action=consultation_history" class="btn-result btn-primary-result">Kembali ke Riwayat</a></div>';
        echo '</div></div></div></div>';
        include 'views/layouts/footer.php';
        exit;
    }
    
    // DUMMY DATA untuk testing
    $consultation = [
        'nutritionist_name' => $consultationData['nutritionist_name'],
        'specialty' => $consultationData['specialty'],
        'nutritionist_img' => $consultationData['img'],
        'start_time' => $consultationData['start_time'] ?? date('Y-m-d H:i:s'),
        'duration_minutes' => 15,
        'bmi' => 22.5,
        'bmi_category' => 'Normal',
        'daily_intake_notes' => 'Pola makan Anda sudah cukup baik. Asupan karbohidrat, protein, dan lemak seimbang. Namun, perlu ditingkatkan konsumsi sayuran hijau dan buah-buahan untuk memenuhi kebutuhan vitamin dan mineral harian.',
        'habits_notes' => 'Aktivitas fisik masih kurang optimal. Anda baru berolahraga 2x seminggu. Disarankan untuk meningkatkan menjadi minimal 3-4x seminggu dengan durasi 30-45 menit per sesi.',
        'special_conditions' => 'Tidak ada kondisi kesehatan khusus yang perlu perhatian. Hasil pemeriksaan menunjukkan kondisi tubuh dalam keadaan baik.',
        'meal_plan_breakfast' => 'Oatmeal dengan susu rendah lemak, 1 buah pisang, dan 1 sdm kacang almond',
        'meal_plan_lunch' => 'Nasi merah 1 porsi (150g), ayam panggang tanpa kulit (100g), tumis brokoli dan wortel, tempe goreng',
        'meal_plan_dinner' => 'Ikan salmon panggang (120g), kentang rebus (100g), salad sayuran dengan olive oil, 1 gelas jus jeruk',
        'meal_plan_snacks' => 'Yogurt rendah lemak dengan granola, atau buah apel/pisang, atau kacang-kacangan panggang (30g)',
        'target_calories' => 2000,
        'meal_frequency' => '3x makan utama + 2x snack',
        'water_intake' => '8-10 gelas per hari (2-2.5 liter)',
        'physical_activity' => 'Jogging atau bersepeda 30-45 menit, 4x seminggu',
        'doctor_notes' => 'Kondisi kesehatan Anda saat ini baik. Pertahankan pola makan sehat dan tingkatkan aktivitas fisik. Konsumsi air putih yang cukup dan istirahat 7-8 jam per hari. Konsultasi kembali dalam 1 bulan untuk evaluasi progress.'
    ];
}

// Get initials for avatar
$nameParts = explode(' ', $consultation['nutritionist_name']);
$initials = '';
foreach ($nameParts as $part) {
    if (!empty($part)) {
        $initials .= strtoupper($part[0]);
        if (strlen($initials) >= 2) break;
    }
}

// BMI Category Class
$bmiClass = 'bmi-normal';
$bmiCategoryLower = strtolower($consultation['bmi_category'] ?? 'normal');
if (strpos($bmiCategoryLower, 'underweight') !== false || strpos($bmiCategoryLower, 'kurus') !== false) {
    $bmiClass = 'bmi-underweight';
} elseif (strpos($bmiCategoryLower, 'overweight') !== false || strpos($bmiCategoryLower, 'gemuk') !== false) {
    $bmiClass = 'bmi-overweight';
} elseif (strpos($bmiCategoryLower, 'obese') !== false || strpos($bmiCategoryLower, 'obesitas') !== false) {
    $bmiClass = 'bmi-obese';
}
?>

<div class="result-wrapper">
    <div class="result-header">
        <div class="result-header-content">
            <a href="index.php?action=consultation_history" class="btn-back-result">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Kembali ke Riwayat
            </a>
            <h1 class="result-title">📊 Hasil Konsultasi</h1>
            <p class="result-subtitle">Rekomendasi kesehatan dari ahli gizi profesional</p>
        </div>
    </div>

    <div class="result-container">
        <!-- Doctor Info -->
        <div class="result-card">
            <div class="result-card-header">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                <h2>Informasi Konsultasi</h2>
            </div>
            <div class="result-card-body">
                <div class="doctor-info-result">
                    <div class="doctor-avatar-result"><?= $initials ?></div>
                    <div class="doctor-info-details">
                        <h3><?= htmlspecialchars($consultation['nutritionist_name']) ?></h3>
                        <p><?= htmlspecialchars($consultation['specialty']) ?></p>
                    </div>
                </div>
                
                <div class="info-grid-result">
                    <div class="info-item-result">
                        <div class="info-label-result">📅 Waktu Konsultasi</div>
                        <div class="info-value-result">
                            <?php
                            $start = new DateTime($consultation['start_time']);
                            echo $start->format('d M Y, H:i');
                            ?>
                        </div>
                    </div>
                    
                    <div class="info-item-result">
                        <div class="info-label-result">⏱️ Durasi</div>
                        <div class="info-value-result"><?= $consultation['duration_minutes'] ?> Menit</div>
                    </div>
                    
                    <div class="info-item-result">
                        <div class="info-label-result">✅ Status</div>
                        <div class="info-value-result">Selesai</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- BMI -->
        <div class="result-card card-blue">
            <div class="result-card-header">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                </svg>
                <h2>Indeks Massa Tubuh (BMI)</h2>
            </div>
            <div class="result-card-body">
                <div class="bmi-display">
                    <div class="bmi-circle">
                        <div class="bmi-value"><?= number_format($consultation['bmi'], 1) ?></div>
                        <div class="bmi-label">BMI</div>
                    </div>
                    <div class="bmi-category <?= $bmiClass ?>">
                        <?= htmlspecialchars($consultation['bmi_category']) ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Analisis -->
        <div class="result-card">
            <div class="result-card-header">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                </svg>
                <h2>Analisis Pola Makan Harian</h2>
            </div>
            <div class="result-card-body">
                <p class="result-text"><?= nl2br(htmlspecialchars($consultation['daily_intake_notes'])) ?></p>
            </div>
        </div>

        <!-- Kebiasaan -->
        <div class="result-card">
            <div class="result-card-header">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
                </svg>
                <h2>Kebiasaan & Gaya Hidup</h2>
            </div>
            <div class="result-card-body">
                <p class="result-text"><?= nl2br(htmlspecialchars($consultation['habits_notes'])) ?></p>
            </div>
        </div>

        <!-- Kondisi Khusus -->
        <?php if (!empty($consultation['special_conditions'])): ?>
        <div class="result-card">
            <div class="result-card-header">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                    <line x1="12" y1="9" x2="12" y2="13"></line>
                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                </svg>
                <h2>Kondisi Khusus</h2>
            </div>
            <div class="result-card-body">
                <p class="result-text"><?= nl2br(htmlspecialchars($consultation['special_conditions'])) ?></p>
            </div>
        </div>
        <?php endif; ?>

        <!-- Meal Plan -->
        <div class="result-card card-green">
            <div class="result-card-header">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 8h1a4 4 0 0 1 0 8h-1M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path>
                </svg>
                <h2>Rencana Makan yang Direkomendasikan</h2>
            </div>
            <div class="result-card-body">
                <div class="meal-plan-grid">
                    <div class="meal-item">
                        <div class="meal-icon">🌅</div>
                        <h3>Sarapan</h3>
                        <p><?= nl2br(htmlspecialchars($consultation['meal_plan_breakfast'])) ?></p>
                    </div>
                    
                    <div class="meal-item">
                        <div class="meal-icon">☀️</div>
                        <h3>Makan Siang</h3>
                        <p><?= nl2br(htmlspecialchars($consultation['meal_plan_lunch'])) ?></p>
                    </div>
                    
                    <div class="meal-item">
                        <div class="meal-icon">🌙</div>
                        <h3>Makan Malam</h3>
                        <p><?= nl2br(htmlspecialchars($consultation['meal_plan_dinner'])) ?></p>
                    </div>
                    
                    <div class="meal-item">
                        <div class="meal-icon">🍎</div>
                        <h3>Camilan</h3>
                        <p><?= nl2br(htmlspecialchars($consultation['meal_plan_snacks'])) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Target -->
        <div class="result-card">
            <div class="result-card-header">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M12 6v6l4 2"></path>
                </svg>
                <h2>Target & Rekomendasi Harian</h2>
            </div>
            <div class="result-card-body">
                <div class="target-grid">
                    <div class="target-item">
                        <div class="target-icon">🔥</div>
                        <div class="target-label">Target Kalori</div>
                        <div class="target-value"><?= number_format($consultation['target_calories']) ?> kkal</div>
                    </div>
                    
                    <div class="target-item">
                        <div class="target-icon">🍽️</div>
                        <div class="target-label">Frekuensi Makan</div>
                        <div class="target-value"><?= htmlspecialchars($consultation['meal_frequency']) ?></div>
                    </div>
                    
                    <div class="target-item">
                        <div class="target-icon">💧</div>
                        <div class="target-label">Konsumsi Air</div>
                        <div class="target-value"><?= htmlspecialchars($consultation['water_intake']) ?></div>
                    </div>
                    
                    <div class="target-item">
                        <div class="target-icon">🏃</div>
                        <div class="target-label">Aktivitas Fisik</div>
                        <div class="target-value"><?= htmlspecialchars($consultation['physical_activity']) ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Catatan Dokter -->
        <div class="result-card notes-card card-orange">
            <div class="result-card-header">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
                <h2>Catatan Ahli Gizi</h2>
            </div>
            <div class="result-card-body">
                <p class="result-text"><?= nl2br(htmlspecialchars($consultation['doctor_notes'])) ?></p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="result-actions">
            <a href="index.php?action=consultation_history" class="btn-result btn-secondary-result">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                </svg>
                Lihat Riwayat
            </a>
            <a href="index.php?action=consultation" class="btn-result btn-primary-result">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 5v14M5 12h14"/>
                </svg>
                Konsultasi Lagi
            </a>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>