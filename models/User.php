<?php
// models/User.php

class User {
    
    // Data dummy (ganti ini dengan koneksi database sungguhan)
    private $dummy_user = [
        'email' => 'admin@sisehat.com',
        'username' => 'admin',
        'password_hash' => '$2y$10$K.A.dkyR.fL.V.v.G.q.i.0e9G3h8.39a.7z6c.32g.1q.0u.9u' // Hash dari 'password123'
    ];

    /**
     * Mengambil data user berdasarkan email atau username.
     * Dalam aplikasi nyata, ini adalah query: "SELECT * FROM users WHERE email = ? OR username = ?"
     */
    public function getUserByEmailOrUsername($email_or_username) {
        if ($email_or_username === $this->dummy_user['email'] || $email_or_username === $this->dummy_user['username']) {
            return $this->dummy_user;
        }
        return false;
    }

    /**
     * Membuat user baru.
     * Dalam aplikasi nyata, ini adalah query: "INSERT INTO users (username, email, password) VALUES (?, ?, ?)"
     */
    public function createUser($username, $email, $hashed_password) {
        // Logika simulasi:
        // Cek jika user sudah ada (dummy check)
        if ($email === $this->dummy_user['email'] || $username === $this->dummy_user['username']) {
            return false; // Gagal, user sudah ada
        }
        
        // Simpan ke database...
        // echo "Simulasi: User '$username' berhasil dibuat.";
        return true; // Sukses
    }
}
?>