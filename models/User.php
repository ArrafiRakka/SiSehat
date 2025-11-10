<?php

class User {
    
    private $db; // untuk koneksi database

    // nyambungin ke db
    public function __construct() {
        // sesuai dengan db kita
        $this->db = new mysqli('localhost', 'root', '', 'SiSehat'); // Ganti 'rsiprak' jika perlu
        
        // Cek jika koneksi gagal
        if ($this->db->connect_error) {
            die("Koneksi database gagal: " . $this->db->connect_error);
        }
    }

    // ambil username/email dari db, kalo semisal gaada dia bakal ketolak
    public function getUserByEmailOrUsername($email_or_username) {
        
        $sql = "SELECT * FROM users WHERE email = ? OR username = ?";
        
        $stmt = $this->db->prepare($sql); 
        
        $stmt->bind_param("ss", $email_or_username, $email_or_username);
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }

    // method untuk user yg baru daftar 
    public function createUser($username, $email, $hashed_password) {
        
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        
        $stmt = $this->db->prepare($sql);
        
        $stmt->bind_param("sss", $username, $email, $hashed_password);
        
        if ($stmt->execute()) {
            return true; // Sukses
        } else {
            return false; // gagal (kalo semisal email udh kepake)
        }
    }

    public function getUserById($id) {
        // Ambil data (tanpa password)
        $sql = "SELECT id, username, email FROM users WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id); // 'i' untuk integer
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function updateUserProfile($id, $username, $email) {
        $sql = "UPDATE users SET username = ?, email = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssi", $username, $email, $id);
        return $stmt->execute();
    }

    public function updateUserPassword($id, $hashed_password) {
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("si", $hashed_password, $id);
        return $stmt->execute();
    }

} 
?>