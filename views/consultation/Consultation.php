<link rel="stylesheet" href="public/css/consultation.css">

<?php include 'views/layouts/header.php'; ?>

<div class="consultation-wrapper">
    <div class="text-center-custom mb-5-custom">
        <h2 class="fw-bold-custom">Konsultasi dengan Ahli Gizi</h2>
        <p class="text-secondary-custom">Temukan ahli gizi terbaik untuk membantu kamu menjaga pola makan dan kesehatan tubuh.</p>
    </div>

    <div class="filter-container">
        <input type="text" class="form-control-custom" placeholder="Cari berdasarkan nama...">
        <select class="form-select-custom">
            <option selected>Pilih Kota</option>
            <option>Jakarta</option>
            <option>Bandung</option>
            <option>Surabaya</option>
        </select>
        <select class="form-select-custom">
            <option selected>Pengalaman</option>
            <option>0-2 Tahun</option>
            <option>3-5 Tahun</option>
            <option>6+ Tahun</option>
        </select>
        <select class="form-select-custom">
            <option selected>Jenis Kelamin</option>
            <option>Laki-laki</option>
            <option>Perempuan</option>
        </select>
        <select class="form-select-custom">
            <option selected>Tarif Konsultasi</option>
            <option>Rp 0 - 50.000</option>
            <option>Rp 50.000 - 100.000</option>
            <option>Rp 100.000+</option>
        </select>
    </div>
    
    <h3 class="list-title">Daftar Ahli Gizi</h3>

    <div class="consultant-list" id="nutritionists">
        <!-- Data Ahli Gizi 1 -->
        <div class="consultant-card">
            <div class="card-content">
                <div class="doctor-avatar">FA</div>
                <div class="doctor-info">
                    <h4 class="doctor-name">Dr. Fitri Ananda, S.Gz</h4>
                    <p class="doctor-details">Spesialisasi Tidak Diketahui | Jakarta</p>
                    <div class="rating-container">
                        <div class="stars">★★★★★</div>
                        <div class="rating-details">
                            <span class="rating">4.9</span>
                            <span class="consultations">(257 konsultasi)</span>
                        </div>
                    </div>
                    <div class="tags-container">
                        <span class="tag experience">5 Tahun</span>
                        <span class="tag specialty">Spesialisasi Tidak Diketahui</span>
                    </div>
                </div>
                <div class="action-section">
                    <div class="price">Rp 25.000,-</div>
                    <button class="btn-pilih">Pilih</button>
                </div>
            </div>
        </div>

        <!-- Data Ahli Gizi 2 -->
        <div class="consultant-card">
            <div class="card-content">
                <div class="doctor-avatar">YP</div>
                <div class="doctor-info">
                    <h4 class="doctor-name">Dr. Yoga Pratama, S.Gz</h4>
                    <p class="doctor-details">Spesialisasi Tidak Diketahui | Bandung</p>
                    <div class="rating-container">
                        <div class="stars">★★★★☆</div>
                        <div class="rating-details">
                            <span class="rating">4.7</span>
                            <span class="consultations">(189 konsultasi)</span>
                        </div>
                    </div>
                    <div class="tags-container">
                        <span class="tag experience">4 Tahun</span>
                        <span class="tag specialty">Spesialisasi Tidak Diketahui</span>
                    </div>
                </div>
                <div class="action-section">
                    <div class="price">Rp 25.000,-</div>
                    <button class="btn-pilih">Pilih</button>
                </div>
            </div>
        </div>

        <!-- Data Ahli Gizi 3 -->
        <div class="consultant-card">
            <div class="card-content">
                <div class="doctor-avatar">LW</div>
                <div class="doctor-info">
                    <h4 class="doctor-name">Dr. Lala Widya, S.Gz</h4>
                    <p class="doctor-details">Spesialisasi Tidak Diketahui | Surabaya</p>
                    <div class="rating-container">
                        <div class="stars">★★★★★</div>
                        <div class="rating-details">
                            <span class="rating">4.8</span>
                            <span class="consultations">(312 konsultasi)</span>
                        </div>
                    </div>
                    <div class="tags-container">
                        <span class="tag experience">8 Tahun</span>
                        <span class="tag specialty">Spesialisasi Tidak Diketahui</span>
                    </div>
                </div>
                <div class="action-section">
                    <div class="price">Rp 25.000,-</div>
                    <button class="btn-pilih">Pilih</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>