<?php
require_once '../app/models/Database.php';
require_once '../app/models/Clip.php';

class ClipController {
    
    public function create() {
        require_once '../app/views/clips/clip_create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = $_POST['title'] ?? '';
            $game = $_POST['game'] ?? '';
            $description = $_POST['description'] ?? '';
            $userId = $_SESSION['user_id']; 

            $videoName = $this->processVideoUpload();

            if ($videoName) {
                $db = (new Database())->getConnection();
                $clipModel = new Clip($db);
                
                if ($clipModel->create($title, $game, $videoName, $description, $userId)) {
                    header("Location: " . BASE_URL . "/index.php");
                    exit;
                } else {
                    echo "Chyba při ukládání do DB.";
                }
            } else {
                echo "Chyba při nahrávání videa (zkontrolujte velikost a formát mp4/webm).";
            }
        }
    }

    private function processVideoUpload() {
        $uploadDir = __DIR__ . '/../../public/uploads/videos/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (isset($_FILES['video']) && $_FILES['video']['error'] === UPLOAD_ERR_OK) {
            $tmpName = $_FILES['video']['tmp_name'];
            $fileExtension = strtolower(pathinfo($_FILES['video']['name'], PATHINFO_EXTENSION));
            
            if (in_array($fileExtension, ['mp4', 'webm'])) {
                $newName = 'clip_' . time() . '_' . uniqid() . '.' . $fileExtension;
                $targetFilePath = $uploadDir . $newName;

                if (move_uploaded_file($tmpName, $targetFilePath)) {
                    return $newName; 
                }
            }
        }
        return false;
    }

    public function index() {
        $db = (new Database())->getConnection();
        $clipModel = new Clip($db);
        $currentUserId = $_SESSION['user_id'] ?? null; 
        $clips = $clipModel->getAllLatest($currentUserId);
        
        require_once '../app/views/clips/feed.php';
    }

    public function show($id = null) {
        if (!$id) { header("Location: " . BASE_URL); exit; }

        $db = (new Database())->getConnection();
        $clipModel = new Clip($db);
        $currentUserId = $_SESSION['user_id'] ?? null;
        $clip = $clipModel->getById($id, $currentUserId);

        if (!$clip) { header("Location: " . BASE_URL); exit; }

        require_once '../app/models/Comment.php';
        $commentModel = new Comment($db);
        $comments = $commentModel->getByClipId($id);

        require_once '../app/views/clips/clip_details.php';
    }

    public function toggleUpvote($clipId = null) {
        if ($clipId && isset($_SESSION['user_id'])) {
            require_once '../app/models/Upvote.php';
            $db = (new Database())->getConnection();
            $upvoteModel = new Upvote($db);
            $upvoteModel->toggle($clipId, $_SESSION['user_id']);
        }
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    // Zobrazení formuláře pro úpravu klipu
    public function edit($id = null) {
        if (!$id || !isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL); exit;
        }

        $db = (new Database())->getConnection();
        $clipModel = new Clip($db);
        $clip = $clipModel->getById($id);

        $isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
        if (!$clip || ($clip['user_id'] != $_SESSION['user_id'] && !$isAdmin)) {
            $_SESSION['flash_messages'][] = ['type' => 'error', 'text' => 'K úpravě tohoto klipu nemáte oprávnění.'];
            header("Location: " . BASE_URL); exit;
        }

        require_once '../app/views/clips/clip_edit.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
            $id = $_POST['id'];
            $title = $_POST['title'] ?? '';
            $game = $_POST['game'] ?? '';
            $description = $_POST['description'] ?? '';

            $db = (new Database())->getConnection();
            $clipModel = new Clip($db);
            $clip = $clipModel->getById($id);

            $isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
            if ($clip && ($clip['user_id'] == $_SESSION['user_id'] || $isAdmin)) {
                $clipModel->update($id, $title, $game, $description, $_SESSION['user_id']);
                $_SESSION['flash_messages'][] = ['type' => 'success', 'text' => 'Klip byl úspěšně upraven.'];
            }
            
            header("Location: " . BASE_URL . "/index.php?url=clip/show/" . $id);
            exit;
        }
    }

    public function delete($id = null) {
        if ($id && isset($_SESSION['user_id'])) {
            $db = (new Database())->getConnection();
            $clipModel = new Clip($db);
            $clip = $clipModel->getById($id);

            $isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
            
            if ($clip && ($clip['user_id'] == $_SESSION['user_id'] || $isAdmin)) {
                $filePath = __DIR__ . '/../../public/uploads/videos/' . $clip['video_path'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                
                $clipModel->delete($id);
                $_SESSION['flash_messages'][] = ['type' => 'success', 'text' => 'Video bylo úspěšně smazáno.'];
            } else {
                $_SESSION['flash_messages'][] = ['type' => 'error', 'text' => 'K odstranění tohoto videa nemáte oprávnění.'];
            }
        }
        
        header('Location: ' . BASE_URL);
        exit;
    }
}