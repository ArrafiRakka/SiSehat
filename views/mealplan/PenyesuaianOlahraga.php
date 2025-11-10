<?php include __DIR__ . '/../layouts/header.php'; ?>

<section class="mealplan-page">
  <div class="container">
    <h1 class="page-title">Penyesuaian Berdasarkan Olahraga</h1>

    <div class="banner">
      <h2>Sesuaikan Meal Plan Anda dengan Aktivitas Olahraga</h2>
      <p>Masukkan data aktivitas olahraga Anda agar kebutuhan kalori diperbarui secara otomatis.</p>
    </div>

    <div class="card form-card">
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
          <label>Durasi Olahraga (menit)</label>
          <input type="number" name="durasi" placeholder="Contoh: 30" required>
        </div>

        <div class="form-group">
          <label>Kalori yang Terbakar</label>
          <input type="number" name="kalori_terbakar" placeholder="Contoh: 500" required>
        </div>

        <div class="form-buttons">
          <button type="submit" class="btn-primary">Sesuaikan Meal Plan</button>
          <a href="index.php?action=mealplan" class="btn-secondary">Batal</a>
        </div>
      </form>
    </div>
  </div>
</section>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
