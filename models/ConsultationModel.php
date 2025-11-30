<?php
class ConsultationModel {
    private $db;

    public function __construct() {
        $this->db = new mysqli('localhost', 'root', '', 'SiSehat', 3306);
        
        if ($this->db->connect_error) {
            die("Koneksi database gagal: " . $this->db->connect_error);
        }
        
        $this->db->set_charset("utf8mb4");
    }

    public function getAllNutritionists() {
        $sql = "SELECT id, name, specialty, city, experience, price, 
                rating, total_consultations, gender, img 
                FROM nutritionists 
                ORDER BY rating DESC, total_consultations DESC";
        
        $result = $this->db->query($sql);
        
        if (!$result) {
            error_log("Error fetching nutritionists: " . $this->db->error);
            return [];
        }
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getNutritionistById($id) {
        $sql = "SELECT id, name, specialty, city, experience, price, 
                rating, total_consultations, gender, img 
                FROM nutritionists 
                WHERE id = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function createConsultation($data) {
        // PERBAIKAN: Tambahkan start_time saat membuat konsultasi
        $sql = "INSERT INTO consultations 
                (user_id, nutritionist_id, payment_method, note, price, status, start_time, created_at) 
                VALUES (?, ?, ?, ?, ?, 'pending', NOW(), NOW())";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param(
            "iissd",
            $data['user_id'],
            $data['nutritionist_id'],
            $data['payment_method'],
            $data['note'],
            $data['price']
        );
        
        if ($stmt->execute()) {
            return $this->db->insert_id;
        }
        
        error_log("Error creating consultation: " . $stmt->error);
        return false;
    }

    public function updateConsultationStatus($consultationId, $status) {
        // PERBAIKAN: Set start_time ketika status berubah ke 'active'
        if ($status === 'active') {
            $sql = "UPDATE consultations SET status = ?, start_time = NOW() WHERE id = ?";
        } else {
            $sql = "UPDATE consultations SET status = ? WHERE id = ?";
        }
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("si", $status, $consultationId);
        
        return $stmt->execute();
    }

    public function getConsultationsByUserId($userId) {
        $sql = "SELECT c.*, n.name as nutritionist_name, n.specialty, n.img
                FROM consultations c
                JOIN nutritionists n ON c.nutritionist_id = n.id
                WHERE c.user_id = ?
                ORDER BY c.created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getConsultationById($consultationId) {
        $sql = "SELECT c.*, n.name as nutritionist_name, n.specialty, n.city, n.img,
                u.username, u.email
                FROM consultations c
                JOIN nutritionists n ON c.nutritionist_id = n.id
                JOIN users u ON c.user_id = u.id
                WHERE c.id = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $consultationId);
        $stmt->execute();
        
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function saveMessage($consultationId, $senderType, $message) {
        $sql = "INSERT INTO consultation_messages 
                (consultation_id, sender_type, message, created_at) 
                VALUES (?, ?, ?, NOW())";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("iss", $consultationId, $senderType, $message);
        
        return $stmt->execute();
    }

    public function getMessages($consultationId) {
        $sql = "SELECT * FROM consultation_messages 
                WHERE consultation_id = ? 
                ORDER BY created_at ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $consultationId);
        $stmt->execute();
        
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function saveConsultationResult($data) {
        $sql = "INSERT INTO consultation_results 
                (consultation_id, bmi, bmi_category, daily_intake_notes, habits_notes, 
                 special_conditions, meal_plan_breakfast, meal_plan_lunch, meal_plan_dinner, 
                 meal_plan_snacks, target_calories, meal_frequency, water_intake, 
                 physical_activity, doctor_notes, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param(
            "idssssssssissss",
            $data['consultation_id'],
            $data['bmi'],
            $data['bmi_category'],
            $data['daily_intake_notes'],
            $data['habits_notes'],
            $data['special_conditions'],
            $data['meal_plan_breakfast'],
            $data['meal_plan_lunch'],
            $data['meal_plan_dinner'],
            $data['meal_plan_snacks'],
            $data['target_calories'],
            $data['meal_frequency'],
            $data['water_intake'],
            $data['physical_activity'],
            $data['doctor_notes']
        );
        
        return $stmt->execute();
    }

    public function getConsultationResult($consultationId) {
        $sql = "SELECT cr.*, c.user_id, c.nutritionist_id, n.name as nutritionist_name
                FROM consultation_results cr
                JOIN consultations c ON cr.consultation_id = c.id
                JOIN nutritionists n ON c.nutritionist_id = n.id
                WHERE cr.consultation_id = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $consultationId);
        $stmt->execute();
        
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function incrementNutritionistConsultations($nutritionistId) {
        $sql = "UPDATE nutritionists 
                SET total_consultations = total_consultations + 1 
                WHERE id = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $nutritionistId);
        
        return $stmt->execute();
    }

    public function getConsultationCount() {
        $result = $this->db->query("SELECT COUNT(*) as total FROM consultations");
        $row = $result->fetch_assoc();
        return $row['total'];
    }

    // PERBAIKAN: Sederhanakan method ini
    public function updateConsultationFields($consultationId, $fields) {
        error_log("=== UPDATE CONSULTATION FIELDS ===");
        error_log("Consultation ID: " . $consultationId);
        error_log("Fields to update: " . print_r($fields, true));
        
        $setClauses = [];
        $types = '';
        $values = [];

        foreach ($fields as $key => $value) {
            $setClauses[] = "`$key` = ?";
            $values[] = $value;
            
            // Tentukan tipe data
            if (is_int($value)) {
                $types .= 'i';
            } elseif (is_float($value)) {
                $types .= 'd';
            } else {
                $types .= 's';
            }
        }
        
        $values[] = $consultationId;
        $types .= 'i';
        
        $sql = "UPDATE consultations SET " . implode(', ', $setClauses) . " WHERE id = ?";
        error_log("SQL: " . $sql);
        error_log("Types: " . $types);
        error_log("Values: " . print_r($values, true));
        
        $stmt = $this->db->prepare($sql);
        
        if (!$stmt) {
            error_log("Prepare failed: " . $this->db->error);
            return false;
        }
        
        // Binding parameter dinamis
        $refs = [];
        foreach ($values as $key => $value) {
            $refs[$key] = &$values[$key];
        }
        array_unshift($refs, $types);
        
        call_user_func_array([$stmt, 'bind_param'], $refs);
        
        $result = $stmt->execute();
        
        if (!$result) {
            error_log("Execute failed: " . $stmt->error);
            return false;
        }
        
        error_log("Affected rows: " . $stmt->affected_rows);
        return true; // Return true jika berhasil execute, meski affected_rows = 0
    }

    public function getConsultationResultAndDetails($consultationId, $userId) {
        $sql = "
            SELECT 
                cr.*, 
                c.start_time, c.end_time, c.duration_minutes, c.status,
                n.name AS nutritionist_name,
                n.specialty,
                n.img AS nutritionist_img
            FROM consultation_results cr
            JOIN consultations c ON cr.consultation_id = c.id
            JOIN nutritionists n ON c.nutritionist_id = n.id
            WHERE cr.consultation_id = ? AND c.user_id = ?
        ";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $consultationId, $userId);
        $stmt->execute();
        
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

// Tambahkan method-method ini di ConsultationModel.php

/**
 * Ambil semua konsultasi untuk admin dengan filter status
 */
public function getAllConsultationsForAdmin($status = 'all') {
    $sql = "SELECT 
                c.id, 
                c.user_id, 
                c.nutritionist_id, 
                c.status, 
                c.payment_method, 
                c.price, 
                c.start_time, 
                c.end_time, 
                c.duration_minutes,
                c.created_at,
                u.username,
                u.email,
                n.name as nutritionist_name,
                n.specialty
            FROM consultations c
            JOIN users u ON c.user_id = u.id
            JOIN nutritionists n ON c.nutritionist_id = n.id";
    
    if ($status !== 'all') {
        $sql .= " WHERE c.status = ?";
    }
    
    $sql .= " ORDER BY c.created_at DESC";
    
    if ($status !== 'all') {
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $status);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $result = $this->db->query($sql);
    }
    
    return $result->fetch_all(MYSQLI_ASSOC);
}

/**
 * Tambah Ahli Gizi Baru
 */
public function addNutritionist($name, $specialty, $city, $experience, $price, $gender, $img) {
    $sql = "INSERT INTO nutritionists 
            (name, specialty, city, experience, price, gender, img, rating, total_consultations) 
            VALUES (?, ?, ?, ?, ?, ?, ?, 5.0, 0)";
    
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("sssidss", $name, $specialty, $city, $experience, $price, $gender, $img);
    
    return $stmt->execute();
}

/**
 * Update Ahli Gizi
 */
public function updateNutritionist($id, $name, $specialty, $city, $experience, $price, $gender, $img) {
    $sql = "UPDATE nutritionists 
            SET name = ?, specialty = ?, city = ?, experience = ?, 
                price = ?, gender = ?, img = ?
            WHERE id = ?";
    
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("sssidssi", $name, $specialty, $city, $experience, $price, $gender, $img, $id);
    
    return $stmt->execute();
}

/**
 * Hapus Ahli Gizi
 */
public function deleteNutritionist($id) {
    $sql = "DELETE FROM nutritionists WHERE id = ?";
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("i", $id);
    
    return $stmt->execute();
}

/**
 * Cek jumlah konsultasi aktif berdasarkan ahli gizi
 */
public function countActiveConsultationsByNutritionist($nutritionistId) {
    $sql = "SELECT COUNT(*) as count 
            FROM consultations 
            WHERE nutritionist_id = ? AND status = 'active'";
    
    $stmt = $this->db->prepare($sql);
    $stmt->bind_param("i", $nutritionistId);
    $stmt->execute();
    
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    return (int)$row['count'];
}

/**
 * Statistik Dashboard Admin
 */
public function getConsultationStats() {
    $stats = [];
    
    // Total konsultasi
    $result = $this->db->query("SELECT COUNT(*) as total FROM consultations");
    $stats['total'] = $result->fetch_assoc()['total'];
    
    // Konsultasi aktif
    $result = $this->db->query("SELECT COUNT(*) as active FROM consultations WHERE status = 'active'");
    $stats['active'] = $result->fetch_assoc()['active'];
    
    // Konsultasi completed
    $result = $this->db->query("SELECT COUNT(*) as completed FROM consultations WHERE status = 'completed'");
    $stats['completed'] = $result->fetch_assoc()['completed'];
    
    // Konsultasi pending
    $result = $this->db->query("SELECT COUNT(*) as pending FROM consultations WHERE status = 'pending'");
    $stats['pending'] = $result->fetch_assoc()['pending'];
    
    // Total revenue
    $result = $this->db->query("SELECT SUM(price) as revenue FROM consultations WHERE status IN ('active', 'completed')");
    $stats['revenue'] = $result->fetch_assoc()['revenue'] ?? 0;
    
    // Total ahli gizi
    $result = $this->db->query("SELECT COUNT(*) as nutritionists FROM nutritionists");
    $stats['nutritionists'] = $result->fetch_assoc()['nutritionists'];
    
    return $stats;
}

}
?>