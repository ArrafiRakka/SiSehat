<?php include 'views/layouts/Header.php'; ?>

<?php
// Pastikan variabel $user tersedia. Jika tidak, set array kosong agar tidak error.
$user = $user ?? [];

$initials = '??'; // Default inisial

// Logika membuat inisial dari nama
if (!empty($user['full_name'])) {
    $names = explode(' ', $user['full_name']);
    $initials = strtoupper(substr($names[0], 0, 1));
    if (count($names) > 1) {
        $initials .= strtoupper(substr($names[count($names) - 1], 0, 1));
    }
} elseif (!empty($user['username'])) {
    $initials = strtoupper(substr($user['username'], 0, 2));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>SiSehat Profile</title>
<style>
  /* --- Reset & Base --- */
  * { box-sizing: border-box; }
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    background-color: #f5f7fa;
    color: #333;
  }

  /* --- Container --- */
  .container {
    max-width: 500px;
    margin: 40px auto 60px;
    padding: 0 20px;
  }

  /* --- Profile Card --- */
  .profile-card {
    background: #fff;
    border-radius: 16px;
    padding: 40px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
  }

  /* --- Header --- */
  .profile-header {
    display: flex;
    align-items: center;
    margin-bottom: 35px;
  }
  .profile-avatar {
    background-color: #db5757;
    color: #fff;
    width: 70px;
    height: 70px;
    border-radius: 50%;
    font-weight: 600;
    font-size: 1.8rem;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 20px;
    flex-shrink: 0;
  }
  .profile-name {
    margin: 0;
    font-weight: 700;
    font-size: 1.4rem;
    color: #2c3e50;
    text-align: left;
  }
  .profile-subtitle {
    margin: 5px 0 0;
    font-size: 0.9rem;
    color: #95a5a6;
    font-weight: 500;
  }

  /* --- Form Inputs --- */
  label {
    display: block;
    font-weight: 600;
    font-size: 0.9rem;
    margin-bottom: 8px;
    color: #555;
    margin-top: 20px;
  }
  
  input[type="text"],
  input[type="email"],
  input[type="password"] {
    width: 100%;
    padding: 14px 16px;
    border-radius: 8px;
    border: 1px solid #ddd; /* Border abu-abu halus */
    background-color: #fff;
    font-size: 1rem;
    color: #333;
    transition: all 0.3s ease;
    outline: none;
  }

  /* Style saat Mode Baca (Readonly) */
  input[readonly] {
    background-color: #f9f9f9; /* Abu-abu sangat muda */
    color: #666;
    border-color: #eee;
    cursor: default;
  }

  /* Style saat Mode Edit (Aktif) */
  input:not([readonly]) {
    border-color: #db5757; /* Border merah */
    background-color: #fff;
    box-shadow: 0 0 0 3px rgba(219, 87, 87, 0.1);
  }

  /* --- PASSWORD FIELD FIX (PENTING) --- */
  .password-field {
    position: relative;
    width: 100%;
  }
  
  .password-field input {
    width: 100%;
    padding-right: 90px; /* Memberi ruang kosong di kanan agar teks tidak nabrak tombol */
    margin-bottom: 0; /* Reset margin bawaan */
  }

  .show-password {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%); /* Tepat di tengah vertikal */
    font-size: 0.85rem;
    color: #db5757;
    background: transparent;
    border: none;
    cursor: pointer;
    font-weight: 600;
    z-index: 2;
    padding: 5px;
  }
  .show-password:hover {
    text-decoration: underline;
  }
  
  /* Helper Text */
  #pass-hint {
    display: none; /* Sembunyi default */
    margin-top: 8px;
    font-size: 0.85rem;
    color: #7f8c8d;
  }

  /* --- Buttons --- */
  .profile-buttons {
    margin-top: 35px;
    display: flex;
    gap: 15px;
  }
  
  .action-buttons {
    display: none; /* Sembunyi default */
    width: 100%;
    gap: 15px;
  }

  .btn-edit, .btn-save, .btn-cancel {
    flex: 1;
    border: none;
    font-weight: 600;
    border-radius: 8px;
    height: 48px;
    font-size: 1rem;
    cursor: pointer;
    transition: opacity 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .btn-edit {
    background-color: #db5757;
    color: white;
    width: 100%;
    box-shadow: 0 4px 10px rgba(219, 87, 87, 0.3);
  }
  
  .btn-cancel {
    background-color: #95a5a6;
    color: white;
  }
  
  .btn-save {
    background-color: #2ecc71;
    color: white;
    box-shadow: 0 4px 10px rgba(46, 204, 113, 0.3);
  }
  
  .btn-edit:hover, .btn-save:hover, .btn-cancel:hover {
    opacity: 0.9;
  }

  /* Notifikasi Sukses */
  .alert-success {
    background: #d4edda;
    color: #155724;
    padding: 12px;
    border-radius: 8px;
    margin-bottom: 20px;
    text-align: center;
    font-size: 0.9rem;
    border: 1px solid #c3e6cb;
  }
</style>
</head>
<body>

<div class="container">

    <section class="profile-card">
    
    <?php if (isset($_GET['status']) && $_GET['status'] == 'updated'): ?>
        <div class="alert-success">
            Profil berhasil diperbarui!
        </div>
    <?php endif; ?>

    <div class="profile-header">
      <div class="profile-avatar"><?php echo htmlspecialchars($initials); ?></div>
      <div>
        <h2 class="profile-name"><?php echo htmlspecialchars($user['full_name'] ?? $user['username']); ?></h2>
        <p class="profile-subtitle">Pengguna SiSehat</p>
      </div>
    </div>
    
    <form id="profileForm" method="POST" action="index.php?action=update_profile">
    
      <label for="username">Username</label>
      <input id="username" name="username" type="text" value="<?php echo htmlspecialchars($user['username'] ?? ''); ?>" readonly required />

      <label for="email">Email</label>
      <input id="email" name="email" type="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" readonly required />

      <label for="new_password">Password</label>
      <div class="password-field">
          <input id="new_password" name="new_password" type="password" placeholder="••••••••" readonly disabled />
          
          <button type="button" id="show-pass-btn" class="show-password" style="display: none;">Tampilkan</button>
      </div>
      <small id="pass-hint">Kosongkan jika tidak ingin mengubah password.</small>

      <div class="profile-buttons">
        <button type="button" id="btn-edit" class="btn-edit">Edit Profil</button>
        
        <div id="edit-actions" class="action-buttons">
             <button type="button" id="btn-cancel" class="btn-cancel">Batal</button>
             <button type="submit" id="btn-save" class="btn-save">Simpan</button>
        </div>
      </div>
    </form>
  </section>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnEdit = document.getElementById('btn-edit');
    const editActions = document.getElementById('edit-actions');
    const btnCancel = document.getElementById('btn-cancel');
    
    // Ambil semua input kecuali password
    const textInputs = document.querySelectorAll('#profileForm input[type="text"], #profileForm input[type="email"]');
    
    const passInput = document.getElementById('new_password');
    const showPassBtn = document.getElementById('show-pass-btn');
    const passHint = document.getElementById('pass-hint');
    
    // Simpan nilai asli buat tombol Batal
    const originalValues = {};
    textInputs.forEach(input => {
        originalValues[input.id] = input.value;
    });

    // --- 1. KLIK EDIT PROFIL ---
    btnEdit.addEventListener('click', function() {
        // UI Toggle
        btnEdit.style.display = 'none';
        editActions.style.display = 'flex';
        
        // Buka Input Teks
        textInputs.forEach(input => {
            input.removeAttribute('readonly');
        });

        // Buka Input Password
        passInput.removeAttribute('readonly');
        passInput.removeAttribute('disabled');
        passInput.value = ''; // Kosongkan biar user ngetik baru
        passInput.placeholder = 'Masukkan password baru...'; // Placeholder baru

        // Tampilkan Helper Password
        showPassBtn.style.display = 'block';
        passHint.style.display = 'block';
        
        // Fokus ke Username
        document.getElementById('username').focus();
    });

    // --- 2. KLIK BATAL ---
    btnCancel.addEventListener('click', function() {
        // UI Toggle
        btnEdit.style.display = 'flex';
        editActions.style.display = 'none';
        
        // Reset Input Teks
        textInputs.forEach(input => {
            input.setAttribute('readonly', true);
            input.value = originalValues[input.id]; // Balikin nilai lama
        });

        // Reset Input Password
        passInput.setAttribute('readonly', true);
        passInput.setAttribute('disabled', true);
        passInput.value = ''; 
        passInput.placeholder = '••••••••';
        passInput.type = 'password'; // Pastikan balik jadi bintang-bintang
        
        // Sembunyikan Helper
        showPassBtn.style.display = 'none';
        showPassBtn.textContent = 'Tampilkan';
        passHint.style.display = 'none';
    });

    // --- 3. TOGGLE PASSWORD (LIHAT/SEMBUNYI) ---
    showPassBtn.addEventListener('click', function() {
        if (passInput.type === 'password') {
            passInput.type = 'text';
            this.textContent = 'Sembunyikan';
        } else {
            passInput.type = 'password';
            this.textContent = 'Tampilkan';
        }
    });
});
</script>

<?php include 'views/layouts/footer.php'; ?>

</body>
</html>