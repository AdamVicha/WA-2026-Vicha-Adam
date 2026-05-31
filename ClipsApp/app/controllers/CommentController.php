<?php
require_once '../app/models/Database.php';
require_once '../app/models/Comment.php';

class CommentController {
    
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
            $clipId = $_POST['clip_id'];
            $content = $_POST['content'];
            $userId = $_SESSION['user_id'];

            if (!empty(trim($content))) {
                $db = (new Database())->getConnection();
                $commentModel = new Comment($db);
                $commentModel->create($clipId, $userId, $content);
            }
            
            header("Location: " . BASE_URL . "/index.php?url=clip/show/" . $clipId);
            exit;
        }
    }

    public function delete($id = null) {
        if ($id && isset($_SESSION['user_id'])) {
            $db = (new Database())->getConnection();
            $commentModel = new Comment($db);
            $comment = $commentModel->getById($id);

            $isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
            if ($comment && ($comment['user_id'] == $_SESSION['user_id'] || $isAdmin)) {
                $commentModel->delete($id);
            }
            
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
            $id = $_POST['id'];
            $clip_id = $_POST['clip_id'];
            $content = $_POST['content'] ?? '';

            $db = (new Database())->getConnection();
            $commentModel = new Comment($db);
            $comment = $commentModel->getById($id);

            $isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
            if ($comment && ($comment['user_id'] == $_SESSION['user_id'] || $isAdmin)) {
                if (!empty(trim($content))) {
                    $commentModel->update($id, $content);
                    $_SESSION['flash_messages'][] = ['type' => 'success', 'text' => 'Komentář byl upraven.'];
                }
            }
            
            header("Location: " . BASE_URL . "/index.php?url=clip/show/" . $clip_id);
            exit;
        }
    }

    // Pojistka: Pokud někdo přistoupí na čisté /comment, přesměrujeme ho na hlavní stranu
    public function index() {
        header('Location: ' . BASE_URL);
        exit;
    }
}
?>