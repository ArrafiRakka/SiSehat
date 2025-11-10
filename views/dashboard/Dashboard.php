<?php include 'views/layouts/header.php'; ?>

<div class="dashboard-container">

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-text">
            <h1>Kesehatan Terbaik untuk Hidup Anda</h1>
            <p>Program workout yang disesuaikan untuk kebutuhan Anda</p>
            <div class="hero-buttons">
                <a href="index.php?action=consultation" class="btn btn-primary">Mulai Konsultasi</a>
                <a href="#" class="btn btn-outline">Pelajari Lebih Lanjut</a>
            </div>
        </div>
        <div class="hero-card">
            <h2>Health Hero</h2>
        </div>
    </section>

    <!-- Features -->
    <section class="features">
        <h2>Fitur Pendukung Kesehatan Terpadu</h2>
        <p>Dapatkan akses ke berbagai layanan kesehatan berkualitas dalam satu platform</p>

        <div class="feature-grid">
            <div class="card">
                <img src="public/assets/icons/consult.svg" alt="">
                <h3>Konsultasi Online</h3>
                <p>Konsultasi langsung dengan ahli gizi dan dokter.</p>
                <a href="index.php?action=consultation">Pelajari Lebih Lanjut</a>
            </div>

            <div class="card">
                <img src="public/assets/icons/consult.svg" alt="">
                <h3>BMI</h3>
                <p>Coba Hitung BMI Anda.</p>
                <a href="index.php?action=bmi">Pelajari Lebih Lanjut</a>
            </div>

            <div class="card">
                <img src="public/assets/icons/workout.svg" alt="">
                <h3>Program Workout</h3>
                <p>Rencana latihan yang disesuaikan dengan kondisi Anda.</p>
                <a href="index.php?action=workout">Pelajari Lebih Lanjut</a>
            </div>

            <div class="card">
                <img src="public/assets/icons/tracking.svg" alt="">
                <h3>Tracking Kalori</h3>
                <p>Pantau asupan kalori harian Anda dengan mudah.</p>
                <a href="index.php?action=kalori">Pelajari Lebih Lanjut</a>
            </div>

            <div class="card">
                <img src="public/assets/icons/mealplan.svg" alt="">
                <h3>Meal Plan</h3>
                <p>Rencana makan harian sesuai target nutrisi Anda.</p>
                <a href="index.php?action=mealplan">Pelajari Lebih Lanjut</a>
            </div>
        </div>
    </section>

    <!-- Stats -->
    <section class="stats">
        <h2>Statistik Kesehatan</h2>
        <p>Kepercayaan ribuan pengguna di seluruh Indonesia</p>

        <div class="stats-grid">
            <div><h3>10,000+</h3><p>Pengguna Aktif</p></div>
            <div><h3>500+</h3><p>Ahli Gizi & Profesional</p></div>
            <div><h3>50,000+</h3><p>Konsultasi Selesai</p></div>
            <div><h3>4.9/5</h3><p>Rating Pengguna</p></div>
        </div>
    </section>

    <!-- Tips Section -->
    <section class="tips">
        <h2>Tips Hidup Sehat Harian</h2>
        <p>Kebiasaan sederhana untuk hidup yang lebih sehat</p>

        <div class="tips-grid">
            <div class="tip-card green"><h4>Minum Air 8 Gelas Sehari</h4><p>Jaga tubuh tetap terhidrasi agar fungsi organ optimal.</p></div>
            <div class="tip-card orange"><h4>Konsumsi 5 Porsi Buah & Sayur</h4><p>Penuhi kebutuhan vitamin & mineral tubuh.</p></div>
            <div class="tip-card blue"><h4>Tidur 7–8 Jam per Hari</h4><p>Pulihkan energi tubuh dan tingkatkan fokus.</p></div>
            <div class="tip-card purple"><h4>Olahraga 30 Menit Setiap Hari</h4><p>Perkuat otot dan tingkatkan metabolisme tubuh.</p></div>
            <div class="tip-card violet"><h4>Kelola Stres dengan Meditasi</h4><p>Tenangkan pikiran untuk menjaga kesehatan mental.</p></div>
            <div class="tip-card red"><h4>Hindari Rokok dan Alkohol</h4><p>Kurangi risiko penyakit kronis dan jaga vitalitas.</p></div>
        </div>

        <a href="#" class="btn btn-primary tips-btn">Lihat Tips Lainnya</a>
    </section>

    <!-- Testimonials -->
    <section class="testimoni">
        <h2>Testimoni Pengguna</h2>
        <p>Apa kata mereka tentang SiSehat</p>

        <div class="testimoni-grid">
            <div class="testi-card">
                <h4>Muhammad Farel</h4>
                <p>"Saya berhasil menurunkan berat badan 5kg berkat meal plan dan workout dari SiSehat!"</p>
                <span>⭐⭐⭐⭐⭐</span>
            </div>
            <div class="testi-card">
                <h4>Amell Baska</h4>
                <p>"Program konsultasi gizinya detail dan cocok banget untuk kebutuhan saya!"</p>
                <span>⭐⭐⭐⭐⭐</span>
            </div>
            <div class="testi-card">
                <h4>Dr. Mochammad Salah</h4>
                <p>"Platform SiSehat membantu saya menjangkau pasien dengan mudah dan efisien."</p>
                <span>⭐⭐⭐⭐⭐</span>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <h2>Mulai Perjalanan Kesehatan Anda</h2>
        <p>Bergabunglah dengan ribuan pengguna yang telah merasakan manfaat layanan kesehatan terpadu kami</p>
        <div class="cta-buttons">
            <a href="#" class="btn btn-primary">Daftar Sekarang</a>
            <a href="#" class="btn btn-outline">Konsultasi Gratis</a>
        </div>
    </section>

</div>

<?php include 'views/layouts/footer.php'; ?>
