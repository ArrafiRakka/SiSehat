<?php include 'views/layouts/header.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Konsultasi #<?= $consultation['id'] ?> - Admin</title>
    <link rel="stylesheet" href="public/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <main class="main-content">
            
            <a href="index.php?action=admin_consultations" class="btn-back">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Kembali
            </a>
            
            <header>
                <h1>🔍 Detail Konsultasi #<?= $consultation['id'] ?></h1>
            </header>

            <div class="detail-grid">
                
                <div class="info-box">
                    <h3>👤 Informasi User</h3>
                    <div class="info-item">
                        <label>Nama:</label>
                        <span><?= htmlspecialchars($consultation['username']) ?></span>
                    </div>
                    <div class="info-item">
                        <label>Email:</label>
                        <span><?= htmlspecialchars($consultation['email']) ?></span>
                    </div>
                    <div class="info-item">
                        <label>ID User:</label>
                        <span>#<?= $consultation['user_id'] ?></span>
                    </div>
                </div>

                <div class="info-box">
                    <h3>👨‍⚕️ Informasi Ahli Gizi</h3>
                    <div class="info-item">
                        <label>Nama:</label>
                        <span><?= htmlspecialchars($consultation['nutritionist_name']) ?></span>
                    </div>
                    <div class="info-item">
                        <label>Spesialisasi:</label>
                        <span><?= htmlspecialchars($consultation['specialty']) ?></span>
                    </div>
                    <div class="info-item">
                        <label>Kota:</label>
                        <span><?= htmlspecialchars($consultation['city']) ?></span>
                    </div>
                </div>

                <div class="info-box">
                    <h3>📋 Detail Konsultasi</h3>
                    <div class="info-item">
                        <label>Status:</label>
                        <span class="status-badge status-<?= strtolower($consultation['status']) ?>">
                            <?= strtoupper($consultation['status']) ?>
                        </span>
                    </div>
                    <div class="info-item">
                        <label>Harga:</label>
                        <span>Rp <?= number_format($consultation['price'], 0, ',', '.') ?></span>
                    </div>
                    <div class="info-item">
                        <label>Metode Bayar:</label>
                        <span><?= htmlspecialchars($consultation['payment_method']) ?></span>
                    </div>
                    <div class="info-item">
                        <label>Catatan User:</label>
                        <p style="white-space: pre-wrap; text-align: right;"><?= htmlspecialchars($consultation['note'] ?? '-') ?></p>
                    </div>
                </div>

                <div class="info-box">
                    <h3>⏰ Waktu & Durasi</h3>
                    <div class="info-item">
                        <label>Dibuat:</label>
                        <span><?= date('d/m/Y H:i', strtotime($consultation['created_at'])) ?></span>
                    </div>
                    <div class="info-item">
                        <label>Mulai:</label>
                        <span><?= $consultation['start_time'] ? date('d/m/Y H:i', strtotime($consultation['start_time'])) : '-' ?></span>
                    </div>
                    <div class="info-item">
                        <label>Selesai:</label>
                        <span><?= $consultation['end_time'] ? date('d/m/Y H:i', strtotime($consultation['end_time'])) : '-' ?></span>
                    </div>
                    <div class="info-item">
                        <label>Durasi:</label>
                        <span><?= $consultation['duration_minutes'] ? $consultation['duration_minutes'] . ' menit' : '-' ?></span>
                    </div>
                </div>
            </div>

            <hr>

            <div class="card">
                <h3>💬 Riwayat Percakapan</h3>
                <div class="chat-history">
                    <?php if(empty($messages)): ?>
                        <p style="text-align: center; color: #999; padding: 30px;">Belum ada percakapan.</p>
                    <?php else: ?>
                        <?php foreach($messages as $msg): ?>
                            <div class="message <?= htmlspecialchars($msg['sender_type']) ?>">
                                <div class="sender">
                                    <?= $msg['sender_type'] === 'user' ? '👤 User' : '👨‍⚕️ Ahli Gizi' ?>
                                </div>
                                <div class="content">
                                    <?= nl2br(htmlspecialchars($msg['message'])) ?>
                                </div>
                                <div class="time">
                                    <?= date('d/m/Y H:i:s', strtotime($msg['created_at'])) ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <hr>

            <?php if(isset($result) && $result): ?>
                <div class="card">
                    <h3>📊 Hasil Konsultasi</h3>
                    <div class="detail-grid">
                        
                        <div class="info-box">
                            <h4>🎯 Target & Evaluasi</h4>
                            <div class="info-item">
                                <label>BMI:</label>
                                <span><?= $result['bmi'] ?> (<?= $result['bmi_category'] ?>)</span>
                            </div>
                            <div class="info-item">
                                <label>Target Kalori:</label>
                                <span><?= $result['target_calories'] ?> kal/hari</span>
                            </div>
                            <div class="info-item">
                                <label>Frekuensi Makan:</label>
                                <span><?= $result['meal_frequency'] ?>x sehari</span>
                            </div>
                            <div class="info-item">
                                <label>Air Minum:</label>
                                <span><?= $result['water_intake'] ?> gelas/hari</span>
                            </div>
                            <div class="info-item" style="display: block;">
                                <label style="display: block; text-align: left; margin-bottom: 5px;">Aktivitas Fisik:</label>
                                <p style="white-space: pre-wrap; text-align: left;"><?= nl2br(htmlspecialchars($result['physical_activity'] ?? '-')) ?></p>
                            </div>
                        </div>

                        <div class="info-box">
                            <h4>🍽️ Rencana Makan Harian</h4>
                            <div class="info-item">
                                <label>Sarapan:</label>
                                <span><?= htmlspecialchars($result['meal_plan_breakfast']) ?></span>
                            </div>
                            <div class="info-item">
                                <label>Makan Siang:</label>
                                <span><?= htmlspecialchars($result['meal_plan_lunch']) ?></span>
                            </div>
                            <div class="info-item">
                                <label>Makan Malam:</label>
                                <span><?= htmlspecialchars($result['meal_plan_dinner']) ?></span>
                            </div>
                            <div class="info-item">
                                <label>Snack:</label>
                                <span><?= htmlspecialchars($result['meal_plan_snacks']) ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="info-box" style="margin-top: 25px;">
                        <h4>📝 Catatan Ahli Gizi</h4>
                        <p style="white-space: pre-wrap; text-align: left;"><?= nl2br(htmlspecialchars($result['doctor_notes'])) ?></p>
                    </div>
                </div>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>

<?php include 'views/layouts/footer.php'; ?>