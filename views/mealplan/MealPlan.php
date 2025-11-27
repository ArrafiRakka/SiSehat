<?php include __DIR__ . '/../layouts/header.php'; ?>
<link rel="stylesheet" href="public/css/mealplan.css?v=<?php echo time(); ?>">

<section class="mealplan-page">
  <div class="mealplan-wrapper">

    <div class="mealplan-box">
      <h1 class="page-title">Membuat Meal Plan</h1>

      <!-- Banner utama -->
      <div class="banner">
        <h2>Buat Meal Plan Anda Sekarang!</h2>
        <p>Dapatkan rencana makanan yang disesuaikan dengan target kalori Anda</p>
      </div>

      <?php if (!empty($error)): ?>
        <div class="card error-card">
          <?= htmlspecialchars($error); ?>
        </div>
      <?php endif; ?>

      <!-- Form -->
      <div class="card form-card">
        <h3>Meal Plan</h3>
        <p class="desc">
          Masukkan target kalori harian Anda untuk mendapatkan meal plan yang sesuai
        </p>

        <form method="POST" action="index.php?action=mealplan" class="meal-form">
          <div class="form-group">
            <label>Target Kalori</label>
            <input type="number" name="target_kalori"
                   placeholder="Masukkan jumlah kalori (contoh: 1500)"
                   min="1" required>
          </div>

          <div class="form-group">
            <label>Nama Meal Plan</label>
            <input type="text" name="nama_mealplan"
                   placeholder="Masukkan nama (contoh: Meal Plan Athaya #1)"
                   required>
          </div>

          <div class="form-buttons">
            <button type="submit" class="btn-primary">Buat Meal Plan</button>
            <button type="reset" class="btn-secondary">Reset</button>
          </div>
        </form>
      </div>

      <!-- List mealplan -->
      <div class="mealplan-list-container">
        <h3>Daftar Meal Plan Anda</h3>

        <?php if (!empty($mealPlans)): ?>
          <?php foreach ($mealPlans as $plan): ?>
            <div class="mealplan-item">
              <div class="mealplan-info"
                   onclick="window.location.href='index.php?action=mealplan_detail&id=<?= $plan['id']; ?>'">
                <strong><?= htmlspecialchars($plan['nama_mealplan']); ?></strong>
                <span>🎯 Target: <?= htmlspecialchars($plan['target_kalori']); ?> kcal</span>
              </div>
              <button class="delete-btn" onclick="confirmDelete(event, '<?= $plan['id']; ?>')">🗑</button>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="no-data">Anda belum membuat meal plan.</p>
        <?php endif; ?>
      </div>

      <!-- Popup Konfirmasi Hapus -->
      <div id="deletePopup" class="popup" style="display:none;">
        <div class="popup-content">
          <h3>⚠️ Yakin mau hapus meal plan ini?</h3>
          <div class="popup-actions">
            <button id="confirmDeleteBtn" class="btn-danger">Hapus</button>
            <button id="cancelDeleteBtn" class="btn-secondary">Batal</button>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<script>
  let deleteId = null;

  function confirmDelete(e, id) {
    e.stopPropagation();
    deleteId = id;
    document.getElementById('deletePopup').style.display = 'flex';
  }

  document.getElementById('cancelDeleteBtn').addEventListener('click', () => {
    document.getElementById('deletePopup').style.display = 'none';
    deleteId = null;
  });

  document.getElementById('confirmDeleteBtn').addEventListener('click', () => {
    if (deleteId) {
      window.location.href = 'index.php?action=delete_mealplan&id=' + deleteId;
    }
  });

  document.getElementById('deletePopup').addEventListener('click', (e) => {
    if (e.target.id === 'deletePopup') e.target.style.display = 'none';
  });
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
