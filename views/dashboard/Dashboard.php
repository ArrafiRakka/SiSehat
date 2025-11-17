<?php include 'views/layouts/header.php'; ?>

<link rel="stylesheet" href="public/css/dashboard.css?v=<?php echo time(); ?>">

<div class="dashboard-container">

    <section class="hero">
        <div class="hero-content">
            <div class="hero-text">
                <h1>Sehatkan Hidup Anda dengan <span style="color: var(--color-primary);">SiSehat</span></h1>
                <p>Program kesehatan terpadu dan personal yang kini lebih mudah diakses. Mulai perjalanan sehat Anda hari ini!</p>
                <div class="hero-buttons">
                    <a href="index.php?action=consultation" class="btn btn-primary">Mulai Konsultasi</a>
                    <a href="#features" class="btn btn-outline">Pelajari Fitur</a> 
                </div>
            </div>
            
            <div class="hero-image">
                <span class="running-icon" role="img" aria-label="A person running">🏃</span> 
                <div class="medical-icon">+</div>
            </div>
        </div>
    </section>
    
    <div class="main-content-wrapper">
        <section class="progress-section">
            <h2 class="section-title">✨ Progress Harian Anda</h2>
            <div class="progress-grid">
                <div class="progress-card card-base">
                    <div class="progress-header">
                        <span class="progress-icon">🔥</span>
                        <span class="progress-title">Kalori Harian</span>
                    </div>
                    <div>
                        <span class="progress-value">1200</span>
                        <span class="progress-unit">kcal</span>
                    </div>
                </div>
                <div class="progress-card card-base">
                    <div class="progress-header">
                        <span class="progress-icon">👣</span>
                        <span class="progress-title">Target Langkah</span>
                    </div>
                    <div>
                        <span class="progress-value">5.4k</span>
                        <span class="progress-unit">langkah</span>
                    </div>
                </div>
                <div class="progress-card card-base">
                    <div class="progress-header">
                        <span class="progress-icon">💪</span>
                        <span class="progress-title">Waktu Workout</span>
                    </div>
                    <div>
                        <span class="progress-value">45</span>
                        <span class="progress-unit">menit</span>
                    </div>
                </div>
                <div class="progress-card card-base">
                    <div class="progress-header">
                        <span class="progress-icon">😴</span>
                        <span class="progress-title">Kualitas Tidur</span>
                    </div>
                    <div>
                        <span class="progress-value">7</span>
                        <span class="progress-unit">jam</span>
                    </div>
                </div>
            </div>
        </section>
        
        <section class="features" id="features">
            <h2 class="section-title">Fitur Pendukung Kesehatan Terpadu</h2>
            <p class="features-subtitle">Dapatkan akses ke berbagai layanan kesehatan berkualitas dalam satu platform.</p>

            <div class="feature-grid">
                <div class="feature-card card-base">
                    <div class="feature-icon">💬</div>
                    <h3>Konsultasi Online</h3>
                    <p>Langsung dengan praktisi kesehatan profesional.</p>
                    <a href="index.php?action=consultation" class="feature-link">Mulai Sekarang ➔</a>
                </div>

                <div class="feature-card card-base">
                    <div class="feature-icon">📊</div>
                    <h3>Hitung BMI</h3>
                    <p>Hitung dan pantau status kesehatan tubuh Anda.</p>
                    <a href="index.php?action=bmi" class="feature-link">Hitung BMI ➔</a>
                </div>

                <div class="feature-card card-base">
                    <div class="feature-icon">🏃</div>
                    <h3>Program Workout</h3>
                    <p>Rencana latihan yang dipersonalisasi sesuai target.</p>
                    <a href="index.php?action=workout" class="feature-link">Lihat Program ➔</a>
                </div>

                <div class="feature-card card-base">
                    <div class="feature-icon">🔥</div>
                    <h3>Tracking Kalori</h3>
                    <p>Pantau asupan kalori harian Anda dengan mudah.</p>
                    <a href="index.php?action=kalori" class="feature-link">Mulai Tracking ➔</a>
                </div>

                <div class="feature-card card-base">
                    <div class="feature-icon">🍽️</div>
                    <h3>Meal Plan</h3>
                    <p>Rencana makan harian sesuai target nutrisi Anda.</p>
                    <a href="index.php?action=mealplan" class="feature-link">Buat Plan ➔</a>
                </div>

               <div class="feature-card card-base">
                    <div class="feature-icon">🎉</div> 
                    <h3>Fitur Lainnya?</h3>
                    <p>Nantikan inovasi kesehatan baru yang akan segera hadir di SiSehat.</p>
                    <a href="#" class="feature-link">Pelajari Lebih Lanjut ➔</a>
                </div>
            </div>
        </section>

        <section class="tips">
            <h2 class="section-title">💡 Tips Hidup Sehat Harian</h2>
            <p>Kebiasaan sederhana untuk memulai hidup yang lebih sehat.</p>

            <div class="tips-grid">
                <div class="tip-card card-base green">
                    <h4>Minum Air 8 Gelas</h4>
                    <p>Jaga tubuh tetap terhidrasi agar fungsi organ optimal.</p>
                </div>
                <div class="tip-card card-base orange">
                    <h4>Konsumsi Buah & Sayur</h4>
                    <p>Penuhi kebutuhan vitamin & mineral tubuh.</p>
                </div>
                <div class="tip-card card-base blue">
                    <h4>Tidur Cukup 7–8 Jam</h4>
                    <p>Pulihkan energi dan tingkatkan fokus.</p>
                </div>
            </div>

            <div style="text-align: center;">
                <a href="#" class="btn btn-outline tips-btn">Lihat Tips Lainnya</a>
            </div>
        </section>

        <section class="testimoni">
            <h2 class="section-title">💖 Testimoni Pengguna</h2>
            <p>Apa kata mereka tentang SiSehat.</p>

            <div class="testimoni-grid">
                <div class="testi-card card-base">
                    <p>"Berhasil turun 5kg berkat meal plan dan workout yang terstruktur dari SiSehat!"</p>
                    <h4>Muhammad Farel</h4>
                    <span class="rating">⭐⭐⭐⭐⭐</span>
                </div>
                <div class="testi-card card-base">
                    <p>"Program konsultasi gizinya sangat detail dan personal, cocok banget untuk kebutuhan saya!"</p>
                    <h4>Amell Baska</h4>
                    <span class="rating">⭐⭐⭐⭐⭐</span>
                
                </div>
                <div class="testi-card card-base">
                    <p>"Platform SiSehat membantu saya menjangkau pasien dengan mudah dan efisien."</p>
                    <h4>Dr. Mochammad Salah</h4>
                    <span class="rating">⭐⭐⭐⭐⭐</span>
                </div>
            </div>
        </section>

        <section class="stats-cta">
            <div class="stats-grid">
                <div>
                    <h3>10K+</h3>
                    <p>Pengguna Aktif</p>
                </div>
                <div>
                    <h3>500+</h3>
                    <p>Ahli Profesional</p>
                </div>
                <div>
                    <h3>50K+</h3>
                    <p>Konsultasi Selesai</p>
                </div>
                <div>
                    <h3>4.9/5</h3>
                    <p>Rating Aplikasi</p>
                </div>
            </div>
            <div class="cta-content">
                <h2>Mulai Perjalanan Kesehatan Anda</h2>
                <p>Bergabunglah dengan ribuan pengguna yang telah merasakan manfaat layanan kesehatan terpadu kami</p>
                <div class="cta-buttons">
                    <a href="#" class="btn btn-primary">Daftar Sekarang</a>
                    <a href="index.php?action=consultation" class="btn btn-outline">Mulai Konsultasi</a>
                </div>
            </div>
        </section>
    </div>

</div>

<?php include 'views/layouts/footer.php'; ?>