<?php include __DIR__ . '/../layouts/header.php'; ?>
<link rel="stylesheet" href="public/css/gantimakanan.css?v=<?php echo time(); ?>">

<section class="mealplan-page">
  <div class="mealplan-wrapper">
    <div class="mealplan-box">

      <h1 class="page-title">Ganti Makanan</h1>

      <div class="banner">
        <h2>Ganti Makanan: <?= htmlspecialchars($foodName ?? '') ?></h2>
        <p>Pilih makanan pengganti dari daftar berikut atau cari manual.</p>
      </div>

      <div class="card form-card">
        <div class="search-wrap">
          <input type="text" id="search" placeholder="Cari makanan..." onkeyup="filterFoods()" />
        </div>

        <form method="POST" action="index.php?action=proses_ganti_makanan" id="formGanti">
          <input type="hidden" name="mealplan_id" value="<?= htmlspecialchars($mealPlan['id'] ?? '') ?>">
          <input type="hidden" name="old_food" value="<?= htmlspecialchars($foodName ?? '') ?>">
          <input type="hidden" name="new_food" id="new_food">
        </form>

        <div class="food-grid">
          <?php foreach (($availableFoods ?? []) as $food): 
              $nama   = $food['nama']   ?? '';
              $kalori = $food['kalori'] ?? 0;
              $gambar = $food['gambar'] ?? 'public/images/placeholder-food.jpg';
          ?>
            <div class="food-item" onclick="selectFood('<?= htmlspecialchars($nama); ?>')">
              <img src="<?= htmlspecialchars($gambar); ?>" alt="<?= htmlspecialchars($nama); ?>">
              <div class="food-info">
                <p class="food-name"><?= htmlspecialchars($nama); ?></p>
                <p class="food-cal"><?= htmlspecialchars($kalori); ?> kcal</p>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

      </div>

    </div>
  </div>
</section>

<script>
function selectFood(name) {
  if (confirm(`Ganti makanan dengan ${name}?`)) {
    document.getElementById('new_food').value = name;
    document.getElementById('formGanti').submit();
  }
}
function filterFoods() {
  const q = document.getElementById('search').value.toLowerCase();
  document.querySelectorAll('.food-item').forEach(item => {
    item.style.display = item.textContent.toLowerCase().includes(q) ? '' : 'none';
  });
}
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
