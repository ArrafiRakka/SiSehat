<div class="payment-container">
    <h2 class="section-title">Pembayaran Konsultasi</h2>

    <?php if ($nutritionist): ?>
        <div class="doctor-summary">
            <img src="<?= $nutritionist['img'] ?>" alt="<?= $nutritionist['name'] ?>">
            <div class="info">
                <h3><?= $nutritionist['name'] ?></h3>
                <p>Kota: <?= $nutritionist['city'] ?></p>
                <p>Pengalaman: <?= $nutritionist['exp'] ?></p>
                <p class="price">Tarif: Rp <?= number_format($nutritionist['price'], 0, ',', '.') ?>,-</p>
            </div>
        </div>
    <?php endif; ?>

    <form class="payment-form" action="index.php?action=konsultasi_chat" method="POST">
        <label for="method">Metode Pembayaran</label>
        <select id="method" name="method" required>
            <option value="">-- Pilih Metode --</option>
            <option>Transfer Bank</option>
            <option>E-Wallet (Gopay, OVO, DANA)</option>
            <option>Kartu Kredit / Debit</option>
        </select>

        <label for="note">Catatan Tambahan (Opsional)</label>
        <textarea id="note" name="note" rows="3" placeholder="Contoh: Saya ingin konsultasi tentang berat badan ideal..."></textarea>

        <button type="submit" class="btn btn-primary">Lanjutkan ke Chat</button>
    </form>
</div>
