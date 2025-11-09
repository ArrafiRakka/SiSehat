<div class="result-container">
    <h2 class="section-title">Ringkasan Hasil Konsultasi</h2>

    <?php if ($result): ?>
    <div class="doctor-card">
        <img src="public/assets/doctors/andina.jpg" alt="<?= $result['doctor'] ?>">
        <div class="info">
            <h3><?= $result['doctor'] ?></h3>
            <p>Tanggal Konsultasi: <?= date("d F Y", strtotime($result['date'])) ?></p>
            <p>Durasi: <?= $result['duration'] ?></p>
        </div>
        <a href="#" class="btn btn-outline">Unduh Ringkasan (PDF)</a>
    </div>

    <div class="section">
        <h4>📊 Hasil Evaluasi</h4>
        <ul>
            <li><strong>BMI:</strong> <?= $result['bmi'] ?></li>
            <li><strong>Masalah:</strong> <?= $result['problem'] ?></li>
            <li><strong>Catatan:</strong> <?= $result['note'] ?></li>
        </ul>
    </div>

    <div class="section">
        <h4>🥗 Rencana Gizi dan Pola Makan</h4>
        <ol>
            <?php foreach ($result['plan'] as $p): ?>
                <li><?= $p ?></li>
            <?php endforeach; ?>
        </ol>
    </div>

    <div class="section">
        <h4>🏃 Rekomendasi Aktivitas Fisik</h4>
        <p><?= $result['activity'] ?></p>
    </div>

    <div class="section">
        <h4>🩺 Catatan Ahli Gizi</h4>
        <p><?= $result['nutritionist_note'] ?></p>
    </div>
    <?php else: ?>
        <p>Belum ada hasil konsultasi untuk ditampilkan.</p>
    <?php endif; ?>
</div>
