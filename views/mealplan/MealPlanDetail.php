<?php include __DIR__ . '/../layouts/header.php'; ?>
<link rel="stylesheet" href="public/css/mealplandetail.css">

<div class="mealplan-detail-container">
  <h2><?= htmlspecialchars($mealPlan['nama_mealplan']); ?></h2>
  <p>🎯 Target Kalori: <?= htmlspecialchars($mealPlan['target_kalori']); ?> kcal</p>

  <?php if (isset($_SESSION['olahraga'])): ?>
    <p style="color: gray; font-size: 14px;">
      🏃 Disesuaikan dengan olahraga: 
      <?= htmlspecialchars($_SESSION['olahraga']['jenis']); ?> selama 
      <?= htmlspecialchars($_SESSION['olahraga']['durasi']); ?> menit 
      (terbakar <?= htmlspecialchars($_SESSION['olahraga']['kalori_terbakar']); ?> kcal)
    </p>
  <?php endif; ?>

  <div class="meal-items">
    <?php 
      $addedFoods = $_SESSION['added_foods'] ?? [];
    ?>

    <?php foreach ($mealPlan['foods'] as $food): ?>
      <div class="food-card">
        <img src="<?= htmlspecialchars($food['gambar']); ?>" alt="<?= htmlspecialchars($food['nama']); ?>">
        <h4><?= htmlspecialchars($food['nama']); ?></h4>
        <p><?= htmlspecialchars($food['porsi']); ?></p>
        <p>Kalori: <?= htmlspecialchars($food['kalori']); ?> kcal</p>

        <?php if (isset($_SESSION['olahraga']) && in_array($food['nama'], $addedFoods)): ?>
          <span style="color:green; font-size:12px;">(Ditambahkan dari olahraga)</span>
        <?php endif; ?>

        <!-- snapshot_id dikirim -->
        <button class="btn-primary"
          onclick="window.location.href='index.php?action=ganti_makanan&id=<?= urlencode($mealPlan['id']); ?>&nama=<?= urlencode($food['nama']); ?>'">
          Ganti Makanan
        </button>

        </button>
      </div>
    <?php endforeach; ?>
  </div>

  <div style="text-align:center; margin-top:20px;">
    <a href="index.php?action=mealplan" class="btn-secondary">⬅ Kembali ke Daftar Meal Plan</a>
    <a href="index.php?action=penyesuaian_olahraga&id=<?= urlencode($mealPlan['id']); ?>" 
       class="btn-primary" style="margin-left:10px;">
      ⚡ Sesuaikan dengan Olahraga
    </a>
  </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
