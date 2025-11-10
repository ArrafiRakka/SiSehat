<?php
// views/layouts/main.php
// Layout utama untuk semua halaman (punya header & footer)
?>

<?php include __DIR__ . '/../layouts/header.php'; ?>

<main class="main-content">
  <?php
  // Pastikan file view utama dimasukkan di sini
  if (isset($viewFile) && file_exists($viewFile)) {
      include $viewFile;
  } else {
      echo "<p style='text-align:center; color:red;'>Halaman tidak ditemukan.</p>";
  }
  ?>
</main>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
