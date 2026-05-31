<?php
class Clip {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function create($title, $game, $videoPath, $description, $userId) {
        $sql = "INSERT INTO clips (user_id, title, game, video_path, description) 
                VALUES (:user_id, :title, :game, :video_path, :description)";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            ':user_id' => $userId,
            ':title' => htmlspecialchars(strip_tags($title)),
            ':game' => htmlspecialchars(strip_tags($game)),
            ':video_path' => $videoPath,
            ':description' => htmlspecialchars(strip_tags($description))
        ]);
    }

    public function getAllLatest($currentUserId = null) {
        $sql = "SELECT c.*, u.username as author_name, u.avatar_path,
                (SELECT COUNT(*) FROM upvotes WHERE clip_id = c.id) as upvote_count,
                (SELECT COUNT(*) FROM upvotes WHERE clip_id = c.id AND user_id = :user_id) as user_upvoted
                FROM clips c JOIN users u ON c.user_id = u.id ORDER BY c.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $currentUserId ?? 0]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id, $currentUserId = null) {
        $sql = "SELECT c.*, u.username as author_name, u.avatar_path,
                (SELECT COUNT(*) FROM upvotes WHERE clip_id = c.id) as upvote_count,
                (SELECT COUNT(*) FROM upvotes WHERE clip_id = c.id AND user_id = :user_id) as user_upvoted
                FROM clips c JOIN users u ON c.user_id = u.id WHERE c.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id, ':user_id' => $currentUserId ?? 0]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $sql = "DELETE FROM clips WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function update($id, $title, $game, $description) {
        $sql = "UPDATE clips SET title = :title, game = :game, description = :description WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':title' => htmlspecialchars(strip_tags($title)),
            ':game' => htmlspecialchars(strip_tags($game)),
            ':description' => htmlspecialchars(strip_tags($description)),
            ':id' => $id
        ]);
    }
}