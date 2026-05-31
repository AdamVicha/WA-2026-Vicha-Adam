<?php
class Comment {
    private PDO $db;
    public function __construct(PDO $db) { $this->db = $db; }

    public function getByClipId($clipId) {
        $sql = "SELECT c.*, u.username, u.avatar_path 
                FROM comments c JOIN users u ON c.user_id = u.id 
                WHERE c.clip_id = ? ORDER BY c.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$clipId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($clipId, $userId, $content) {
        $sql = "INSERT INTO comments (clip_id, user_id, content) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$clipId, $userId, htmlspecialchars(strip_tags($content))]);
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM comments WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM comments WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function update($id, $content) {
        $sql = "UPDATE comments SET content = :content WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':content' => htmlspecialchars(strip_tags($content)),
            ':id' => $id
        ]);
    }
}
?>