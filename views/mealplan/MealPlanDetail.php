<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="mealplan-detail-container">
  <h2><?= htmlspecialchars($mealPlan['nama_mealplan']); ?></h2>
  <p>🎯 Target Kalori: <?= htmlspecialchars($mealPlan['target_kalori']); ?> kcal</p>

  <div class="meal-items">
    <?php foreach ($mealPlan['foods'] as $food): ?>
      <div class="food-card">
        <img src="<?= htmlspecialchars($food['gambar']); ?>" alt="<?= htmlspecialchars($food['nama']); ?>">
        <h4><?= htmlspecialchars($food['nama']); ?></h4>
        <p><?= htmlspecialchars($food['porsi']); ?></p>
        <p>Kalori: <?= htmlspecialchars($food['kalori']); ?> kcal</p>
        <button class="btn-primary" onclick="window.location.href='index.php?action=ganti_makanan&nama=<?= urlencode($food['nama']); ?>'">
          Ganti Makanan
        </button>
      </div>
    <?php endforeach; ?>
  </div>

  <div style="text-align:center; margin-top:20px;">
    <a href="index.php?action=mealplan" class="btn-secondary">⬅ Kembali ke Daftar Meal Plan</a>
  </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
