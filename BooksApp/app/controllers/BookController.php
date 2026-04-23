<?php
require_once '../app/models/Database.php';
require_once '../app/models/Book.php';

class BookController {
    
    public function index() {
        $database = new Database();
        $db = $database->getConnection();
        $bookModel = new Book($db);
        $books = $bookModel->getAll();
        require_once '../app/views/books/books_list.php';
    }

    public function create() {
        if (!isset($_SESSION['user_id'])) {
            $this->addErrorMessage('Pro přidání knihy se musíte nejprve přihlásit.');
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }
        require_once '../app/views/books/book_create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_SESSION['user_id'])) {
                $this->addErrorMessage('Pro uložení knihy musíte být přihlášeni.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/login');
                exit;
            }
            $userId = $_SESSION['user_id'];

            $title = htmlspecialchars($_POST['title'] ?? '');
            $author = htmlspecialchars($_POST['author'] ?? '');
            $isbn = htmlspecialchars($_POST['isbn'] ?? '');
            $category = htmlspecialchars($_POST['category'] ?? '');
            $subcategory = htmlspecialchars($_POST['subcategory'] ?? '');
            $year = (int)($_POST['year'] ?? 0);
            $price = (float)($_POST['price'] ?? 0);
            $link = htmlspecialchars($_POST['link'] ?? '');
            $description = htmlspecialchars($_POST['description'] ?? '');

            $uploadedImages = $this->processImageUploads();

            $database = new Database();
            $db = $database->getConnection();
            $book = new Book($db);

            if ($book->create($title, $author, $isbn, $category, $subcategory, $year, $price, $link, $description, $uploadedImages, $userId)) {
                $this->addSuccessMessage('Kniha byla úspěšně uložena do databáze.');
                header("Location: " . BASE_URL . "/index.php");
                exit();
            } else {
                $this->addErrorMessage('Došlo k chybě při ukládání knihy do databáze.');
                header("Location: " . BASE_URL . "/index.php");
                exit();
            }
        }
    }

    public function delete($id = null) {
        if (!isset($_SESSION['user_id'])) {
            $this->addErrorMessage('Pro smazání knihy se musíte nejprve přihlásit.');
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }

        if (!$id) {
            $this->addErrorMessage('Nebylo zadáno ID knihy ke smazání.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        $database = new Database();
        $db = $database->getConnection();
        $bookModel = new Book($db);
        $book = $bookModel->getById($id);

        if (!$book) {
            $this->addErrorMessage('Kniha nebyla nalezena.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        if ($book['created_by'] !== $_SESSION['user_id']) {
            $this->addErrorMessage('Nemáte oprávnění smazat tuto knihu, protože nejste jejím autorem.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        if ($bookModel->delete($id)) {
            $this->addSuccessMessage('Kniha byla trvale smazána z databáze.');
        } else {
            $this->addErrorMessage('Nastala chyba. Knihu se nepodařilo smazat.');
        }

        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }

    public function edit($id = null) {
        if (!isset($_SESSION['user_id'])) {
            $this->addErrorMessage('Pro úpravu knihy se musíte nejprve přihlásit.');
            header('Location: ' . BASE_URL . '/index.php?url=auth/login');
            exit;
        }

        if (!$id) {
            $this->addErrorMessage('Nebylo zadáno ID knihy k úpravě.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        $database = new Database();
        $db = $database->getConnection();
        $bookModel = new Book($db);
        $book = $bookModel->getById($id); 

        if (!$book) {
            $this->addErrorMessage('Požadovaná kniha nebyla v databázi nalezena.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        if ($book['created_by'] !== $_SESSION['user_id']) {
            $this->addErrorMessage('Nemáte oprávnění upravovat tuto knihu, protože nejste jejím autorem.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        require_once '../app/views/books/book_edit.php';
    }

    public function update($id = null) {
        if (!$id) {
            $this->addErrorMessage('Nebylo zadáno ID knihy k aktualizaci.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['user_id'])) {
                $this->addErrorMessage('Pro uložení změn se musíte nejprve přihlásit.');
                header('Location: ' . BASE_URL . '/index.php?url=auth/login');
                exit;
            }
            
            $database = new Database();
            $db = $database->getConnection();
            $bookModel = new Book($db);
            $book = $bookModel->getById($id);

            if (!$book || $book['created_by'] !== $_SESSION['user_id']) {
                $this->addErrorMessage('Nemáte oprávnění ukládat změny u této knihy, protože nejste jejím autorem.');
                header('Location: ' . BASE_URL . '/index.php');
                exit;
            }

            $title = htmlspecialchars($_POST['title'] ?? '');
            $author = htmlspecialchars($_POST['author'] ?? '');
            $isbn = htmlspecialchars($_POST['isbn'] ?? '');
            $category = htmlspecialchars($_POST['category'] ?? '');
            $subcategory = htmlspecialchars($_POST['subcategory'] ?? '');
            $year = (int)($_POST['year'] ?? 0);
            $price = (float)($_POST['price'] ?? 0);
            $link = htmlspecialchars($_POST['link'] ?? '');
            $description = htmlspecialchars($_POST['description'] ?? '');

            $uploadedImages = $this->processImageUploads(); 

            $isUpdated = $bookModel->update(
                $id, $title, $author, $category, $subcategory, 
                $year, $price, $isbn, $description, $link, $uploadedImages
            );

            if ($isUpdated) {
                $this->addSuccessMessage('Kniha byla úspěšně upravena.');
                header('Location: ' . BASE_URL . '/index.php');
                exit;
            } else {
                $this->addErrorMessage('Nastala chyba. Změny se nepodařilo uložit.');
            }
        } else {
            $this->addNoticeMessage('Pro úpravu knihy je nutné odeslat formulář.');
            header('Location: ' . BASE_URL . '/index.php');
        }
    }

    public function show($id = null) {
        if (!$id) {
            $this->addErrorMessage('Nebylo zadáno ID knihy k zobrazení.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        $database = new Database();
        $db = $database->getConnection();
        $bookModel = new Book($db);
        $book = $bookModel->getById($id); 

        if (!$book) {
            $this->addErrorMessage('Požadovaná kniha nebyla nalezena.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }
        require_once '../app/views/books/book_details.php';
    }

    protected function addSuccessMessage($message) {
        $_SESSION['flash_messages'][] = ['type' => 'success', 'text' => $message];
    }
    protected function addErrorMessage($message) {
        $_SESSION['flash_messages'][] = ['type' => 'error', 'text' => $message];
    }
    protected function addNoticeMessage($message) {
        $_SESSION['flash_messages'][] = ['type' => 'notice', 'text' => $message];
    }

    protected function processImageUploads() {
        $uploadedFiles = [];
        $uploadDir = __DIR__ . '/../../public/uploads/'; 
        
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
            $fileCount = count($_FILES['images']['name']);
            for ($i = 0; $i < $fileCount; $i++) {
                if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
                    $tmpName = $_FILES['images']['tmp_name'][$i];
                    $originalName = basename($_FILES['images']['name'][$i]);
                    $fileExtension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

                    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                    if (!in_array($fileExtension, $allowedExtensions)) continue; 

                    $newName = 'book_' . uniqid() . '_' . substr(md5(mt_rand()), 0, 4) . '.' . $fileExtension;
                    $targetFilePath = $uploadDir . $newName;

                    if (move_uploaded_file($tmpName, $targetFilePath)) {
                        $uploadedFiles[] = $newName; 
                    }
                }
            }
        }
        return $uploadedFiles;
    }
}
?>