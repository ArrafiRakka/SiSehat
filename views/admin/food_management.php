<?php include 'views/layouts/header.php'; ?>

<style>
    /* CSS Khusus Halaman Ini */
    .admin-container {
        max-width: 900px;
        margin: 40px auto;
        padding: 0 20px;
        font-family: 'Segoe UI', sans-serif;
    }

    /* Card Style */
    .admin-card {
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        margin-bottom: 30px;
    }

    /* Form Grid System */
    .food-form {
        display: grid;
        grid-template-columns: 1fr 1fr; /* 2 Kolom */
        gap: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    /* Agar Nama Makanan & Tombol memenuhi lebar (span 2 kolom) */
    .full-width {
        grid-column: span 2;
    }

    /* Label & Input Styling */
    .food-form label {
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 8px;
        color: #444;
    }

    .food-form input {
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 1rem;
        transition: border 0.3s;
        background: #fdfdfd;
    }

    .food-form input:focus {
        border-color: #db5757;
        outline: none;
        background: #fff;
    }

    /* Tombol Simpan */
    .btn-submit {
        background: #db5757;
        color: white;
        border: none;
        padding: 14px;
        border-radius: 8px;
        font-weight: bold;
        font-size: 1rem;
        cursor: pointer;
        transition: background 0.2s;
        margin-top: 10px;
    }
    .btn-submit:hover {
        background: #c0392b;
    }

    /* Tabel Styling */
    .food-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }
    .food-table th {
        background: #f8f9fa;
        padding: 15px;
        text-align: left;
        font-size: 0.9rem;
        color: #666;
        border-bottom: 2px solid #eee;
    }
    .food-table td {
        padding: 15px;
        border-bottom: 1px solid #eee;
    }
    .badge {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.85rem;
        font-weight: 600;
    }
    .badge-cal { background: #fff3e0; color: #f57c00; }
    .badge-prot { background: #e8f5e9; color: #2e7d32; }
    .badge-carb { background: #e3f2fd; color: #1565c0; }
    .badge-fat { background: #ffebee; color: #c62828; }

    /* Responsif untuk HP */
    @media (max-width: 600px) {
        .food-form { grid-template-columns: 1fr; } /* Jadi 1 kolom di HP */
        .full-width { grid-column: span 1; }
    }
</style>

<div class="admin-container">
    
    <div style="margin-bottom: 25px; text-align: center;">
        <h2 style="margin: 0; color: #2c3e50;">Kelola Database Makanan</h2>
        <p style="margin: 5px 0 0; color: #7f8c8d;">Tambah, edit, atau hapus data nutrisi makanan.</p>
    </div>

    <div class="admin-card">
        <h3 style="margin-top: 0; color: #db5757; margin-bottom: 20px;">+ Tambah Makanan Baru (per 100g)</h3>
        
        <form method="POST" action="index.php?action=admin_food" class="food-form">
            
            <div class="form-group full-width">
                <label>Nama Makanan</label>
                <input type="text" name="name" placeholder="Contoh: Nasi Goreng Spesial" required>
            </div>
            
            <div class="form-group">
                <label>Kalori (kkal)</label>
                <input type="number" step="0.1" name="calories" placeholder="0" required>
            </div>
            
            <div class="form-group">
                <label>Protein (g)</label>
                <input type="number" step="0.1" name="protein" placeholder="0" required>
            </div>

            <div class="form-group">
                <label>Karbohidrat (g)</label>
                <input type="number" step="0.1" name="carbs" placeholder="0" required>
            </div>

            <div class="form-group">
                <label>Lemak (g)</label>
                <input type="number" step="0.1" name="fats" placeholder="0" required>
            </div>

            <button type="submit" name="add_food" class="btn-submit full-width">Simpan Makanan</button>
        </form>
    </div>

    <div class="admin-card" style="padding: 0; overflow: hidden;">
        <div style="padding: 20px; background: #fff; border-bottom: 1px solid #eee;">
            <h3 style="margin: 0; font-size: 1.1rem;">Daftar Makanan Tersedia</h3>
        </div>
        
        <div style="overflow-x: auto;">
            <table class="food-table">
                <thead>
                    <tr>
                        <th>Nama Makanan</th>
                        <th style="text-align: center;">Kalori</th>
                        <th style="text-align: center;">Protein</th>
                        <th style="text-align: center;">Karbo</th>
                        <th style="text-align: center;">Lemak</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($foods)): ?>
                        <?php foreach ($foods as $food): ?>
                        <tr>
                            <td style="font-weight: 600; color: #333;"><?= htmlspecialchars($food['name']) ?></td>
                            <td style="text-align: center;"><span class="badge badge-cal"><?= $food['calories'] ?> kkal</span></td>
                            <td style="text-align: center;"><span class="badge badge-prot"><?= $food['protein'] ?>g</span></td>
                            <td style="text-align: center;"><span class="badge badge-carb"><?= $food['carbs'] ?>g</span></td>
                            <td style="text-align: center;"><span class="badge badge-fat"><?= $food['fats'] ?>g</span></td>
                            <td style="text-align: right;">
                                <a href="index.php?action=admin_food_edit&id=<?= $food['id'] ?>" 
                                   style="color: #f39c12; text-decoration: none; font-weight: bold; font-size: 0.9rem; border: 1px solid #f39c12; padding: 6px 12px; border-radius: 6px; margin-right: 5px;">
                                   Edit
                                </a>

                                <a href="index.php?action=admin_food&delete_id=<?= $food['id'] ?>" 
                                   onclick="return confirm('Yakin ingin menghapus <?= htmlspecialchars($food['name']) ?>?')" 
                                   style="color: #e74c3c; text-decoration: none; font-weight: bold; font-size: 0.9rem; border: 1px solid #e74c3c; padding: 6px 12px; border-radius: 6px;">
                                   Hapus
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 30px; color: #999;">Belum ada data makanan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php include 'views/layouts/footer.php'; ?>