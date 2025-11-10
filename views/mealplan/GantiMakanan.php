<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="ganti-makanan-container">
  <h2>Ganti Makanan: <?= htmlspecialchars($foodName) ?></h2>
  <p>Pilih makanan pengganti dari daftar berikut atau cari manual:</p>

  <form method="POST" action="index.php?action=proses_ganti_makanan">
    <input type="hidden" name="mealplan_id" value="<?= htmlspecialchars($mealPlan['id']); ?>">
    <input type="hidden" name="old_food" value="<?= htmlspecialchars($foodName); ?>">

    <input type="text" id="search" placeholder="Cari makanan..." onkeyup="filterFoods()">

    <div class="food-list">
      <?php foreach ($availableFoods as $food): ?>
        <div class="food-item" onclick="selectFood('<?= htmlspecialchars($food['nama']); ?>')">
          <img src="<?= htmlspecialchars($food['gambar']); ?>" alt="<?= htmlspecialchars($food['nama']); ?>">
          <p><?= htmlspecialchars($food['nama']); ?></p>
        </div>
      <?php endforeach; ?>
    </div>

    <input type="hidden" name="new_food" id="new_food">
  </form>
</div>

<script>
function selectFood(name) {
  if (confirm(`Ganti makanan dengan ${name}?`)) {
    document.getElementById('new_food').value = name;
    document.forms[0].submit();
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
