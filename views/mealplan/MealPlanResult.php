<?php include __DIR__ . '/../layouts/header.php'; ?>
<link rel="stylesheet" href="public/css/mealplanresult.css">

<section class="mealplan-result-section">
  <h2 class="mealplan-title">Meal Plan Anda Siap!</h2>
  
  <div class="mealplan-header">
    <h3><?= htmlspecialchars($mealPlan['nama_mealplan']); ?></h3>
    <p><strong>Target Kalori:</strong> <?= htmlspecialchars($mealPlan['target_kalori']); ?> kcal</p>
  </div>

  <div class="mealplan-cards">
    <?php foreach ($mealPlan['foods'] as $food): ?>
      <div class="meal-card">
        <img src="<?= htmlspecialchars($food['gambar']); ?>" alt="<?= htmlspecialchars($food['nama']); ?>">
        <div class="meal-info">
          <h4><?= htmlspecialchars($food['nama']); ?></h4>
          <p><?= htmlspecialchars($food['porsi']); ?></p>
          <ul>
            <li><strong>Kalori:</strong> <?= $food['kalori'] ?? 0; ?> kcal</li>
            <li><strong>Gula:</strong> <?= $food['gula'] ?? 0; ?> g</li>
            <li><strong>Lemak:</strong> <?= $food['lemak'] ?? 0; ?> g</li>
            <li><strong>Protein:</strong> <?= $food['protein'] ?? 0; ?> g</li>
            <li><strong>Serat:</strong> <?= $food['serat'] ?? 0; ?> g</li>
          </ul>
        </div>
        <button class="btn-change"
          onclick="window.location.href='index.php?action=mealplan_detail&id=<?= $mealPlan['id']; ?>'">
          Lihat Detail
        </button>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="mealplan-actions">
    <button class="btn-secondary"
      onclick="window.location.href='index.php?action=penyesuaian_olahraga&id=<?= $mealPlan['id']; ?>'">
      Sesuaikan dengan Olahraga?
    </button>

    <div class="mealplan-btn-group">
      <button id="saveMealPlanBtn" class="btn-primary">Simpan</button>
      <button onclick="window.location.href='index.php?action=mealplan'" class="btn-reset">Buat Ulang</button>
    </div>
  </div>

  <!-- Pop-up sukses -->
  <div id="popupSuccess" class="popup">
    <div class="popup-content">
      <h3>🎉 Meal Plan Berhasil Disimpan!</h3>
      <p>Anda dapat melihatnya di daftar Meal Plan Anda.</p>
      <div class="popup-buttons">
        <button class="btn-close" onclick="closePopup()">Tutup</button>
        <button class="btn-primary" onclick="window.location.href='index.php?action=mealplan'">Lihat Daftar</button>
      </div>
    </div>
  </div>
</section>

<script>
  const popup = document.getElementById('popupSuccess');
  const saveBtn = document.getElementById('saveMealPlanBtn');

  saveBtn.addEventListener('click', () => {
    popup.classList.add('show');
  });

  function closePopup() {
    popup.classList.remove('show');
  }
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
