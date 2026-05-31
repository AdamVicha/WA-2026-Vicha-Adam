<?php
require_once '../app/models/Database.php';
require_once '../app/models/User.php';
require_once '../app/models/Clip.php';

class AdminController {
    
    private function requireAdmin() {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            $_SESSION['flash_messages'][] = ['type' => 'error', 'text' => 'Přístup odepřen. Nemáte administrátorská práva.'];
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }
    }

    public function dashboard() {
        $this->requireAdmin();
        $db = (new Database())->getConnection();
        
        $userModel = new User($db);
        $users = $userModel->getAllUsers();

        $clipModel = new Clip($db);
        $clips = $clipModel->getAllLatest();

        require_once '../app/views/admin/dashboard.php';
    }

    public function deleteUser($id = null) {
        $this->requireAdmin();
        
        if ($id && $id != $_SESSION['user_id']) {
            $db = (new Database())->getConnection();
            $userModel = new User($db);
            $userModel->delete($id);
            $_SESSION['flash_messages'][] = ['type' => 'success', 'text' => 'Uživatel byl úspěšně smazán.'];
        } else {
            $_SESSION['flash_messages'][] = ['type' => 'error', 'text' => 'Chyba při mazání uživatele.'];
        }
        
        header('Location: ' . BASE_URL . '/index.php?url=admin/dashboard');
        exit;
    }

    public function deleteClip($id = null) {
        $this->requireAdmin();
        
        if ($id) {
            $db = (new Database())->getConnection();
            $clipModel = new Clip($db);
            
            $clip = $clipModel->getById($id);
            
            if ($clip) {
                $filePath = __DIR__ . '/../../public/uploads/videos/' . $clip['video_path'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                
                $clipModel->delete($id);
                $_SESSION['flash_messages'][] = ['type' => 'success', 'text' => 'Klip byl úspěšně smazán i ze serveru.'];
            } else {
                $_SESSION['flash_messages'][] = ['type' => 'error', 'text' => 'Klip nebyl nalezen.'];
            }
        }
        
        header('Location: ' . BASE_URL . '/index.php?url=admin/dashboard');
        exit;
    }
}
?>