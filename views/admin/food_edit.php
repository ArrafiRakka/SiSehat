<?php include 'views/layouts/header.php'; ?>

<style>
    /* --- CSS Khusus Halaman Edit --- */
    body {
        background-color: #f5f7fa; /* Background abu muda */
    }

    .edit-container {
        max-width: 600px; /* Lebar fokus agar tidak terlalu lebar */
        margin: 50px auto;
        padding: 0 20px;
        font-family: 'Segoe UI', sans-serif;
    }

    .edit-card {
        background: white;
        padding: 40px;
        border-radius: 16px; /* Sudut lebih membulat */
        box-shadow: 0 10px 30px rgba(0,0,0,0.08); /* Bayangan halus */
    }

    .form-title {
        margin-top: 0;
        color: #2c3e50;
        text-align: center;
        font-size: 1.8rem;
        margin-bottom: 10px;
    }
    
    .form-subtitle {
        text-align: center;
        color: #7f8c8d;
        margin-bottom: 30px;
        font-size: 0.95rem;
    }

    /* Grid System untuk Form */
    .edit-form {
        display: grid;
        grid-template-columns: 1fr 1fr; /* 2 Kolom */
        gap: 20px;
    }

    .full-width {
        grid-column: span 2; /* Elemen membentang penuh */
    }

    /* Input Styling */
    .edit-form label {
        display: block;
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 8px;
        color: #555;
    }

    .edit-form input {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s;
        background: #fdfdfd;
        box-sizing: border-box; /* Penting agar padding tidak nambah lebar */
    }

    .edit-form input:focus {
        border-color: #db5757;
        background: #fff;
        outline: none;
        box-shadow: 0 0 0 3px rgba(219, 87, 87, 0.1);
    }

    /* Buttons */
    .btn-group {
        grid-column: span 2;
        display: flex;
        gap: 15px;
        margin-top: 10px;
    }

    .btn-save {
        flex: 2; /* Tombol simpan lebih lebar */
        background: #27ae60; /* Hijau segar */
        color: white;
        border: none;
        padding: 14px;
        border-radius: 8px;
        font-weight: bold;
        font-size: 1rem;
        cursor: pointer;
        transition: background 0.2s;
    }
    .btn-save:hover { background: #219150; }

    .btn-cancel {
        flex: 1;
        background: #95a5a6;
        color: white;
        text-decoration: none;
        padding: 14px;
        border-radius: 8px;
        font-weight: bold;
        font-size: 1rem;
        text-align: center;
        transition: background 0.2s;
        display: inline-block;
    }
    .btn-cancel:hover { background: #7f8c8d; }
    
    /* Input suffix (g/kkal) styling optional */
    .input-wrapper {
        position: relative;
    }
    .input-suffix {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #999;
        font-size: 0.85rem;
        pointer-events: none;
    }
</style>

<div class="edit-container">
    <div class="edit-card">
        <h2 class="form-title">Edit Makanan</h2>
        <p class="form-subtitle">Perbarui informasi nutrisi per 100 gram.</p>
        
        <form method="POST" action="index.php?action=admin_food_edit&id=<?= $food['id'] ?>" class="edit-form">
            
            <div class="full-width">
                <label>Nama Makanan</label>
                <input type="text" name="name" value="<?= htmlspecialchars($food['name']) ?>" required>
            </div>
            
            <div>
                <label>Kalori</label>
                <div class="input-wrapper">
                    <input type="number" step="0.1" name="calories" value="<?= $food['calories'] ?>" required>
                    <span class="input-suffix">kkal</span>
                </div>
            </div>
            
            <div>
                <label>Protein</label>
                <div class="input-wrapper">
                    <input type="number" step="0.1" name="protein" value="<?= $food['protein'] ?>" required>
                    <span class="input-suffix">g</span>
                </div>
            </div>

            <div>
                <label>Karbohidrat</label>
                <div class="input-wrapper">
                    <input type="number" step="0.1" name="carbs" value="<?= $food['carbs'] ?>" required>
                    <span class="input-suffix">g</span>
                </div>
            </div>

            <div>
                <label>Lemak</label>
                <div class="input-wrapper">
                    <input type="number" step="0.1" name="fats" value="<?= $food['fats'] ?>" required>
                    <span class="input-suffix">g</span>
                </div>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn-save">Update Data</button>
                <a href="index.php?action=admin_food" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>