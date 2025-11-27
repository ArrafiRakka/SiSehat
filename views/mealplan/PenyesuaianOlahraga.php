<?php include __DIR__ . '/../layouts/header.php'; ?>
<link rel="stylesheet" href="public/css/penyesuaianolahraga.css?v=<?php echo time(); ?>">

<section class="mealplan-page">
  <div class="mealplan-wrapper">

    <div class="mealplan-box">
      <h1 class="page-title">Penyesuaian Berdasarkan Olahraga</h1>

      <div class="banner">
        <h2>Sesuaikan Meal Plan Anda</h2>
        <p>Masukkan aktivitas olahraga agar kebutuhan kalori diperbarui secara otomatis.</p>
      </div>

      <div class="card form-card">
        <h3>Input Aktivitas Olahraga</h3>
        <p class="desc">Data ini akan menambah rekomendasi makanan sesuai kalori yang terbakar.</p>

        <form method="POST" action="index.php?action=proses_penyesuaian_olahraga" class="meal-form">
          
          <div class="form-group">
            <label>Jenis Olahraga</label>
            <select name="jenis_olahraga" required>
              <option value="">Pilih jenis olahraga</option>
              <option value="lari">Lari</option>
              <option value="bersepeda">Bersepeda</option>
              <option value="berenang">Berenang</option>
              <option value="yoga">Yoga</option>
              <option value="angkat beban">Angkat Beban</option>
            </select>
          </div>

          <div class="form-group">
            <label>Durasi (menit)</label>
            <input type="number" name="durasi" placeholder="Contoh: 30" min="1" required>
            <div class="helper">Semakin lama durasi, semakin besar kalori terbakar.</div>
          </div>

          <div class="form-group">
            <label>Kalori Terbakar (kcal)</label>
            <input type="number" name="kalori_terbakar" placeholder="Contoh: 500" min="1" required>
            <div class="helper">Isi perkiraan hasil smartwatch/app, atau perhitungan manual.</div>
          </div>

          <div class="form-buttons">
            <button type="submit" class="btn-primary">Sesuaikan Meal Plan</button>
            <a href="index.php?action=mealplan_detail&id=<?= urlencode($mealPlan['id']); ?>" class="btn-secondary">
              Batal
            </a>
          </div>

        </form>
      </div>

    </div>
  </div>
</section>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
