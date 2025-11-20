<?php include 'views/layouts/header.php'; ?>

<div class="container" style="max-width: 800px; margin: 40px auto; padding: 0 20px;">
    
    <h1 style="color: #2c3e50; border-bottom: 3px solid #8e44ad; padding-bottom: 10px; margin-bottom: 30px;">
        ✏️ Edit Workout: <?= htmlspecialchars($workout['nama_workout'] ?? 'N/A') ?>
    </h1>

    <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #e0e0e0;">
        <form method="POST" action="index.php?action=admin_workout_edit&id=<?= htmlspecialchars($workout['id'] ?? '') ?>">
            
            <div style="margin-bottom: 20px;">
                <label for="nama_workout" style="display: block; font-weight: 600; margin-bottom: 5px; color: #34495e;">Nama Workout</label>
                <input type="text" id="nama_workout" name="nama_workout" required 
                       value="<?= htmlspecialchars($workout['nama_workout'] ?? '') ?>"
                       style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            </div>

            <div style="margin-bottom: 20px;">
                <label for="key_slug" style="display: block; font-weight: 600; margin-bottom: 5px; color: #34495e;">Key Slug (Kode Program)</label>
                <input type="text" id="key_slug" name="key_slug" required 
                       value="<?= htmlspecialchars($workout['key_slug'] ?? '') ?>"
                       placeholder="Contoh: lari, angkatBeban"
                       style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                <small style="color: #7f8c8d;">*Jangan ubah ini kecuali sangat diperlukan, karena digunakan untuk perhitungan user.</small>
            </div>
            
            <div style="margin-bottom: 20px;">
                <label for="met_value" style="display: block; font-weight: 600; margin-bottom: 5px; color: #34495e;">Nilai METs (Float)</label>
                <input type="number" step="0.01" id="met_value" name="met_value" required 
                       value="<?= htmlspecialchars($workout['met_value'] ?? '') ?>"
                       placeholder="Contoh: 9.80"
                       style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
            </div>

            <div style="margin-bottom: 25px;">
                <label style="display: block; font-weight: 600; margin-bottom: 10px; color: #34495e;">Status Workout</label>
                <?php $isActive = (int)($workout['is_active'] ?? 0); ?>
                
                <input type="checkbox" id="is_active" name="is_active" value="1" <?= $isActive ? 'checked' : '' ?> 
                       style="margin-right: 5px;">
                <label for="is_active" style="font-weight: normal; color: #555;">
                    Aktif (Tampilkan di kalkulator User)
                </label>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" name="edit_workout" 
                        style="padding: 10px 20px; background-color: #2980b9; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: 600; flex-grow: 1;">
                    Simpan Perubahan
                </button>
                <a href="index.php?action=admin_workouts" 
                   style="padding: 10px 20px; background-color: #95a5a6; color: white; border-radius: 5px; text-decoration: none; font-weight: 600;">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>