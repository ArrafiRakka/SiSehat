<link rel="stylesheet" href="public/css/consultation.css">
<link rel="stylesheet" href="public/css/consultationresult.css">

<?php include 'views/layouts/header.php'; ?>

<div class="result-wrapper">
    <div class="result-container">
        <!-- Header -->
        <div class="result-header">
            <h1 class="result-title">Ringkasan Hasil Konsultasi</h1>
        </div>

        <!-- Doctor Info Section -->
        <div class="result-section">
            <h2 class="section-title-result">Ahli Gizi</h2>
            <div class="doctor-result-card">
                <img src="https://ui-avatars.com/api/?name=Dr+Andina&background=2D9CDB&color=fff&size=100" 
                     alt="Doctor" 
                     class="doctor-result-img">
                <div class="doctor-result-info">
                    <h3 class="doctor-result-name">Dr. Andina Reti Sp.Gk</h3>
                    <p class="consultation-date">Tanggal Konsultasi: <?= date('d F Y') ?></p>
                    <p class="consultation-duration">Durasi Konsultasi: 25 Menit</p>
                </div>
                <button class="btn-download" onclick="downloadPDF()">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                    Unduh Ringkasan (PDF)
                </button>
            </div>
        </div>

        <!-- Evaluation Results -->
        <div class="result-section">
            <h2 class="section-title-result">Hasil Evaluasi</h2>
            <div class="evaluation-card">
                <ul class="evaluation-list">
                    <li><strong>BMI:</strong> 26.0 (kategori overweight ringan)</li>
                    <li><strong>Asupan harian:</strong> cenderung tinggi karbohidrat dan kurang sayur/buah</li>
                    <li><strong>Kebiasaan:</strong> sering melewatkan sarapan, makan malam setelah pukul 21:00</li>
                    <li><strong>Kondisi khusus:</strong> tidak ada alergi makanan atau riwayat penyakit kronis</li>
                </ul>
            </div>
        </div>

        <!-- Meal Plan Recommendation -->
        <div class="result-section">
            <h2 class="section-title-result">Rencana Gizi dan Pola Makan</h2>
            <div class="recommendation-card">
                <div class="recommendation-item">
                    <h4>1. Pola Makan Harian:</h4>
                    <ul>
                        <li><strong>Sarapan:</strong> oatmeal + telur rebus + buah potong</li>
                        <li><strong>Makan siang:</strong> nasi merah + ayam panggang + tumis sayur</li>
                        <li><strong>Makan malam:</strong> sup sayur + tempe kukus</li>
                        <li><strong>Snack sehat:</strong> kacang almond, yoghurt rendah lemak</li>
                    </ul>
                </div>

                <div class="recommendation-item">
                    <h4>2. Target Kalori:</h4>
                    <p>±1700 kkal/hari</p>
                </div>

                <div class="recommendation-item">
                    <h4>3. Jadwal Makan:</h4>
                    <p>3 kali makan utama + 2 snack sehat</p>
                </div>

                <div class="recommendation-item">
                    <h4>4. Minum air:</h4>
                    <p>minimal 2 liter per hari</p>
                </div>
            </div>
        </div>

        <!-- Physical Activity Recommendation -->
        <div class="result-section">
            <h2 class="section-title-result">Rekomendasi Aktivitas Fisik</h2>
            <div class="activity-card">
                <ul class="activity-list">
                    <li>Jalan cepat 30 menit per hari</li>
                    <li>Latihan ringan 3x seminggu (bodyweight workout / yoga)</li>
                </ul>
            </div>
        </div>

        <!-- Doctor Notes -->
        <div class="result-section">
            <h2 class="section-title-result">Catatan dari Ahli Gizi</h2>
            <div class="notes-card">
                <p class="notes-text">"Fokus pada konsistensi, bukan kecepatan hasil. Jangan lupa cukup tidur dan kelola stress, karena keduanya sangat berpengaruh pada metabolisme tubuh."</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="result-actions">
            <a href="index.php?action=mealplan" class="btn btn-primary btn-large">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 2v20M2 12h20"></path>
                </svg>
                Buat Meal Plan Baru
            </a>
            <a href="index.php?action=consultation" class="btn btn-secondary btn-large">
                Konsultasi Lagi
            </a>
            <a href="index.php?action=dashboard" class="btn btn-outline btn-large">
                Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>

<script>
function downloadPDF() {
    alert('Fitur download PDF akan segera tersedia!');
    // Implementasi download PDF bisa ditambahkan nanti
    // window.location.href = 'index.php?action=download_consultation_pdf&id=1';
}
</script>

<?php include 'views/layouts/footer.php'; ?>