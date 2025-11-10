<link rel="stylesheet" href="public/css/consultation.css">
<link rel="stylesheet" href="public/css/payment.css">

<?php include 'views/layouts/header.php'; ?>

<div class="payment-wrapper">
    <div class="payment-container">
        <h2 class="section-title">Pembayaran Konsultasi</h2>

        <?php
        // Ambil data dari POST atau data yang di-pass dari controller
        $nutritionist = [
            'id' => $_POST['doctor_id'] ?? $data['nutritionist']['id'] ?? '1',
            'name' => $_POST['doctor_name'] ?? $data['nutritionist']['name'] ?? 'Dr. Fitri Ananda, S.Gz',
            'city' => $_POST['doctor_city'] ?? $data['nutritionist']['city'] ?? 'Jakarta',
            'exp' => $_POST['doctor_experience'] ?? $data['nutritionist']['exp'] ?? '5 Tahun',
            'price' => $_POST['doctor_price'] ?? $data['nutritionist']['price'] ?? '25000',
            'specialty' => $_POST['doctor_specialty'] ?? $data['nutritionist']['specialty'] ?? 'Gizi Klinis',
            'img' => $_POST['doctor_img'] ?? $data['nutritionist']['img'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($_POST['doctor_name'] ?? $data['nutritionist']['name'] ?? 'Dr. Fitri Ananda') . '&background=2D9CDB&color=fff&size=100'
        ];
        ?>

        <?php if ($nutritionist): ?>
            <div class="doctor-summary">
                <img src="<?= $nutritionist['img'] ?>" alt="<?= $nutritionist['name'] ?>" class="doctor-image">
                <div class="doctor-info">
                    <h3><?= $nutritionist['name'] ?></h3>
                    <p><strong>Kota:</strong> <?= $nutritionist['city'] ?></p>
                    <p><strong>Pengalaman:</strong> <?= $nutritionist['exp'] ?></p>
                    <p><strong>Spesialisasi:</strong> <?= $nutritionist['specialty'] ?></p>
                    <p class="price"><strong>Tarif Konsultasi:</strong> Rp <?= number_format($nutritionist['price'], 0, ',', '.') ?>,-</p>
                </div>
            </div>
        <?php endif; ?>

        <form class="payment-form" action="index.php?action=consultation_chat" method="POST">
            <!-- Hidden inputs untuk pass data ke chat -->
            <input type="hidden" name="doctor_id" value="<?= $nutritionist['id'] ?>">
            <input type="hidden" name="doctor_name" value="<?= $nutritionist['name'] ?>">
            <input type="hidden" name="doctor_price" value="<?= $nutritionist['price'] ?>">
            <input type="hidden" name="doctor_img" value="<?= $nutritionist['img'] ?>">
            
            <div class="form-group">
                <label for="method" class="form-label">Metode Pembayaran</label>
                <select id="method" name="method" class="form-select" required>
                    <option value="">-- Pilih Metode Pembayaran --</option>
                    <option value="transfer_bank">Transfer Bank</option>
                    <option value="ewallet">E-Wallet (Gopay, OVO, DANA)</option>
                    <option value="kartu_kredit">Kartu Kredit / Debit</option>
                </select>
            </div>

            <div class="form-group">
                <label for="note" class="form-label">Catatan Tambahan (Opsional)</label>
                <textarea id="note" name="note" class="form-textarea" rows="3" placeholder="Contoh: Saya ingin konsultasi tentang berat badan ideal..."></textarea>
            </div>

            <div class="payment-summary">
                <div class="summary-item">
                    <span>Biaya Konsultasi:</span>
                    <span>Rp <?= number_format($nutritionist['price'], 0, ',', '.') ?>,-</span>
                </div>
                <div class="summary-item total">
                    <span><strong>Total Pembayaran:</strong></span>
                    <span><strong>Rp <?= number_format($nutritionist['price'], 0, ',', '.') ?>,-</strong></span>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-payment">Konfirmasi dan Lanjutkan ke Chat</button>
            <a href="index.php?action=consultation" class="btn btn-secondary">Kembali ke Daftar Ahli Gizi</a>
        </form>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>