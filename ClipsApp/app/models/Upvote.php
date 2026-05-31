<?php
class Upvote {
    private PDO $db;

    public function __construct(PDO $db) { $this->db = $db; }

    public function toggle($clipId, $userId) {
        $stmt = $this->db->prepare("SELECT * FROM upvotes WHERE clip_id = ? AND user_id = ?");
        $stmt->execute([$clipId, $userId]);
        
        if ($stmt->fetch()) {
            $stmt = $this->db->prepare("DELETE FROM upvotes WHERE clip_id = ? AND user_id = ?");
            $stmt->execute([$clipId, $userId]);
            return false;
        } else {
            $stmt = $this->db->prepare("INSERT INTO upvotes (clip_id, user_id) VALUES (?, ?)");
            $stmt->execute([$clipId, $userId]);
            return true;
        }
    }
}
?>