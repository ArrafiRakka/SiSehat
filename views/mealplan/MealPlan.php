<?php include __DIR__ . '/../layouts/header.php'; ?>
<link rel="stylesheet" href="public/css/mealplan.css">

<section class="mealplan-page">
  <div class="container">
    <h1 class="page-title">Membuat Meal Plan</h1>

    <!-- Banner utama -->
    <div class="banner">
      <h2>Buat Meal Plan Anda Sekarang!</h2>
      <p>Dapatkan rencana makanan yang disesuaikan dengan target kalori Anda</p>
    </div>

    <!-- Form -->
    <div class="card form-card">
      <h3>Meal Plan</h3>
      <p class="desc">
        Masukkan target kalori harian Anda untuk mendapatkan meal plan yang sesuai
      </p>

      <form method="POST" action="index.php?action=mealplan" class="meal-form">
        <div class="form-group">
          <label>Target Kalori</label>
          <input type="number" name="target_kalori" placeholder="Masukkan jumlah kalori (contoh: 500)" required>
        </div>

        <div class="form-group">
          <label>Nama Meal Plan</label>
          <input type="text" name="nama_mealplan" placeholder="Masukkan nama (contoh: Meal Plan Athaya #1)" required>
        </div>

        <div class="form-buttons">
          <button type="submit" class="btn-primary">Buat Meal Plan</button>
          <button type="reset" class="btn-secondary">Reset</button>
        </div>
      </form>
    </div>

    <!-- Daftar meal plan -->
    <div class="card list-card">
      <h3>Daftar Meal Plan Anda</h3>
      <?php if (!empty($savedPlans)): ?>
        <div class="meal-list">
          <?php foreach ($savedPlans as $plan): ?>
            <div class="meal-item">
              <strong><?= htmlspecialchars($plan['nama_mealplan']); ?></strong>
              <span>🎯 Target: <?= htmlspecialchars($plan['target_kalori']); ?> kcal</span>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <p class="no-data">Anda belum membuat Meal Plan!</p>
      <?php endif; ?>
    </div>

    <!-- Gallery makanan -->
    <div class="food-gallery">
      <div class="food-card">
        <img src="public/images/oatmeal.jpg" alt="Oatmeal">
        <p>Oatmeal</p>
      </div>
      <div class="food-card">
        <img src="public/images/susu.jpg" alt="Susu">
        <p>Susu</p>
      </div>
      <div class="food-card">
        <img src="public/images/nasigoreng.jpg" alt="Nasi Goreng">
        <p>Nasi Goreng</p>
      </div>
      <div class="food-card">
        <img src="public/images/bayam.jpg" alt="Bayam">
        <p>Bayam</p>
      </div>
      <div class="food-card">
        <img src="public/images/sotobetawi.jpg" alt="Soto Betawi">
        <p>Soto Betawi</p>
      </div>
      <div class="food-card">
        <img src="public/images/satepadang.jpg" alt="Sate Padang">
        <p>Sate Padang</p>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
