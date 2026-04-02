<?php
// Přidáme načtení souborů s databází a modelem
require_once '../app/models/Database.php';
require_once '../app/models/Book.php';

class BookController {
    
    public function index() {
        // 1. Vytvoření připojení k databázi
        $database = new Database();
        $db = $database->getConnection();

        // 2. Vytvoření instance modelu Book
        $bookModel = new Book($db);

        // 3. Načtení všech knih do proměnné $books
        $books = $bookModel->getAll();

        // 4. Načtení pohledu (pohled nyní uvidí proměnnou $books)
        require_once '../app/views/books/books_list.php';
    }

    public function create() {
        require_once '../app/views/books/book_create.php';
    }

    // Nová metoda pro zpracování odeslaného formuláře
    public function store() {
        // Kontrola, zda byla data odeslána metodou POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            // 1. Vytvoření připojení k databázi
            $database = new Database();
            $db = $database->getConnection();

            // 2. Vytvoření instance modelu Book s předaným připojením
            $book = new Book($db);

            // 3. Načtení dat z formuláře (s fallbackem na prázdný řetězec, pokud chybí)
            $title = $_POST['title'] ?? '';
            $author = $_POST['author'] ?? '';
            $isbn = $_POST['isbn'] ?? '';
            $category = $_POST['category'] ?? '';
            $subcategory = $_POST['subcategory'] ?? '';
            $year = $_POST['year'] ?? '';
            $price = $_POST['price'] ?? 0;
            $link = $_POST['link'] ?? '';
            $description = $_POST['description'] ?? '';

            // 4. Uložení záznamu do DB
            if ($book->create($title, $author, $isbn, $category, $subcategory, $year, $price, $link, $description)) {
                // Pokud se uložení povedlo, přesměrujeme uživatele na seznam knih
                header("Location: /WA-2026-Vicha-Adam/BooksApp/public/index.php");
                exit();
            } else {
                echo "Došlo k chybě při ukládání knihy do databáze.";
            }
        }
    }

        // 3. Smazání existující knihy
    public function delete($id = null) {
        // Kontrola, zda bylo v URL předáno ID
        if (!$id) {
            $this->addErrorMessage('Nebylo zadáno ID knihy ke smazání.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // Načtení potřebných tříd a spojení s databází
        require_once '../app/models/Database.php';
        require_once '../app/models/Book.php';

        $database = new Database();
        $db = $database->getConnection();

        // Inicializace modelu a zavolání metody pro smazání
        $bookModel = new Book($db);
        $isDeleted = $bookModel->delete($id);

        // Vyhodnocení výsledku a přesměrování s notifikací
        if ($isDeleted) {
            // Zelená zpráva o úspěchu
            $this->addSuccessMessage('Kniha byla trvale smazána z databáze.');
        } else {
            // Červená zpráva pro případ, že kniha neexistovala nebo selhal dotaz
            $this->addErrorMessage('Nastala chyba. Knihu se nepodařilo smazat.');
        }

        // Vždy následuje návrat na seznam knih
        header('Location: ' . BASE_URL . '/index.php');
        exit;
    }

        // 4. Zobrazení formuláře pro úpravu existující knihy
    public function edit($id = null) {
        // Kontrola, zda bylo v URL vůbec předáno nějaké ID
        if (!$id) {
            // Vyvolání červené notifikace pro kritickou chybu
            $this->addErrorMessage('Nebylo zadáno ID knihy k úpravě.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // Načtení potřebných tříd a spojení s databází
        require_once '../app/models/Database.php';
        require_once '../app/models/Book.php';

        $database = new Database();
        $db = $database->getConnection();

        // Získání dat o konkrétní knize
        $bookModel = new Book($db);
        $book = $bookModel->getById($id); // Proměnná $book nyní obsahuje asociativní pole dat

        // Bezpečnostní kontrola: Zda kniha s daným ID vůbec existuje
        if (!$book) {
            // Pokud knihu někdo mezitím smazal, nebo uživatel zadal do URL neexistující ID
            $this->addErrorMessage('Požadovaná kniha nebyla v databázi nalezena.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // Pokud je vše v pořádku, načte se připravený soubor s HTML formulářem pro úpravy.
        // Šablona bude mít automaticky přístup k proměnné $book.
        require_once '../app/views/books/book_edit.php';
    }

        // 5. Zpracování dat odeslaných z editačního formuláře
    public function update($id = null) {
        // Zabezpečení: Je k dispozici ID a byl odeslán formulář?
        if (!$id) {
            $this->addErrorMessage('Nebylo zadáno ID knihy k aktualizaci.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // 1. Získání a očištění textových dat
            $title = htmlspecialchars($_POST['title'] ?? '');
            $author = htmlspecialchars($_POST['author'] ?? '');
            $isbn = htmlspecialchars($_POST['isbn'] ?? '');
            $category = htmlspecialchars($_POST['category'] ?? '');
            $subcategory = htmlspecialchars($_POST['subcategory'] ?? '');
            
            // Přetypování číselných hodnot
            $year = (int)($_POST['year'] ?? 0);
            $price = (float)($_POST['price'] ?? 0);
            
            $link = htmlspecialchars($_POST['link'] ?? '');
            $description = htmlspecialchars($_POST['description'] ?? '');

            // Prozatímní zástupce pro obrázky
            $uploadedImages = []; 

            // 2. Komunikace s databází a modelem
            require_once '../app/models/Database.php';
            require_once '../app/models/Book.php';

            $database = new Database();
            $db = $database->getConnection();

            // 3. Volání updatu nad modelem
            $bookModel = new Book($db);
            $isUpdated = $bookModel->update(
                $id, $title, $author, $category, $subcategory, 
                $year, $price, $isbn, $description, $link, $uploadedImages
            );

            // 4. Vyhodnocení výsledku a přesměrování
            if ($isUpdated) {
                // Vyvolání zelené notifikace o úspěchu
                $this->addSuccessMessage('Kniha byla úspěšně upravena.');
                header('Location: ' . BASE_URL . '/index.php');
                exit;
            } else {
                // Vyvolání červené chybové notifikace
                $this->addErrorMessage('Nastala chyba. Změny se nepodařilo uložit.');
            }
            
        } else {
            // Pokud by někdo zkusil přistoupit na URL napřímo bez odeslání formuláře (žlutá notifikace)
            $this->addNoticeMessage('Pro úpravu knihy je nutné odeslat formulář.');
        }
    }

    // Zobrazení detailu knihy
    public function show($id = null) {
        // Kontrola, zda bylo předáno ID
        if (!$id) {
            $this->addErrorMessage('Nebylo zadáno ID knihy k zobrazení.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        require_once '../app/models/Database.php';
        require_once '../app/models/Book.php';

        $database = new Database();
        $db = $database->getConnection();

        $bookModel = new Book($db);
        $book = $bookModel->getById($id); 

        // Bezpečnostní kontrola, zda kniha existuje
        if (!$book) {
            $this->addErrorMessage('Požadovaná kniha nebyla nalezena.');
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        // Načtení pohledu s detailem knihy
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
}
?>