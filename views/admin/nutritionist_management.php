<?php include 'views/layouts/header.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Ahli Gizi - Admin SiSehat</title>
    <link rel="stylesheet" href="public/css/admin.css">
    </head>
<body>
    <div class="admin-container">
        <main class="main-content">
            
            <?php if(isset($_GET['status'])): ?>
                <div class="alert alert-success">
                    <?php
                    switch($_GET['status']) {
                        case 'added': echo '✅ Ahli gizi berhasil ditambahkan'; break;
                        case 'updated': echo '✅ Ahli gizi berhasil diupdate'; break;
                        case 'deleted': echo '✅ Ahli gizi berhasil dihapus'; break;
                    }
                    ?>
                </div>
            <?php endif; ?>

            <div class="card">
                <h3>➕ Tambah Ahli Gizi Baru</h3>
                <form method="POST" action="">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Nama Lengkap *</label>
                            <input type="text" name="name" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Spesialisasi *</label>
                            <input type="text" name="specialty" placeholder="Contoh: Nutrisi Olahraga" required>
                        </div>

                        <div class="form-group">
                            <label>Kota *</label>
                            <input type="text" name="city" placeholder="Contoh: Jakarta" required>
                        </div>

                        <div class="form-group">
                            <label>Pengalaman (Tahun) *</label>
                            <input type="number" name="experience" min="0" required>
                        </div>

                        <div class="form-group">
                            <label>Harga Konsultasi (Rp) *</label>
                            <input type="number" name="price" min="0" step="1000" required>
                        </div>

                        <div class="form-group">
                            <label>Gender *</label>
                            <select name="gender" required>
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>

                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label>URL Gambar (Opsional)</label>
                            <input type="text" name="img" placeholder="public/images/doctor.jpg">
                            <small>Kosongkan untuk menggunakan gambar default</small>
                        </div>
                    </div>

                    <button type="submit" name="add_nutritionist" class="btn-primary">
                        ➕ Tambah Ahli Gizi
                    </button>
                </form>
            </div>

            <div class="card">
                <h3>📋 Daftar Ahli Gizi (<?= count($nutritionists) ?>)</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Spesialisasi</th>
                            <th>Kota</th>
                            <th>Pengalaman</th>
                            <th>Harga</th>
                            <th>Rating</th>
                            <th>Total Konsultasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($nutritionists)): ?>
                            <tr>
                                <td colspan="10" style="text-align: center; padding: 30px; color: #999;">
                                    Belum ada data ahli gizi.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($nutritionists as $n): ?>
                                <tr>
                                    <td><?= $n['id'] ?></td>
                                    <td>
                                        <img src="<?= htmlspecialchars($n['img']) ?>" 
                                             alt="<?= htmlspecialchars($n['name']) ?>"
                                             class="nutritionist-img">
                                    </td>
                                    <td><strong><?= htmlspecialchars($n['name']) ?></strong></td>
                                    <td><?= htmlspecialchars($n['specialty']) ?></td>
                                    <td><?= htmlspecialchars($n['city']) ?></td>
                                    <td><?= $n['experience'] ?> tahun</td>
                                    <td>Rp <?= number_format($n['price'], 0, ',', '.') ?></td>
                                    <td>⭐ <?= $n['rating'] ?></td>
                                    <td><?= $n['total_consultations'] ?></td>
                                    <td>
                                        <a href="index.php?action=admin_nutritionist_edit&id=<?= $n['id'] ?>" 
                                           class="btn-sm btn-warning">Edit</a>
                                        <a href="index.php?action=admin_nutritionists&delete_id=<?= $n['id'] ?>" 
                                           class="btn-sm btn-danger"
                                           onclick="return confirm('Yakin hapus ahli gizi ini?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>

<?php include 'views/layouts/footer.php'; ?>