<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Footer SiSehat</title>
<style>
  body {
    margin: 0;
    background-color: #282828;
    font-family: Arial, sans-serif;
    color: #a0a0a0;
  }

  .footer {
    background-color: #282828;
    padding: 40px 60px 20px 60px;
    box-sizing: border-box;
  }

  .footer-content {
    display: flex;
    justify-content: space-between;
    margin-bottom: 30px;
    max-width: 1000px;
    margin-left: auto;
    margin-right: auto;
  }

  .footer-section {
    flex: 1;
    max-width: 300px;
  }

  .footer-section h3 {
    color: #fff;
    font-weight: bold;
    margin-bottom: 15px;
    font-size: 18px;
  }

  .footer-section p,
  .footer-section li,
  .footer-section a {
    font-weight: normal;
    font-size: 15px;
    color: #a0a0a0;
    line-height: 1.6;
    margin: 8px 0;
    text-decoration: none;
    display: block;
  }

  .footer-section ul {
    list-style: none;
    padding-left: 0;
    margin: 0;
  }

  .social-icons {
    margin-top: 15px;
  }

  .social-icons a {
    background-color: #d04f4f;
    color: #fff;
    font-weight: bold;
    width: 42px;
    height: 42px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    margin-right: 15px;
    font-size: 18px;
    text-decoration: none;
    user-select: none;
    transition: background-color 0.3s ease;
  }

  .social-icons a:hover {
    background-color: #b94444;
  }

  .footer-section .contact-item {
    display: flex;
    align-items: center;
    margin: 8px 0;
  }

  .footer-section .contact-item span {
    margin-right: 8px;
    font-size: 17px;
  }

  .footer-bottom {
    border-top: 1px solid #444;
    padding-top: 18px;
    text-align: center;
    color: #a0a0a0;
    font-size: 14px;
    max-width: 1000px;
    margin-left: auto;
    margin-right: auto;
  }
</style>
</head>
<body>

<footer class="footer">
  <div class="footer-content">
    <div class="footer-section">
      <h3>SiSehat</h3>
      <p>Platform kesehatan terpadu yang menghubungkan Anda dengan layanan kesehatan berkualitas.</p>
      <div class="social-icons">
        <a href="#" aria-label="Facebook">f</a>
        <a href="#" aria-label="Twitter">t</a>
        <a href="#" aria-label="Instagram">i</a>
      </div>
    </div>
    <div class="footer-section">
      <h3>Layanan</h3>
      <ul>
        <li><a href="#">Konsultasi Online</a></li>
        <li><a href="#">Program Workout</a></li>
        <li><a href="#">Tracking Kalori Harian</a></li>
        <li><a href="#">Meal Plan</a></li>
      </ul>
    </div>
    <div class="footer-section">
      <h3>Kontak</h3>
      <div class="contact-item"><span>📧</span><a href="mailto:info@sisehat.com">info@sisehat.com</a></div>
      <div class="contact-item"><span>📞</span><a href="tel:+622112345678">+62 21 1234 5678</a></div>
      <div class="contact-item"><span>📍</span><span>Jakarta, Indonesia</span></div>
    </div>
  </div>
  <div class="footer-bottom">
    © 2025 SiSehat. Semua hak dilindungi undang-undang.
  </div>
</footer>

</body>
</html>