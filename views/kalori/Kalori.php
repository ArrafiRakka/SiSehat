<?php
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../../models/Kalori.php';

$model = new Kalori();
$userId = $_SESSION['user_id'] ?? 1;
$currentDate = $_GET['date'] ?? date('Y-m-d');

$userData = $model->getUserById($userId);
$intakeItems = $model->getTodayIntake($userId, $currentDate);

$keyword = $_GET['keyword'] ?? '';
$category = $_GET['category'] ?? 'all';
$filteredFoods = [];
if (!empty($keyword)) {
    $filteredFoods = $model->getFoodsFiltered($keyword, $category);
}

$edit_id = $_GET['edit_id'] ?? null;
$item_to_edit = null;
if ($edit_id) {
    $item_to_edit = $model->getIntakeById($edit_id, $userId);
}

$summaryTotals = [
    'calories' => 0, 'protein' => 0, 'carbs' => 0, 'fats' => 0,
    'fiber' => 0, 'sugar' => 0
];
foreach ($intakeItems as $item) {
    $portion = $item['portion_multiplier'] ?? 1;
    $summaryTotals['calories'] += ($item['calories'] ?? 0) * $portion;
    $summaryTotals['protein'] += ($item['protein'] ?? 0) * $portion;
    $summaryTotals['carbs'] += ($item['carbs'] ?? 0) * $portion;
    $summaryTotals['fats'] += ($item['fats'] ?? 0) * $portion;
}
$calPercent = 0;
if (($userData['target_calories'] ?? 0) > 0) {
    $calPercent = ($summaryTotals['calories'] / $userData['target_calories']) * 100;
}
?>

<div class="kalori-page">
    <div class="page-header">
        <h2>Kalori Harian</h2>
        <div class="header-actions">
            <input type="date" id="dateSelector" class="date-input" value="<?= htmlspecialchars($currentDate) ?>" onchange="window.location.href='index.php?action=kalori&date=' + this.value">
        </div>
    </div>

    <div class="kalori-banner">
        <img src="/SiSehat/public/images/food-plate.png" alt="Food" class="banner-image" 
             onerror="this.src='/SiSehat/public/images/default-plate.jpg'">
        <div class="banner-content">
            <h1>Kalori Harian Kalian</h1>
            <p>Hitung kalori yang konsumsi kamu hari ini</p>
            <div class="banner-stats">
                <div class="stat-item">
                    <span class="stat-value"><?= round($summaryTotals['calories']) ?></span>
                    <span class="stat-label">kkal</span>
                </div>
                <div class="stat-divider"></div>
                <div class="stat-item">
                    <span class="stat-value"><?= count($intakeItems) ?></span>
                    <span class="stat-label">items</span>
                </div>
            </div>
        </div>
    </div>

    <div class="search-section">
        <h3>Apa yang anda makan hari ini?</h3>
        <p>Coba cari makanan yang kamu makan hari ini</p>
        
        <form method="GET" action="index.php" class="search-wrapper">
            <input type="hidden" name="action" value="kalori">
            <input type="hidden" name="date" value="<?= htmlspecialchars($currentDate) ?>">
            <div class="search-box">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="searchFood" name="keyword" placeholder="Input nama makananmu cth (ayam goreng)" value="<?= htmlspecialchars($keyword) ?>">
                <button type="submit" class="btn-search-submit">Search</button>
            </div>
            
            <div class="search-filters">
                <button type="submit" name="category" value="all" class="filter-btn <?= $category == 'all' ? 'active' : '' ?>">Semua</button>
                <button type="submit" name="category" value="breakfast" class="filter-btn <?= $category == 'breakfast' ? 'active' : '' ?>">Sarapan</button>
                <button type="submit" name="category" value="lunch" class="filter-btn <?= $category == 'lunch' ? 'active' : '' ?>">Makan Siang</button>
                <button type="submit" name="category" value="dinner" class="filter-btn <?= $category == 'dinner' ? 'active' : '' ?>">Makan Malam</button>
                <button type="submit" name="category" value="snack" class="filter-btn <?= $category == 'snack' ? 'active' : '' ?>">Camilan</button>
                <button type="submit" name="category" value="beverage" class="filter-btn <?= $category == 'beverage' ? 'active' : '' ?>">Minuman</button>
            </div>
        </form>
    </div>

    <div class="todays-intake">
        <h3>Makanan Hari Ini</h3>
        <?php if (empty($intakeItems)): ?>
            <p class="empty-meal">Belum ada makanan yang ditambahkan hari ini.</p>
        <?php else: ?>
            <div class="food-grid">
                <?php foreach ($intakeItems as $item): ?>
                    
                    <?php if ($item_to_edit && $item['id'] == $item_to_edit['id']): ?>
                        <form class="food-item is-editing" method="POST" action="index.php?action=kalori_update">
                            <input type="hidden" name="intake_id" value="<?= $item['id'] ?>">
                            <input type="hidden" name="intake_date" value="<?= htmlspecialchars($currentDate) ?>">
                            <div class="food-item-content-edit">
                                <strong>Edit: <?= htmlspecialchars($item['name']) ?></strong>
                                <div class="edit-fields">
                                    <label>Jumlah (g)</label>
                                    <input type="number" name="input_grams" value="<?= round($item['portion_multiplier'] * $item['base_grams']) ?>" class="intake-edit-grams">
                                    <label>Kategori</label>
                                    <select name="meal_type">
                                        <option value="breakfast" <?= $item['meal_type'] == 'breakfast' ? 'selected' : '' ?>>Sarapan</option>
                                        <option value="lunch" <?= $item['meal_type'] == 'lunch' ? 'selected' : '' ?>>Makan Siang</option>
                                        <option value="dinner" <?= $item['meal_type'] == 'dinner' ? 'selected' : '' ?>>Makan Malam</option>
                                        <option value="snack" <?= $item['meal_type'] == 'snack' ? 'selected' : '' ?>>Camilan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="food-item-actions-edit">
                                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                                <a href="index.php?action=kalori&date=<?= htmlspecialchars($currentDate) ?>" class="btn btn-secondary btn-sm">Batal</a>
                            </div>
                        </form>
                    <?php else: ?>
                        <div class="food-item">
                            <img src="<?= htmlspecialchars($item['image'] ?? '/SiSehat/public/images/default-plate.jpg') ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="food-item-img" onerror="this.src='/SiSehat/public/images/default-plate.jpg'">
                            <div class="food-item-content">
                                <div class="food-item-name"><?= htmlspecialchars($item['name']) ?></div>
                                <div class="food-item-nutrition"><?= round($item['calories'] * $item['portion_multiplier']) ?> kkal (<?= round($item['portion_multiplier'] * $item['base_grams']) ?>g)</div>
                            </div>
                            <div class="food-item-actions-intake">
                                <a href="index.php?action=kalori&date=<?= htmlspecialchars($currentDate) ?>&edit_id=<?= $item['id'] ?>" class="btn-edit">Edit</a>
                                <form method="POST" action="index.php?action=kalori_delete" style="display:inline;">
                                    <input type="hidden" name="intake_id" value="<?= $item['id'] ?>">
                                    <input type="hidden" name="intake_date" value="<?= htmlspecialchars($currentDate) ?>">
                                    <button type="submit" class="btn-delete" onclick="return confirm('Yakin ingin menghapus item ini?')">&times;</button>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <div id="foodResults" class="food-grid">
        <?php foreach ($filteredFoods as $food): ?>
            <?php $calPer100g = round(($food['calories'] / $food['base_grams']) * 100); ?>
            
            <form class="food-item" method="POST" action="index.php?action=kalori_add">
                <input type="hidden" name="food_id" value="<?= $food['id'] ?>">
                <input type="hidden" name="intake_date" value="<?= htmlspecialchars($currentDate) ?>">
                
                <img src="<?= htmlspecialchars($food['image'] ?? '/SiSehat/public/images/default-plate.jpg') ?>" alt="<?= htmlspecialchars($food['name']) ?>" class="food-item-img" onerror="this.src='/SiSehat/public/images/default-plate.jpg'">
                
                <div class="food-item-content">
                    <div class="food-item-name"><?= htmlspecialchars($food['name']) ?></div>
                    <div class="food-item-nutrition"><?= $calPer100g ?> kkal / 100g</div>
                </div>
                
                <div class="food-item-actions">
                    <div class="food-item-grams-wrapper">
                        <input type="number" class="food-item-grams" name="input_grams" value="<?= $food['base_grams'] ?>">
                        <span>g</span>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm food-item-add">Add</button>
                </div>
            </form>
        <?php endforeach; ?>
    </div>

    <?php if (empty($filteredFoods) && !empty($keyword)): ?>
        <div id="emptyState" class="empty-state" style="display: block;">
            <i class="fas fa-search" style="font-size: 80px; color: #ccc;"></i>
            <h3>Tidak ada makanan ditemukan</h3>
            <p>Coba kata kunci lain atau tambahkan makanan baru</p>
        </div>
    <?php endif; ?>

    <div class="nutrition-summary">
        <div class="summary-header">
            <h3>Ringkasan Nutrisi Hari Ini</h3>
            <div class="summary-date">
                <i class="far fa-calendar"></i>
                <span id="summaryDate"><?= date('d F Y', strtotime($currentDate)) ?></span>
            </div>
        </div>

        <div class="summary-content">
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
                                stroke-dasharray="754" 
                                stroke-dashoffset="<?= 754 - (754 * min($calPercent, 100) / 100) ?>"
                                stroke-linecap="round"
                                transform="rotate(-90 150 150)"/>
                    </svg>
                    <div class="calories-text">
                        <span class="calories-value">
                            <span id="totalCalories"><?= round($summaryTotals['calories']) ?></span>
                        </span>
                        <span class="calories-unit">kkal</span>
                        <div class="calories-target">
                            dari <span id="targetCalories"><?= htmlspecialchars($userData['target_calories'] ?? 2000) ?></span> kkal
                        </div>
                        <div class="calories-percentage" id="caloriesPercentage"><?= round($calPercent) ?>%</div>
                    </div>
                </div>
            </div>

            <div class="macros-section">
                <div class="macro-item">
                    <div class="macro-header">
                        <div class="macro-label">
                            <span class="macro-icon" style="background: #66BB6A;">💪</span>
                            <span>Protein</span>
                        </div>
                        <span class="macro-value">
                            <span id="proteinGram"><?= round($summaryTotals['protein']) ?></span> / <?= htmlspecialchars($userData['target_protein'] ?? 150) ?>g
                        </span>
                    </div>
                    <div class="progress-bar">
                        <div id="proteinBar" class="progress-fill protein" style="width: <?= min(100, (($userData['target_protein'] ?? 0) > 0 ? ($summaryTotals['protein'] / $userData['target_protein']) * 100 : 0)) ?>%"></div>
                    </div>
                </div>
                <div class="macro-item">
                    <div class="macro-header">
                        <div class="macro-label">
                            <span class="macro-icon" style="background: #42A5F5;">🍚</span>
                            <span>Karbohidrat</span>
                        </div>
                        <span class="macro-value">
                            <span id="carbsGram"><?= round($summaryTotals['carbs']) ?></span> / <?= htmlspecialchars($userData['target_carbs'] ?? 250) ?>g
                        </span>
                    </div>
                    <div class="progress-bar">
                        <div id="carbsBar" class="progress-fill carbs" style="width: <?= min(100, (($userData['target_carbs'] ?? 0) > 0 ? ($summaryTotals['carbs'] / $userData['target_carbs']) * 100 : 0)) ?>%"></div>
                    </div>
                </div>
                <div class="macro-item">
                    <div class="macro-header">
                        <div class="macro-label">
                            <span class="macro-icon" style="background: #ef5350;">🥑</span>
                            <span>Lemak</span>
                        </div>
                        <span class="macro-value">
                            <span id="fatsGram"><?= round($summaryTotals['fats']) ?></span> / <?= htmlspecialchars($userData['target_fats'] ?? 70) ?>g
                        </span>
                    </div>
                    <div class="progress-bar">
                        <div id="fatsBar" class="progress-fill fats" style="width: <?= min(100, (($userData['target_fats'] ?? 0) > 0 ? ($summaryTotals['fats'] / $userData['target_fats']) * 100 : 0)) ?>%"></div>
                    </div>
                </div>
                
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
                        <span class="info-value" id="totalItems"><?= count($intakeItems) ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="toast" class="toast"></div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>