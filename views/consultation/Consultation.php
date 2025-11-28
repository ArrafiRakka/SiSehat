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
            <option value="Yogyakarta">Yogyakarta</option>
            <option value="Malang">Malang</option>
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
        <?php if (isset($data['nutritionists']) && count($data['nutritionists']) > 0): ?>
            <?php foreach ($data['nutritionists'] as $nutritionist): 
                // Ekstrak angka dari experience untuk filter
                preg_match('/\d+/', $nutritionist['experience'], $matches);
                $experienceYears = isset($matches[0]) ? $matches[0] : 0;
                
                // Generate bintang rating
                $fullStars = floor($nutritionist['rating']);
                $halfStar = ($nutritionist['rating'] - $fullStars) >= 0.5 ? 1 : 0;
                $emptyStars = 5 - $fullStars - $halfStar;
                
                $stars = str_repeat('★', $fullStars);
                if ($halfStar) $stars .= '☆';
                $stars .= str_repeat('☆', $emptyStars);
                
                // Generate avatar
                $initials = '';
                $nameParts = explode(' ', $nutritionist['name']);
                foreach ($nameParts as $part) {
                    if (ctype_upper($part[0])) {
                        $initials .= $part[0];
                        if (strlen($initials) >= 2) break;
                    }
                }
                if (strlen($initials) < 2 && isset($nameParts[0])) {
                    $initials = strtoupper(substr($nameParts[0], 0, 2));
                }
            ?>
                <div class="consultant-card consultant-item" 
                     data-city="<?= htmlspecialchars($nutritionist['city']) ?>" 
                     data-experience="<?= htmlspecialchars($experienceYears) ?>" 
                     data-gender="<?= htmlspecialchars($nutritionist['gender']) ?>" 
                     data-price="<?= htmlspecialchars($nutritionist['price']) ?>"
                     data-name="<?= htmlspecialchars(strtolower($nutritionist['name'])) ?>">
                    <div class="card-content">
                        <?php if (!empty($nutritionist['img'])): ?>
                            <img src="<?= htmlspecialchars($nutritionist['img']) ?>" 
                                 alt="<?= htmlspecialchars($nutritionist['name']) ?>" 
                                 class="doctor-avatar" 
                                 style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover;">
                        <?php else: ?>
                            <div class="doctor-avatar"><?= htmlspecialchars($initials) ?></div>
                        <?php endif; ?>
                        
                        <div class="doctor-info">
                            <h4 class="doctor-name"><?= htmlspecialchars($nutritionist['name']) ?></h4>
                            <p class="doctor-details">
                                <?= htmlspecialchars($nutritionist['specialty']) ?> | 
                                <?= htmlspecialchars($nutritionist['city']) ?>
                            </p>
                            <div class="rating-container">
                                <div class="stars"><?= $stars ?></div>
                                <div class="rating-details">
                                    <span class="rating"><?= number_format($nutritionist['rating'], 1) ?></span>
                                    <span class="consultations">(<?= number_format($nutritionist['total_consultations']) ?> konsultasi)</span>
                                </div>
                            </div>
                            <div class="tags-container">
                                <span class="tag experience"><?= htmlspecialchars($nutritionist['experience']) ?></span>
                                <span class="tag specialty"><?= htmlspecialchars($nutritionist['specialty']) ?></span>
                                <span class="tag gender"><?= htmlspecialchars($nutritionist['gender']) ?></span>
                            </div>
                        </div>
                        <div class="action-section">
                            <div class="price">Rp <?= number_format($nutritionist['price'], 0, ',', '.') ?>,-</div>
                            <form action="index.php?action=consultation_payment" method="POST" class="pilih-form">
                                <input type="hidden" name="doctor_id" value="<?= htmlspecialchars($nutritionist['id']) ?>">
                                <button type="submit" class="btn-pilih">Pilih</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="text-align: center; padding: 40px; color: #666;">
                <p style="font-size: 18px; font-weight: bold;">Belum ada ahli gizi tersedia.</p>
                <p>Silakan coba lagi nanti.</p>
            </div>
        <?php endif; ?>
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