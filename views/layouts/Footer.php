  </main>

  <footer class="footer">
    <div class="container">
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
            <li><a href="#">BMI</a></li>
            <li><a href="#">Konsultasi Online</a></li>
            <li><a href="#">Program Workout</a></li>
            <li><a href="#">Tracking Kalori Harian</a></li>
            <li><a href="#">Meal Plan</a></li>
          </ul>
        </div>

        <div class="footer-section">
          <h3>Kontak</h3>
          <div class="contact-item">
            <span>📧</span>
            <a href="mailto:info@sisehat.com">info@sisehat.com</a>
          </div>
          <div class="contact-item">
            <span>📞</span>
            <a href="tel:+622112345678">+62 21 1234 5678</a>
          </div>
          <div class="contact-item">
            <span>📍</span>
            <span>Jakarta, Indonesia</span>
          </div>
        </div>
      </div>

      <div class="footer-bottom">
        © 2025 SiSehat. Semua hak dilindungi undang-undang.
      </div>
    </div>
  </footer>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // --- 1. SKRIP UNTUK TOMBOL EDIT/SAVE (BARU) ---
        const btnEdit = document.getElementById('btn-edit');
        const btnSave = document.getElementById('btn-save');
        const inputUsername = document.getElementById('username');
        const inputEmail = document.getElementById('email');
        const inputPassword = document.getElementById('new_password');
        const showPassBtn = document.getElementById('show-pass-btn');
        const passwordLabel = document.getElementById('pass-label');

        if (btnEdit) {
            btnEdit.addEventListener('click', function() {
                // Aktifkan input
                inputUsername.removeAttribute('readonly');
                inputEmail.removeAttribute('readonly');
                
                // Aktifkan input password
                inputPassword.removeAttribute('readonly');
                inputPassword.removeAttribute('disabled'); // <-- Penting!
                inputPassword.value = ''; // Kosongkan value '••••••••'
                inputPassword.placeholder = 'Masukkan password baru';
                
                // Ubah label password
                if (passwordLabel) passwordLabel.textContent = 'Ganti Password';
                
                // Tampilkan tombol "Tampilkan"
                if (showPassBtn) showPassBtn.style.display = 'block';

                // Tukar tombol
                btnEdit.style.display = 'none';
                btnSave.style.display = 'block';

                // Fokus ke input pertama
                inputUsername.focus();
            });
        }

        // --- 2. SKRIP "TAMPILKAN" (DIMODIFIKASI) ---
        // Pastikan ini menargetkan tombol yang benar
        if (showPassBtn && inputPassword) {
            
            showPassBtn.addEventListener('click', function() {
                const type = inputPassword.getAttribute('type') === 'password' ? 'text' : 'password';
                inputPassword.setAttribute('type', type);
                this.textContent = (type === 'text') ? 'Sembunyikan' : 'Tampilkan';
            });
        }

    });
    </script>
</body>
</html>
