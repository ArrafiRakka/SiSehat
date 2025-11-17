<?php

class User {
    
    private $db;

    public function __construct() {
        // koneksi ke database *HARUS* seseuai dump
        $this->db = new mysqli('localhost', 'root', '', 'SiSehat');
        
        if ($this->db->connect_error) {
            die("Koneksi database gagal: " . $this->db->connect_error);
        }
    }

    /* ======================================
       GET USER BY EMAIL OR USERNAME
    ====================================== */
    public function getUserByEmailOrUsername($value) {

        $sql = "SELECT * FROM users WHERE email = ? OR username = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ss", $value, $value);
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            return $result->fetch_assoc();
        }
        return false;
    }

    /* ======================================
       REGISTER USER BARU
    ====================================== */
    public function createUser($username, $email, $hashed_password) {

        // Cek duplikasi email/username
        $checkUser = $this->getUserByEmailOrUsername($email);
        if ($checkUser) return false;

        $checkUser2 = $this->getUserByEmailOrUsername($username);
        if ($checkUser2) return false;

        $sql = "INSERT INTO users (username, email, password, role)
                VALUES (?, ?, ?, '')";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        return $stmt->execute();
    }

    /* ======================================
       GET USER BY ID
    ====================================== */
    public function getUserById($id) {
        $sql = "SELECT id, username, email, role FROM users WHERE id = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    /* ======================================
       UPDATE PROFIL (USERNAME / EMAIL)
    ====================================== */
    public function updateUserProfile($id, $username, $email) {
        $sql = "UPDATE users SET username = ?, email = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssi", $username, $email, $id);
        return $stmt->execute();
    }

    /* ======================================
       GANTI PASSWORD
    ====================================== */
    public function updateUserPassword($id, $hashed_password) {
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("si", $hashed_password, $id);
        return $stmt->execute();
    }
}

?>
