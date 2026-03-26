<?php
// Přidáme načtení souborů s databází a modelem
require_once '../app/models/Database.php';
require_once '../app/models/Book.php';

class BookController {
    
    public function index() {
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
}
?>