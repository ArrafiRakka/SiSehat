<?php include 'views/layouts/Header.php'; ?>

<?php
// Logika ini mengasumsikan $user (dari AuthController) sudah ada
// dan berisi data seperti ['username' => 'afi', 'email' => 'afi@...']

$initials = '??'; // Default

// Coba ambil dari full_name jika ada
if (!empty($user['full_name'])) {
    $names = explode(' ', $user['full_name']);
    $initials = strtoupper(substr($names[0], 0, 1));
    if (count($names) > 1) {
        $initials .= strtoupper(substr($names[count($names) - 1], 0, 1));
    }
} 
// Jika tidak, ambil dari username
elseif (!empty($user['username'])) {
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
  /* Reset */
  * {
    box-sizing: border-box;
  }
  body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    background-color: #f9f9f9;
    color: #333;
  }

  /* Container */
  .container {
    max-width: 660px;
    margin: 36px auto 60px;
    padding: 0 20px;
  }

  /* Profile Card */
  .profile-card {
    background: #fff;
    border-radius: 12px;
    padding: 50px 65px;
    box-shadow: 0 3px 6px rgb(0 0 0 / 0.1);
    margin-bottom: 24px;
  }
  .profile-header {
    display: flex;
    align-items: center;
    margin-bottom: 24px;
  }
  .profile-avatar {
    background-color: #db5757;
    color: #fff;
    width: 48px;
    height: 48px;
    border-radius: 50%;
    font-weight: 700;
    font-size: 1.25rem;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 14px;
    flex-shrink: 0;
  }
  .profile-name {
    margin: 0;
    font-weight: 700;
    font-size: 1.1rem;
    text-align: left;
  }
  .profile-subtitle {
    margin: 4px 0 0;
    font-size: 0.85rem;
    color: #999;
    font-weight: 500;
  }

  /* Form Fields */
  label {
    display: block;
    font-weight: 700;
    font-size: 0.85rem;
    margin-bottom: 6px;
  }
  input[type="text"],
  input[type="email"],
  input[type="password"] {
    width: 100%;
    padding: 20px 60px;
    border-radius: 10px;
    border: none;
    background-color: #f2f2f2;
    font-size: 0.9rem;
    color: #333;
    margin-bottom: 20px;
    font-weight: 500;
  }
  input[readonly] {
    cursor: default;
  }

  .password-field {
    position: relative;
    display: flex;
    align-items: center;
  }
  .password-field input {
    flex-grow: 1;
    margin-bottom: 0;
  }
  .show-password {
    position: absolute;
    right: 12px;
    font-size: 0.75rem;
    color: #db5757;
    background: none;
    border: none;
    cursor: pointer;
    font-weight: 600;
  }

  /* Profile Buttons */
  .profile-buttons {
    margin-top: 24px;
    display: flex;
    gap: 14px;
    justify-content: center;
  }
  .btn-edit {
    background-color: #db5757;
    border: none;
    color: white;
    font-weight: 600;
    border-radius: 12px;
    height: 42px;
    width: 180px;
    cursor: pointer;
    box-shadow: 0 4px 8px rgb(219 87 87 / 0.6);
    font-size: 0.9rem;
    transition: background-color 0.3s ease;
  }
  .btn-edit:hover {
    background-color: #bf4848;
  }
  .btn-logout {
    background: transparent;
    color: #db5757;
    font-weight: 600;
    border: 1.5px solid #db5757;
    border-radius: 12px;
    height: 42px;
    width: 150px;
    cursor: pointer;
    font-size: 0.9rem;
  }
  .btn-logout:hover {
    background-color: #db5757;
    color: white;
  }

  /* Feature Cards */
  .feature-card {
    background: white;
    border-radius: 12px;
    padding: 24px 20px;
    box-shadow: 0 3px 6px rgb(0 0 0 / 0.08);
    margin-bottom: 18px;
    text-align: center;
  }
  .feature-icon {
    width: 46px;
    height: 46px;
    border-radius: 50%;
    margin: 0 auto 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
  }
  .feature-icon.konsultasi {
    background-color: #e8f7e9;
    color: #339933;
  }
  .feature-icon.workout {
    background-color: #ffe7d8;
    color: #db5757;
  }
  .feature-icon.tracking {
    background-color: #ebe9ff;
    color: #5c59f7;
  }
  .feature-icon.meal {
    background-color: #f3e7ff;
    color: #db57c7;
  }
  .feature-title {
    font-weight: 700;
    margin: 0 0 6px;
    font-size: 1rem;
  }
  .feature-desc {
    margin: 0 0 10px;
    font-size: 0.85rem;
    color: #666;
  }
  .feature-link {
    font-size: 0.85rem;
    font-weight: 600;
    color: #db5757;
    text-decoration: none;
  }
  .feature-link:hover {
    text-decoration: underline;
  }

  /* Footer */
  footer {
    background-color: #292929;
    color: #ccc;
    padding: 36px 20px 18px;
    font-size: 0.85rem;
  }
  footer .footer-container {
    max-width: 940px;
    margin: 0 auto;
    display: flex;
    flex-wrap: wrap;
    gap: 40px;
    justify-content: space-between;
  }
  footer h4 {
    color: white;
    margin-top: 0;
    font-weight: 600;
    font-size: 1rem;
  }
  .footer-section {
    flex: 1 1 220px;
    min-width: 180px;
  }
  .footer-description {
    line-height: 1.4;
    color: #bbb;
    margin: 12px 0 22px;
  }
  .social-icons {
    display: flex;
    gap: 12px;
  }
  .social-icons a {
    background-color: #db5757;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    text-decoration: none;
    font-weight: 700;
    font-size: 0.9rem;
  }
  .footer-list {
    list-style: none;
    padding: 0;
    margin: 0;
  }
  .footer-list li {
    margin-bottom: 10px;
  }
  .footer-list li a {
    color: #bbb;
    text-decoration: none;
    font-weight: 500;
  }
  .footer-list li a:hover {
    text-decoration: underline;
  }
  .footer-contact p {
    margin: 6px 0;
    display: flex;
    align-items: center;
    gap: 6px;
    white-space: nowrap;
  }
  .footer-contact p svg,
  .footer-contact p span {
    font-size: 1rem;
  }
  /* Footer bottom text */
  .footer-bottom {
    border-top: 1px solid #444;
    text-align: center;
    margin-top: 32px;
    padding-top: 10px;
    color: #666;
    font-size: 0.8rem;
  }

  /* Icons inside footer contact (simple inline svg as fallback) */
  .icon-mail::before {
    content: "📧";
    display: inline-block;
  }
  .icon-phone::before {
    content: "📞";
    display: inline-block;
  }
  .icon-location::before {
    content: "📍";
    display: inline-block;
  }
</style>
</head>
<body>
<div class="container">

    <section class="profile-card">
    <div class="profile-header">
      <div class="profile-avatar"><?php echo htmlspecialchars($initials); ?></div>
      <div>
        <h2 class="profile-name"><?php echo htmlspecialchars($user['full_name'] ?? $user['username']); ?></h2>
        <p class="profile-subtitle">Pengguna SiSehat</p>
      </div>
    </div>
    
    <form method="POST" action="<?php echo BASE_URL; ?>index.php?action=update_profile">
    
      <label for="username">Username</label>
      <input id="username" name="username" type="text" value="<?php echo htmlspecialchars($user['username']); ?>" readonly />

      <label for="email">Email</label>
      <input id="email" name="email" type="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly />

      <label id="pass-label" for="new_password">Password</label>
      <div class="password-field">
          <input id="new_password" name="new_password" type="password" value="••••••••" readonly disabled />
          <button type="button" id="show-pass-btn" class="show-password" style="display: none;">Tampilkan</button>
      </div>

      <div class="profile-buttons">
        <button type="button" id="btn-edit" class="btn-edit">Edit Profil</button>
        
        <button type="submit" id="btn-save" class="btn-edit" style="display: none;">Simpan Perubahan</button>
      </div>
    </form>
  </section>

  <!-- <section class="feature-card">
    <div class="feature-icon konsultasi">🩺</div>
    <h3 class="feature-title">Konsultasi Online</h3>
    <p class="feature-desc">Konsultasi dengan dokter berpengalaman kapan saja</p>
    <a href="#" class="feature-link">Mulai Konsultasi →</a>
  </section>

  <section class="feature-card">
    <div class="feature-icon workout">💪</div>
    <h3 class="feature-title">Program Workout</h3>
    <p class="feature-desc">Program latihan yang disesuaikan dengan kebutuhan Anda</p>
    <a href="#" class="feature-link">Lihat Program →</a>
  </section>

  <section class="feature-card">
    <div class="feature-icon tracking">📊</div>
    <h3 class="feature-title">Tracking Kalori</h3>
    <p class="feature-desc">Pantau asupan kalori harian dengan mudah</p>
    <a href="#" class="feature-link">Mulai Tracking →</a>
  </section>

  <section class="feature-card">
    <div class="feature-icon meal">🍎</div>
    <h3 class="feature-title">Meal Plan</h3>
    <p class="feature-desc">Dapatkan rencana makanan sesuai dengan target kalori</p>
    <a href="#" class="feature-link">Lihat Meal Plan →</a>
  </section> -->

</div>
<?php include 'views/layouts/footer.php'; ?>

</body>
</html>