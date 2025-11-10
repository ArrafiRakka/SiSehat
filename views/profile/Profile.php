<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - SiSehat</title>
    
    <link rel="stylesheet" href="public/css/style.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <nav>
        <div class="logo">SiSehat</div>
        <ul>
            <li><a href="index.php?action=dashboard">Beranda</a></li>
            <li><a href="index.php?action=consultation">Konsultasi</a></li>
            <li><a href="index.php?action=workout">Workout</a></li>
            <li><a href="index.php?action=kalori">Kalori Harian</a></li>
            <li><a href="index.php?action=mealplan">Meal Plan</a></li>
            <li><a href="index.php?action=profile">Profil</a></li> </ul>
        <a href="index.php?action=logout" class="nav-logout">Logout ➔</a>
    </nav>

    <main class="container">
        <h1>Profil Saya</h1>
        <p class="subtitle">Update informasi dan data pribadi Anda di sini.</p>

        <form id="profile-form" method="POST" action="index.php?action=update_profile">
            <h3>Informasi Akun</h3>
            <!-- <div class="form-group">
                <label for="full_name">Nama Lengkap</label>
                <input type="text" id="full_name" name="full_name" value="Amien"> 
            </div> -->
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="amien_dev" readonly> 
                <small>Username tidak dapat diubah.</small>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="amien@email.com">
            </div>
            <!-- <div class="form-group">
                <label for="telepon">Telepon</label>
                <input type="text" id="telepon" name="telepon" value="08123456789">
            </div> -->
            <button type="submit" class="btn-submit">Simpan Perubahan</button>
        </form>

        <hr class="divider">

        <form id="password-form" method="POST" action="index.php?action=update_password">
            <h3>Ubah Password</h3>
            <div class="form-group">
                <label for="new_password">Password Baru</label>
                <input type="password" id="new_password" name="new_password" placeholder="Minimal 6 karakter">
            </div>
            <div class="form-group">
                <label for="confirm_password">Konfirmasi Password Baru</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Ulangi password baru">
            </div>
            <button type="submit" class="btn-submit">Ubah Password</button>
        </form>

    </main>

</body>
</html>