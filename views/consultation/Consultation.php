<link rel="stylesheet" href="public/css/consultation.css">

<?php include 'views/layouts/header.php'; ?>

<div class="consultation-wrapper">
    <div class="text-center-custom mb-5-custom">
        <h2 class="fw-bold-custom">Konsultasi dengan Ahli Gizi</h2>
        <p class="text-secondary-custom">Temukan ahli gizi terbaik untuk membantu kamu menjaga pola makan dan kesehatan tubuh.</p>
    </div>

    <div class="filter-container">
        <input type="text" class="form-control-custom" id="searchInput" placeholder="Cari berdasarkan nama...">
        <select class="form-select-custom" id="cityFilter">
            <option value="">Semua Kota</option>
            <option value="Jakarta">Jakarta</option>
            <option value="Bandung">Bandung</option>
            <option value="Surabaya">Surabaya</option>
        </select>
        <select class="form-select-custom" id="experienceFilter">
            <option value="">Semua Pengalaman</option>
            <option value="0-2">0-2 Tahun</option>
            <option value="3-5">3-5 Tahun</option>
            <option value="6+">6+ Tahun</option>
        </select>
        <select class="form-select-custom" id="genderFilter">
            <option value="">Semua Jenis Kelamin</option>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
        </select>
        <select class="form-select-custom" id="priceFilter">
            <option value="">Semua Tarif</option>
            <option value="0-50000">Rp 0 - 50.000</option>
            <option value="50000-100000">Rp 50.000 - 100.000</option>
            <option value="100000+">Rp 100.000+</option>
        </select>
        <button id="resetButton" class="btn-reset" style="padding: 8px 16px; background: #dc3545; color: white; border: none; border-radius: 4px; cursor: pointer;">Reset Filter</button>
    </div>
    
    <h3 class="list-title">Daftar Ahli Gizi <span id="resultCount" style="color: #666; font-size: 16px;"></span></h3>

    <div class="consultant-list" id="nutritionists">
        <!-- Data Ahli Gizi 1 -->
        <div class="consultant-card consultant-item" 
             data-city="Jakarta" 
             data-experience="5" 
             data-gender="Perempuan" 
             data-price="25000"
             data-name="dr. fitri ananda, s.gz">
            <div class="card-content">
                <div class="doctor-avatar">FA</div>
                <div class="doctor-info">
                    <h4 class="doctor-name">Dr. Fitri Ananda, S.Gz</h4>
                    <p class="doctor-details">Gizi Klinis | Jakarta</p>
                    <div class="rating-container">
                        <div class="stars">★★★★★</div>
                        <div class="rating-details">
                            <span class="rating">4.9</span>
                            <span class="consultations">(257 konsultasi)</span>
                        </div>
                    </div>
                    <div class="tags-container">
                        <span class="tag experience">5 Tahun</span>
                        <span class="tag specialty">Gizi Klinis</span>
                        <span class="tag gender">Perempuan</span>
                    </div>
                </div>
                <div class="action-section">
                    <div class="price">Rp 25.000,-</div>
                    <form action="index.php?action=consultation_payment" method="POST" class="pilih-form">
                        <input type="hidden" name="doctor_id" value="1">
                        <input type="hidden" name="doctor_name" value="Dr. Fitri Ananda, S.Gz">
                        <input type="hidden" name="doctor_city" value="Jakarta">
                        <input type="hidden" name="doctor_experience" value="5 Tahun">
                        <input type="hidden" name="doctor_price" value="25000">
                        <input type="hidden" name="doctor_specialty" value="Gizi Klinis">
                        <button type="submit" class="btn-pilih">Pilih</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Data Ahli Gizi 2 -->
        <div class="consultant-card consultant-item" 
             data-city="Bandung" 
             data-experience="4" 
             data-gender="Laki-laki" 
             data-price="25000"
             data-name="dr. yoga pratama, s.gz">
            <div class="card-content">
                <div class="doctor-avatar">YP</div>
                <div class="doctor-info">
                    <h4 class="doctor-name">Dr. Yoga Pratama, S.Gz</h4>
                    <p class="doctor-details">Gizi Olahraga | Bandung</p>
                    <div class="rating-container">
                        <div class="stars">★★★★☆</div>
                        <div class="rating-details">
                            <span class="rating">4.7</span>
                            <span class="consultations">(189 konsultasi)</span>
                        </div>
                    </div>
                    <div class="tags-container">
                        <span class="tag experience">4 Tahun</span>
                        <span class="tag specialty">Gizi Olahraga</span>
                        <span class="tag gender">Laki-laki</span>
                    </div>
                </div>
                <div class="action-section">
                    <div class="price">Rp 25.000,-</div>
                    <form action="index.php?action=consultation_payment" method="POST" class="pilih-form">
                        <input type="hidden" name="doctor_id" value="2">
                        <input type="hidden" name="doctor_name" value="Dr. Yoga Pratama, S.Gz">
                        <input type="hidden" name="doctor_city" value="Bandung">
                        <input type="hidden" name="doctor_experience" value="4 Tahun">
                        <input type="hidden" name="doctor_price" value="25000">
                        <input type="hidden" name="doctor_specialty" value="Gizi Olahraga">
                        <button type="submit" class="btn-pilih">Pilih</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Data Ahli Gizi 3 -->
        <div class="consultant-card consultant-item" 
             data-city="Surabaya" 
             data-experience="8" 
             data-gender="Perempuan" 
             data-price="25000"
             data-name="dr. lala widya, s.gz">
            <div class="card-content">
                <div class="doctor-avatar">LW</div>
                <div class="doctor-info">
                    <h4 class="doctor-name">Dr. Lala Widya, S.Gz</h4>
                    <p class="doctor-details">Gizi Anak | Surabaya</p>
                    <div class="rating-container">
                        <div class="stars">★★★★★</div>
                        <div class="rating-details">
                            <span class="rating">4.8</span>
                            <span class="consultations">(312 konsultasi)</span>
                        </div>
                    </div>
                    <div class="tags-container">
                        <span class="tag experience">8 Tahun</span>
                        <span class="tag specialty">Gizi Anak</span>
                        <span class="tag gender">Perempuan</span>
                    </div>
                </div>
                <div class="action-section">
                    <div class="price">Rp 25.000,-</div>
                    <form action="index.php?action=consultation_payment" method="POST" class="pilih-form">
                        <input type="hidden" name="doctor_id" value="3">
                        <input type="hidden" name="doctor_name" value="Dr. Lala Widya, S.Gz">
                        <input type="hidden" name="doctor_city" value="Surabaya">
                        <input type="hidden" name="doctor_experience" value="8 Tahun">
                        <input type="hidden" name="doctor_price" value="25000">
                        <input type="hidden" name="doctor_specialty" value="Gizi Anak">
                        <button type="submit" class="btn-pilih">Pilih</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Data Ahli Gizi 4 -->
        <div class="consultant-card consultant-item" 
             data-city="Jakarta" 
             data-experience="3" 
             data-gender="Laki-laki" 
             data-price="75000"
             data-name="dr. budi santoso, s.gz, m.sc">
            <div class="card-content">
                <div class="doctor-avatar">BS</div>
                <div class="doctor-info">
                    <h4 class="doctor-name">Dr. Budi Santoso, S.Gz, M.Sc</h4>
                    <p class="doctor-details">Diet & Nutrisi | Jakarta</p>
                    <div class="rating-container">
                        <div class="stars">★★★★★</div>
                        <div class="rating-details">
                            <span class="rating">4.9</span>
                            <span class="consultations">(445 konsultasi)</span>
                        </div>
                    </div>
                    <div class="tags-container">
                        <span class="tag experience">3 Tahun</span>
                        <span class="tag specialty">Diet & Nutrisi</span>
                        <span class="tag gender">Laki-laki</span>
                    </div>
                </div>
                <div class="action-section">
                    <div class="price">Rp 75.000,-</div>
                    <form action="index.php?action=consultation_payment" method="POST" class="pilih-form">
                        <input type="hidden" name="doctor_id" value="4">
                        <input type="hidden" name="doctor_name" value="Dr. Budi Santoso, S.Gz, M.Sc">
                        <input type="hidden" name="doctor_city" value="Jakarta">
                        <input type="hidden" name="doctor_experience" value="3 Tahun">
                        <input type="hidden" name="doctor_price" value="75000">
                        <input type="hidden" name="doctor_specialty" value="Diet & Nutrisi">
                        <button type="submit" class="btn-pilih">Pilih</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Data Ahli Gizi 5 -->
        <div class="consultant-card consultant-item" 
             data-city="Bandung" 
             data-experience="7" 
             data-gender="Perempuan" 
             data-price="120000"
             data-name="dr. siti nurhaliza, s.gz, rd">
            <div class="card-content">
                <div class="doctor-avatar">SN</div>
                <div class="doctor-info">
                    <h4 class="doctor-name">Dr. Siti Nurhaliza, S.Gz, RD</h4>
                    <p class="doctor-details">Gizi Medis | Bandung</p>
                    <div class="rating-container">
                        <div class="stars">★★★★★</div>
                        <div class="rating-details">
                            <span class="rating">5.0</span>
                            <span class="consultations">(521 konsultasi)</span>
                        </div>
                    </div>
                    <div class="tags-container">
                        <span class="tag experience">7 Tahun</span>
                        <span class="tag specialty">Gizi Medis</span>
                        <span class="tag gender">Perempuan</span>
                    </div>
                </div>
                <div class="action-section">
                    <div class="price">Rp 120.000,-</div>
                    <form action="index.php?action=consultation_payment" method="POST" class="pilih-form">
                        <input type="hidden" name="doctor_id" value="5">
                        <input type="hidden" name="doctor_name" value="Dr. Siti Nurhaliza, S.Gz, RD">
                        <input type="hidden" name="doctor_city" value="Bandung">
                        <input type="hidden" name="doctor_experience" value="7 Tahun">
                        <input type="hidden" name="doctor_price" value="120000">
                        <input type="hidden" name="doctor_specialty" value="Gizi Medis">
                        <button type="submit" class="btn-pilih">Pilih</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="noResults" style="display: none; text-align: center; padding: 40px; color: #666;">
        <p style="font-size: 18px; font-weight: bold;">Tidak ada ahli gizi yang sesuai dengan filter Anda.</p>
        <p>Coba ubah kriteria pencarian Anda.</p>
    </div>
</div>

<script>
window.addEventListener('load', function() {
    var searchInput = document.getElementById('searchInput');
    var cityFilter = document.getElementById('cityFilter');
    var experienceFilter = document.getElementById('experienceFilter');
    var genderFilter = document.getElementById('genderFilter');
    var priceFilter = document.getElementById('priceFilter');
    var resetButton = document.getElementById('resetButton');
    var noResults = document.getElementById('noResults');
    var container = document.getElementById('nutritionists');
    var resultCount = document.getElementById('resultCount');

    function applyFilters() {
        var searchValue = searchInput.value.toLowerCase().trim();
        var cityValue = cityFilter.value;
        var experienceValue = experienceFilter.value;
        var genderValue = genderFilter.value;
        var priceValue = priceFilter.value;

        var cards = Array.from(document.querySelectorAll('.consultant-item'));
        var matchedCards = [];
        var unmatchedCards = [];

        cards.forEach(function(card) {
            var cardName = card.getAttribute('data-name') || '';
            var cardCity = card.getAttribute('data-city') || '';
            var cardExp = parseInt(card.getAttribute('data-experience')) || 0;
            var cardGender = card.getAttribute('data-gender') || '';
            var cardPrice = parseInt(card.getAttribute('data-price')) || 0;

            var isMatch = true;

            if (searchValue && cardName.indexOf(searchValue) === -1) {
                isMatch = false;
            }

            if (cityValue && cardCity !== cityValue) {
                isMatch = false;
            }

            if (experienceValue) {
                if (experienceValue === '0-2' && (cardExp < 0 || cardExp > 2)) {
                    isMatch = false;
                }
                if (experienceValue === '3-5' && (cardExp < 3 || cardExp > 5)) {
                    isMatch = false;
                }
                if (experienceValue === '6+' && cardExp < 6) {
                    isMatch = false;
                }
            }

            if (genderValue && cardGender !== genderValue) {
                isMatch = false;
            }

            if (priceValue) {
                if (priceValue === '0-50000' && (cardPrice < 0 || cardPrice > 50000)) {
                    isMatch = false;
                }
                if (priceValue === '50000-100000' && (cardPrice < 50000 || cardPrice > 100000)) {
                    isMatch = false;
                }
                if (priceValue === '100000+' && cardPrice < 100000) {
                    isMatch = false;
                }
            }

            if (isMatch) {
                matchedCards.push(card);
            } else {
                unmatchedCards.push(card);
            }
        });

        container.innerHTML = '';

        matchedCards.forEach(function(card) {
            card.style.display = 'block';
            card.style.opacity = '1';
            container.appendChild(card);
        });

        unmatchedCards.forEach(function(card) {
            card.style.display = 'none';
            card.style.opacity = '0';
            container.appendChild(card);
        });

        if (matchedCards.length > 0) {
            resultCount.textContent = '(' + matchedCards.length + ' hasil)';
            noResults.style.display = 'none';
        } else {
            resultCount.textContent = '(0 hasil)';
            noResults.style.display = 'block';
        }
    }

    function resetAllFilters() {
        searchInput.value = '';
        cityFilter.value = '';
        experienceFilter.value = '';
        genderFilter.value = '';
        priceFilter.value = '';
        applyFilters();
    }

    searchInput.addEventListener('keyup', applyFilters);
    searchInput.addEventListener('input', applyFilters);
    cityFilter.addEventListener('change', applyFilters);
    experienceFilter.addEventListener('change', applyFilters);
    genderFilter.addEventListener('change', applyFilters);
    priceFilter.addEventListener('change', applyFilters);
    resetButton.addEventListener('click', resetAllFilters);

    applyFilters();
});
</script>

<?php include 'views/layouts/footer.php'; ?>