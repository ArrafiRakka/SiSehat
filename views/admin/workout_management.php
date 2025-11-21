<?php include 'views/layouts/header.php'; ?>

<div class="container" style="max-width: 1100px; margin: 40px auto; padding: 0 20px;">
    
    <h1 style="color: #2c3e50; border-bottom: 3px solid #8e44ad; padding-bottom: 10px; margin-bottom: 30px;">
        🏋️ Kelola Jenis Workout
    </h1>

    <?php 
    // Tampilkan pesan status (added, updated, deleted)
    if (isset($_GET['status'])): 
        $message = '';
        $class = '';
        if ($_GET['status'] == 'added') {
            $message = 'Workout baru berhasil ditambahkan!';
            $class = 'background-color: #d4edda; color: #155724; border-color: #c3e6cb;';
        } elseif ($_GET['status'] == 'updated') {
            $message = 'Workout berhasil diperbarui!';
            $class = 'background-color: #fff3cd; color: #856404; border-color: #ffeeba;';
        } elseif ($_GET['status'] == 'deleted') {
            $message = 'Workout berhasil dinonaktifkan (Soft Delete)!';
            $class = 'background-color: #f8d7da; color: #721c24; border-color: #f5c6cb;';
        }
    ?>
    <div style="padding: 15px; border: 1px solid transparent; border-radius: .25rem; margin-bottom: 20px; <?= $class ?> font-weight: 600;">
        <?= htmlspecialchars($message) ?>
    </div>
    <?php endif; ?>

    <div style="background: #f4f6f9; padding: 25px; border-radius: 12px; margin-bottom: 30px; border: 1px solid #e0e0e0;">
        <h2 style="margin-top: 0; color: #34495e; font-size: 1.2rem;">Tambah Workout Baru</h2>
        <form method="POST" action="index.php?action=admin_workouts" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; align-items: end;">
            
            <div>
                <label for="nama_workout" style="display: block; font-weight: 600; margin-bottom: 5px;">Nama Workout</label>
                <input type="text" id="nama_workout" name="nama_workout" required 
                       style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
            </div>

            <div>
                <label for="key_slug" style="display: block; font-weight: 600; margin-bottom: 5px;">Key Slug (URL/Code)</label>
                <input type="text" id="key_slug" name="key_slug" required 
                       placeholder="Contoh: lari, angkatBeban"
                       style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
            </div>
            
            <div>
                <label for="met_value" style="display: block; font-weight: 600; margin-bottom: 5px;">Nilai METs (Float)</label>
                <input type="number" step="0.01" id="met_value" name="met_value" required 
                       placeholder="Contoh: 9.80"
                       style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
            </div>

            
            <div>
                <label for="fokus_otot" style="display: block; font-weight: 600; margin-bottom: 5px;">Fokus Otot</label>
                <select id="fokus_otot" name="fokus_otot" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
                    <option value="" disabled selected>Pilih Fokus Otot</option>
                    <option value="Kardio">Kardio</option>
                    <option value="Kaki & Glutes">Kaki & Glutes</option>
                    <option value="Inti (Core)">Inti (Core)</option>
                    <option value="Tubuh Atas">Tubuh Atas</option>
                    <option value="Full Body">Full Body</option>
                    <option value="Fleksibilitas">Fleksibilitas</option>
                </select>
            </div>
            
            <div>
                <label for="tujuan_utama" style="display: block; font-weight: 600; margin-bottom: 5px;">Tujuan Utama</label>
                <select id="tujuan_utama" name="tujuan_utama" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
                    <option value="" disabled selected>Pilih Tujuan Utama</option>
                    <option value="Kardio/Stamina">Kardio/Stamina</option>
                    <option value="Kekuatan">Kekuatan</option>
                    <option value="Fleksibilitas">Fleksibilitas</option>
                    <option value="Penurunan Berat Badan">Penurunan Berat Badan</option>
                </select>
            </div>
            
            <button type="submit" name="add_workout" 
                    style="padding: 10px 15px; background-color: #27ae60; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: 600;">
                Tambah Data
            </button>
        </form>
    </div>

    <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        <h2 style="margin-top: 0; color: #34495e; font-size: 1.2rem;">Daftar Semua Workout (<?= count($workouts ?? []) ?>)</h2>
        
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <thead>
        <tr style="background-color: #ecf0f1;">
            <th style="padding: 10px; text-align: left; border: 1px solid #ddd;">ID</th>
            <th style="padding: 10px; text-align: left; border: 1px solid #ddd;">Nama Workout</th>
            <th style="padding: 10px; text-align: left; border: 1px solid #ddd;">Key Slug</th>
            <th style="padding: 10px; text-align: right; border: 1px solid #ddd;">Nilai METs</th>
            
            <th style="padding: 10px; text-align: left; border: 1px solid #ddd;">Fokus Otot</th>
            <th style="padding: 10px; text-align: left; border: 1px solid #ddd;">Tujuan Utama</th>
            <th style="padding: 10px; text-align: center; border: 1px solid #ddd;">Status</th>
            <th style="padding: 10px; text-align: center; border: 1px solid #ddd;">Aksi</th>
        </tr>
    </thead>
    <tbody>
    <?php if (!empty($workouts)): ?>
        <?php foreach ($workouts as $w): ?>
        <tr style="border-bottom: 1px solid #eee;">
            <td style="padding: 10px; border: 1px solid #ddd;"><?= htmlspecialchars($w['id']) ?></td>
            <td style="padding: 10px; border: 1px solid #ddd;"><?= htmlspecialchars($w['nama_workout']) ?></td>
            <td style="padding: 10px; border: 1px solid #ddd; font-family: monospace; font-size: 0.9em;"><?= htmlspecialchars($w['key_slug']) ?></td>
            <td style="padding: 10px; border: 1px solid #ddd; text-align: right;"><?= htmlspecialchars($w['met_value']) ?></td>
            
            <td style="padding: 10px; border: 1px solid #ddd; font-size: 0.9em;"><?= htmlspecialchars($w['fokus_otot']) ?></td>
            <td style="padding: 10px; border: 1px solid #ddd; font-size: 0.9em;"><?= htmlspecialchars($w['tujuan_utama']) ?></td>
            <td style="padding: 10px; border: 1px solid #ddd; text-align: center;">
                <span style="display: inline-block; padding: 4px 8px; border-radius: 10px; font-size: 0.8rem; font-weight: 600; background-color: <?= $w['is_active'] ? '#d4edda' : '#f8d7da' ?>; color: <?= $w['is_active'] ? '#155724' : '#721c24' ?>;">
                    <?= $w['is_active'] ? 'Aktif' : 'Nonaktif' ?>
                </span>
            </td>
            
        <td style="padding: 10px; border: 1px solid #ddd; text-align: center; white-space: nowrap;">
            <a href="index.php?action=admin_workout_edit&id=<?= $w['id'] ?>" style="background-color: #2980b9; color: white; padding: 5px 10px; border-radius: 5px; text-decoration: none; font-size: 0.9rem;">
                Edit
            </a>
                <?php if ($w['is_active']): // Hanya tampilkan tombol nonaktif jika sedang aktif ?>
                    <a href="index.php?action=admin_workouts&delete_id=<?= $w['id'] ?>" onclick="return confirm('Yakin ingin menonaktifkan workout <?= htmlspecialchars($w['nama_workout']) ?>?')" style="background-color: #e74c3c; color: white; padding: 5px 10px; border-radius: 5px; text-decoration: none; font-size: 0.9rem; margin-left: 5px;">
                        Nonaktifkan
                     </a>
        <?php endif; ?>
        </td>
        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="8" style="padding: 10px; text-align: center; color: #7f8c8d;">Belum ada data workout yang terdaftar.</td>
        </tr>
    <?php endif; ?>
</tbody>
        </table>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>