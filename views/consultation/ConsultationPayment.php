<link rel="stylesheet" href="public/css/consultation.css">
<link rel="stylesheet" href="public/css/payment.css">

<?php include 'views/layouts/header.php'; ?>

<div class="payment-wrapper">
    <div class="payment-container">
        <h2 class="section-title">Pembayaran Konsultasi</h2>

        <?php
        // Ambil data nutritionist dari controller (sudah dari database)
        $nutritionist = $data['nutritionist'] ?? null;
        
        if (!$nutritionist) {
            echo '<div class="alert alert-danger">Data ahli gizi tidak ditemukan.</div>';
            echo '<a href="index.php?action=consultation" class="btn btn-secondary">Kembali ke Daftar Ahli Gizi</a>';
            include 'views/layouts/footer.php';
            exit;
        }
        ?>

        <div class="doctor-summary">
            <img src="<?= htmlspecialchars($nutritionist['img']) ?>" 
                 alt="<?= htmlspecialchars($nutritionist['name']) ?>" 
                 class="doctor-image">
            <div class="doctor-info">
                <h3><?= htmlspecialchars($nutritionist['name']) ?></h3>
                <p><strong>Kota:</strong> <?= htmlspecialchars($nutritionist['city']) ?></p>
                <p><strong>Pengalaman:</strong> <?= htmlspecialchars($nutritionist['experience']) ?></p>
                <p><strong>Spesialisasi:</strong> <?= htmlspecialchars($nutritionist['specialty']) ?></p>
                <p><strong>Rating:</strong> ⭐ <?= number_format($nutritionist['rating'], 1) ?> 
                   (<?= number_format($nutritionist['total_consultations']) ?> konsultasi)</p>
                <p class="price"><strong>Tarif Konsultasi:</strong> 
                   Rp <?= number_format($nutritionist['price'], 0, ',', '.') ?>,-</p>
            </div>
        </div>

        <form class="payment-form" action="index.php?action=consultation_process_payment" method="POST">
            <!-- Hidden input untuk ID nutritionist -->
            <input type="hidden" name="nutritionist_id" value="<?= htmlspecialchars($nutritionist['id']) ?>">
            
            <div class="form-group">
                <label for="payment_method" class="form-label">Metode Pembayaran <span style="color: red;">*</span></label>
                <select id="payment_method" name="payment_method" class="form-select" required>
                    <option value="">-- Pilih Metode Pembayaran --</option>
                    <option value="Transfer Bank">Transfer Bank (BCA, Mandiri, BNI)</option>
                    <option value="E-Wallet">E-Wallet (Gopay, OVO, DANA, ShopeePay)</option>
                    <option value="Kartu Kredit">Kartu Kredit / Debit</option>
                    <option value="QRIS">QRIS</option>
                    <option value="Virtual Account">Virtual Account</option>
                </select>
            </div>

            <div class="form-group">
                <label for="note" class="form-label">Catatan / Keluhan (Opsional)</label>
                <textarea id="note" 
                          name="note" 
                          class="form-textarea" 
                          rows="4" 
                          placeholder="Ceritakan keluhan atau tujuan konsultasi Anda. Contoh: Saya ingin konsultasi tentang program diet untuk menurunkan berat badan..."></textarea>
                <small class="form-text">Informasi ini akan membantu ahli gizi memahami kebutuhan Anda</small>
            </div>

            <div class="payment-summary">
                <div class="summary-item">
                    <span>Biaya Konsultasi:</span>
                    <span>Rp <?= number_format($nutritionist['price'], 0, ',', '.') ?>,-</span>
                </div>
                <div class="summary-item">
                    <span>Biaya Admin:</span>
                    <span>Rp 0,-</span>
                </div>
                <div class="summary-divider"></div>
                <div class="summary-item total">
                    <span><strong>Total Pembayaran:</strong></span>
                    <span><strong>Rp <?= number_format($nutritionist['price'], 0, ',', '.') ?>,-</strong></span>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-payment">
                    <i class="fas fa-credit-card"></i> Bayar & Mulai Konsultasi
                </button>

                <a href="index.php?action=consultation" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

        </form>

        <div class="payment-info">
            <h4>ℹ️ Informasi Pembayaran</h4>
            <ul>
                <li>Pembayaran bersifat satu kali untuk satu sesi konsultasi</li>
                <li>Setelah pembayaran, Anda akan langsung terhubung dengan ahli gizi</li>
                <li>Konsultasi berlangsung melalui chat online</li>
                <li>Anda akan mendapatkan rekomendasi menu dan program gizi personal</li>
                <li>Hasil konsultasi dapat diakses kapan saja di menu Riwayat</li>
            </ul>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>