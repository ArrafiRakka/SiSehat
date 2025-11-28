<?php include 'views/layouts/header.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Ahli Gizi - Admin SiSehat</title>
    <link rel="stylesheet" href="public/css/admin.css">
    </head>
<body>
    <div class="admin-container">
        <main class="main-content">
            <a href="index.php?action=admin_nutritionists" class="btn-back">← Kembali</a>

            <header>
                 <h1>📝 Edit Ahli Gizi: <?= htmlspecialchars($nutritionist['name']) ?></h1>
                 <p>Perbarui informasi detail ahli gizi.</p>
            </header>
            
            <?php if(isset($error)): ?>
                <div class="alert-error"><?= $error ?></div>
            <?php endif; ?>

            <div class="card">
                <form method="POST" action="">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Nama Lengkap *</label>
                            <input type="text" name="name" value="<?= htmlspecialchars($nutritionist['name']) ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Spesialisasi *</label>
                            <input type="text" name="specialty" value="<?= htmlspecialchars($nutritionist['specialty']) ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Kota *</label>
                            <input type="text" name="city" value="<?= htmlspecialchars($nutritionist['city']) ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Pengalaman (Tahun) *</label>
                            <input type="number" name="experience" value="<?= $nutritionist['experience'] ?>" min="0" required>
                        </div>

                        <div class="form-group">
                            <label>Harga Konsultasi (Rp) *</label>
                            <input type="number" name="price" value="<?= $nutritionist['price'] ?>" min="0" step="1000" required>
                        </div>

                        <div class="form-group">
                            <label>Gender *</label>
                            <select name="gender" required>
                                <option value="Laki-laki" <?= $nutritionist['gender'] === 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                                <option value="Perempuan" <?= $nutritionist['gender'] === 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                            </select>
                        </div>

                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label>URL Gambar</label>
                            <input type="text" name="img" value="<?= htmlspecialchars($nutritionist['img']) ?>">
                            <small>Isi dengan path gambar baru atau biarkan untuk tetap menggunakan gambar lama</small>
                        </div>

                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label>Preview Gambar Saat Ini:</label>
                            <img src="<?= htmlspecialchars($nutritionist['img']) ?>" 
                                 alt="<?= htmlspecialchars($nutritionist['name']) ?>"
                                 class="preview-img">
                        </div>
                    </div>

                    <div class="form-info">
                        <strong>ℹ️ Info Tambahan:</strong><br>
                        <small>Rating: ⭐ <?= $nutritionist['rating'] ?> | Total Konsultasi: <?= $nutritionist['total_consultations'] ?></small>
                    </div>

                    <button type="submit" name="edit_nutritionist" class="btn-primary">
                        💾 Simpan Perubahan
                    </button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>

<?php include 'views/layouts/footer.php'; ?>