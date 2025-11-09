<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<div class="kalori-page">
    <!-- Page Header (Tombol 'Tambah Cepat' saya hapus agar fokus ke search) -->
    <div class="page-header">
        <h2>Kalori Harian</h2>
        <div class="header-actions">
            <input type="date" id="dateSelector" class="date-input" value="<?= date('Y-m-d') ?>">
        </div>
    </div>

    <!-- Banner Kalori (Ini yang hilang di screenshot kamu) -->
    <div class="kalori-banner">
        <img src="/SiSehat/public/images/food-plate.png" alt="Food" class="banner-image" 
             onerror="this.src='/SiSehat/public/images/default-plate.jpg'">
        <div class="banner-content">
            <h1>Kalori Harian Kalian</h1>
            <p>Hitung kalori yang konsumsi kamu hari ini</p>
            <div class="banner-stats">
                <div class="stat-item">
                    <span class="stat-value" id="bannerCalories">0</span>
                    <span class="stat-label">kkal</span>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <span class="stat-value" id="bannerItems">0</span>
                    <span class="stat-label">items</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Section (Fokus Utama) -->
    <div class="search-section">
        <h3>Apa yang anda makan hari ini?</h3>
        <p>Coba cari makanan yang kamu makan hari ini</p>
        
        <div class="search-wrapper">
            <div class="search-box">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="searchFood" placeholder="Input nama makananmu cth (ayam goreng)">
                <button class="btn-clear" id="clearSearch" style="display: none;">&times;</button>
            </div>
            
            <div class="search-filters">
                <button class="filter-btn active" data-category="all">Semua</button>
                <button class="filter-btn" data-category="breakfast">Sarapan</button>
                <button class="filter-btn" data-category="lunch">Makan Siang</button>
                <button class="filter-btn" data-category="dinner">Makan Malam</button>
                <button class="filter-btn" data-category="snack">Camilan</button>
                <button class="filter-btn" data-category="beverage">Minuman</button>
            </div>
        </div>
    </div>

    <!-- Food Results Grid (Hasil Search Muncul Di Sini) -->
    <div id="foodResults" class="food-grid">
        <div class="loading-spinner" style="display: none;"> 
            <div class="spinner"></div>
            <p>Memuat makanan...</p>
        </div>
    </div>

    <!-- Empty State (Jika hasil search kosong) -->
    <div id="emptyState" class="empty-state" style="display: none;">
        <i class="fas fa-search" style="font-size: 80px; color: #ccc;"></i>
        <h3>Tidak ada makanan ditemukan</h3>
        <p>Coba kata kunci lain atau tambahkan makanan baru</p>
    </div>

    <!-- 
      Nutrition Summary (Ini yang hilang di screenshot kamu) 
    -->
    <div class="nutrition-summary">
        <div class="summary-header">
            <h3>Ringkasan Nutrisi Hari Ini</h3>
            <div class="summary-date">
                <i class="far fa-calendar"></i>
                <span id="summaryDate"><?= date('d F Y') ?></span>
            </div>
        </div>

        <div class="summary-content">
            <!-- Lingkaran Kalori -->
            <div class="calories-section">
                <div class="calories-circle">
                    <svg width="300" height="300" class="progress-ring">
                        <defs>
                            <linearGradient id="caloriesGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#e57373;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#ef5350;stop-opacity:1" />
                            </linearGradient>
                        </defs>
                        <circle cx="150" cy="150" r="120" fill="none" stroke="#f0f0f0" stroke-width="30"/>
                        <circle id="caloriesProgress" cx="150" cy="150" r="120" fill="none" 
                                stroke="url(#caloriesGradient)" stroke-width="30" 
                                stroke-dasharray="754" stroke-dashoffset="754"
                                stroke-linecap="round"
                                transform="rotate(-90 150 150)"/>
                    </svg>
                    <div class="calories-text">
                        <span class="calories-value">
                            <span id="totalCalories">0</span>
                        </span>
                        <span class="calories-unit">kkal</span>
                        <div class="calories-target">
                            dari <span id="targetCalories"><?= htmlspecialchars($userData['target_calories'] ?? 2000) ?></span> kkal
                        </div>
                        <div class="calories-percentage" id="caloriesPercentage">0%</div>
                    </div>
                </div>
            </div>

            <!-- Bar Makro -->
            <div class="macros-section">
                <!-- Protein -->
                <div class="macro-item">
                    <div class="macro-header">
                        <div class="macro-label">
                            <span class="macro-icon" style="background: #66BB6A;">💪</span>
                            <span>Protein</span>
                        </div>
                        <span class="macro-value">
                            <span id="proteinGram">0</span> / <?= htmlspecialchars($userData['target_protein'] ?? 150) ?>g
                        </span>
                    </div>
                    <div class="progress-bar">
                        <div id="proteinBar" class="progress-fill protein" style="width: 0%"></div>
                    </div>
                </div>
                <!-- Karbohidrat -->
                <div class="macro-item">
                    <div class="macro-header">
                        <div class="macro-label">
                            <span class="macro-icon" style="background: #42A5F5;">🍚</span>
                            <span>Karbohidrat</span>
                        </div>
                        <span class="macro-value">
                            <span id="carbsGram">0</span> / <?= htmlspecialchars($userData['target_carbs'] ?? 250) ?>g
                        </span>
                    </div>
                    <div class="progress-bar">
                        <div id="carbsBar" class="progress-fill carbs" style="width: 0%"></div>
                    </div>
                </div>
                <!-- Lemak -->
                <div class="macro-item">
                    <div class="macro-header">
                        <div class="macro-label">
                            <span class="macro-icon" style="background: #ef5350;">🥑</span>
                            <span>Lemak</span>
                        </div>
                        <span class="macro-value">
                            <span id="fatsGram">0</span> / <?= htmlspecialchars($userData['target_fats'] ?? 70) ?>g
                        </span>
                    </div>
                    <div class="progress-bar">
                        <div id="fatsBar" class="progress-fill fats" style="width: 0%"></div>
                    </div>
                </div>
                
                <!-- Info Tambahan -->
                <div class="additional-info">
                    <div class="info-item">
                        <span class="info-label">Serat</span>
                        <span class="info-value"><span id="fiberGram">0</span>g</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Gula</span>
                        <span class="info-value"><span id="sugarGram">0</span>g</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Total Items</span>
                        <span class="info-value" id="totalItems">0</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- MODAL ADD FOOD (Ini yang muncul pas kamu klik) -->
<div id="addFoodModal" class="modal">
    <div class="modal-content modal-md">
        <div class="modal-header">
            <h2>Tambah Makanan</h2>
            <span class="modal-close" id="closeAddModalBtn">&times;</span>
        </div>
        <div class="modal-body">
            <form id="addFoodForm">
                <input type="hidden" id="foodId" name="food_id">
                
                <div class="food-preview">
                    <img id="modalFoodImage" src="" alt="">
                    <div class="food-preview-info">
                        <h3 id="modalFoodName"></h3>
                        <p id="modalFoodPortion"></p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="mealType">Jenis Makanan</label>
                    <select id="mealType" name="meal_type" required>
                        <option value="">Pilih jenis makanan</option>
                        <option value="breakfast">🌅 Sarapan</option>
                        <option value="lunch">☀️ Makan Siang</option>
                        <option value="dinner">🌙 Makan Malam</option>
                        <option value="snack">🍪 Camilan</option>
                    </select>
                </div>
                
                <!-- Input Gram -->
                <div class="form-group">
                    <label for="inputGrams">
                        Jumlah (Gram)
                    </label>
                    <div class="portion-input-group">
                        <input type="number" id="inputGrams" name="input_grams" 
                               value="100" min="1" step="1" required>
                        <span>g</span>
                    </div>
                </div>

                <!-- Preview Nutrisi di Modal -->
                <div class="nutrition-preview">
                    <h4>Nutrisi yang akan ditambahkan:</h4>
                    <div class="nutrition-grid">
                        <div class="nutrition-item">
                            <span class="nutrition-label">Kalori</span>
                            <span class="nutrition-value" id="previewCalories">0 kkal</span>
                        </div>
                        <div class="nutrition-item">
                            <span class="nutrition-label">Protein</span>
                            <span class="nutrition-value" id="previewProtein">0g</span>
                        </div>
                        <div class="nutrition-item">
                            <span class="nutrition-label">Karbo</span>
                            <span class="nutrition-value" id="previewCarbs">0g</span>
                        </div>
                        <div class="nutrition-item">
                            <span class="nutrition-label">Lemak</span>
                            <span class="nutrition-value" id="previewFats">0g</span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="notes">Catatan (Opsional)</label>
                    <textarea id="notes" name="notes" rows="3" placeholder="Tambahkan catatan..."></textarea>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="cancelAddModalBtn">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambahkan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Toast & Loading (Tetap ada) -->
<div id="toast" class="toast"></div>
<div id="loadingOverlay" class="loading-overlay" style="display: none;">
    <div class="loading-spinner">
        <div class="spinner"></div>
        <p>Memproses...</p>
    </div>
</div>

<!-- JavaScript Data (SANGAT PENTING) -->
<script>
    const APP_DATA = {
        foods: <?= json_encode($foods ?? []) ?>,
        userTargets: {
            calories: <?= (int)($userData['target_calories'] ?? 2000) ?>,
            protein: <?= (int)($userData['target_protein'] ?? 150) ?>,
            carbs: <?= (int)($userData['target_carbs'] ?? 250) ?>,
            fats: <?= (int)($userData['target_fats'] ?? 70) ?>
        },
        currentDate: '<?= date('Y-m-d') ?>',
        apiUrls: {
            search: 'index.php?action=kalori_search',
            add: 'index.php?action=kalori_add',
            getIntake: 'index.php?action=kalori_get_intake',
            deleteIntake: 'index.php?action=kalori_delete_intake'
        }
    };
</script>

<script src="/SiSehat/public/assets/JS/kalori.js"></script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>