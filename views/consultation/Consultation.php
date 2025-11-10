<link rel="stylesheet" href="public/css/consultation.css">

<?php include 'views/layouts/header.php'; ?>

<div class="consultation-wrapper">
    <div class="text-center-custom mb-5-custom">
        <h2 class="fw-bold-custom">Konsultasi dengan Ahli Gizi</h2>
        <p class="text-secondary-custom">Temukan ahli gizi terbaik untuk membantu kamu menjaga pola makan dan kesehatan tubuh.</p>
    </div>

    <div class="filter-container">
        <input type="text" class="form-control-custom" placeholder="Cari berdasarkan nama...">
        <select class="form-select-custom"><option selected>Pilih Kota</option></select>
        <select class="form-select-custom"><option selected>Pengalaman</option></select>
        <select class="form-select-custom"><option selected>Jenis Kelamin</option></select>
        <select class="form-select-custom"><option selected>Tarif Konsultasi</option></select>
    </div>
    
    <h3 class="list-title">Daftar Ahli Gizi</h3>

    <div class="consultant-list">
        <?php foreach ($nutritionists as $n): ?>
            <div class="consultant-item">
                <div class="consultation-card card-shadow h-100-custom">
                    
                    <div class="card-content-vertical-grid">
                        
                        <div class="card-photo-area-vertical">
                            <img src="https://via.placeholder.com/200x150" class="photo-square" alt="<?= $n['name'] ?>">
                        </div>
                        
                        <div class="card-details-vertical-grid">
                            <h5 class="card-title fw-bold-custom"><?= $n['name'] ?></h5>
                            <p class="text-muted-custom mb-1-custom"><?= $n['specialty'] ?> | Kota Bogor</p>
                            
                            <div class="tags-container">
                                <span class="tag-experience">3 Tahun</span>
                                <span class="tag-specialty">Gizi Umum</span>
                            </div>
                            
                            <div class="price-action-area">
                                <h4 class="card-price-red">Rp 25.000,-</h4>
                                <a href="#" class="btn-select-red-grid">Pilih</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>