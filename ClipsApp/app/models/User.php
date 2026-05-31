<?php
class User {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;    
    }

    public function register($username, $email, $password) {
        if ($this->findByEmail($email)) return false;

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':username' => htmlspecialchars(strip_tags($username)),
            ':email' => htmlspecialchars(strip_tags($email)),
            ':password' => $hashedPassword
        ]);
    }

    public function findByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllUsers() {
        $sql = "SELECT id, username, email, role, created_at FROM users ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function getById($id) {
        $sql = "SELECT id, username, email, role, bio, avatar_path, created_at FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProfile($id, $bio, $avatarPath = null) {
        if ($avatarPath) {
            $sql = "UPDATE users SET bio = :bio, avatar_path = :avatar_path WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':bio' => htmlspecialchars(strip_tags($bio)), ':avatar_path' => $avatarPath, ':id' => $id]);
        } else {
            $sql = "UPDATE users SET bio = :bio WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':bio' => htmlspecialchars(strip_tags($bio)), ':id' => $id]);
        }
    }
}
?>