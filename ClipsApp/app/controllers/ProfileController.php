<?php
require_once '../app/models/Database.php';
require_once '../app/models/User.php';
require_once '../app/models/Clip.php';

class ProfileController {

    public function show($id = null) {
        if (!$id) {
            header('Location: ' . BASE_URL);
            exit;
        }

        $db = (new Database())->getConnection();
        $userModel = new User($db);
        $user = $userModel->getById($id);

        if (!$user) {
            $_SESSION['flash_messages'][] = ['type' => 'error', 'text' => 'Uživatel nenalezen.'];
            header('Location: ' . BASE_URL);
            exit;
        }

        $stmt = $db->prepare("SELECT * FROM clips WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$id]);
        $userClips = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require_once '../app/views/profile/show.php';
    }

    public function edit() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }

        $db = (new Database())->getConnection();
        $userModel = new User($db);
        $user = $userModel->getById($_SESSION['user_id']);

        require_once '../app/views/profile/edit.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
            $bio = $_POST['bio'] ?? '';
            $avatarName = null;

            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../public/uploads/avatars/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

                $tmpName = $_FILES['avatar']['tmp_name'];
                $fileExtension = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
                
                if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'webp'])) {
                    $avatarName = 'avatar_' . $_SESSION['user_id'] . '_' . time() . '.' . $fileExtension;
                    move_uploaded_file($tmpName, $uploadDir . $avatarName);
                }
            }

            $db = (new Database())->getConnection();
            $userModel = new User($db);
            
            if ($userModel->updateProfile($_SESSION['user_id'], $bio, $avatarName)) {
                $_SESSION['flash_messages'][] = ['type' => 'success', 'text' => 'Profil byl úspěšně aktualizován.'];
            } else {
                $_SESSION['flash_messages'][] = ['type' => 'error', 'text' => 'Nastala chyba při aktualizaci profilu.'];
            }

            header('Location: ' . BASE_URL . '/index.php?url=profile/show/' . $_SESSION['user_id']);
            exit;
        }
    }
}
?>