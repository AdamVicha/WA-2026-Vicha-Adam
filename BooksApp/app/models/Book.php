<?php
// Cesta: BooksApp/app/models/Book.php

class Book {
    private $conn;
    private $table_name = "books"; // Předpokládám, že se tvoje tabulka jmenuje 'books'

    // Konstruktor přijme připojení k DB z tvé třídy Database
    public function __construct($db) {
        $this->conn = $db;
    }

    // Metoda pro vytvoření záznamu
    public function create($title, $author, $isbn, $category, $subcategory, $year, $price, $link, $description) {
        
        // SQL dotaz pro vložení dat
        $query = "INSERT INTO " . $this->table_name . " 
                  (title, author, isbn, category, subcategory, year, price, link, description) 
                  VALUES (:title, :author, :isbn, :category, :subcategory, :year, :price, :link, :description)";

        $stmt = $this->conn->prepare($query);

        // Očištění dat (základní bezpečnostní opatření)
        $title = htmlspecialchars(strip_tags($title));
        $author = htmlspecialchars(strip_tags($author));
        $isbn = htmlspecialchars(strip_tags($isbn));
        // ... (zde bys mohl očistit i další pole, pro zkrácení ukázky je vynechávám)

        // Navázání parametrů k připravenému dotazu
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":author", $author);
        $stmt->bindParam(":isbn", $isbn);
        $stmt->bindParam(":category", $category);
        $stmt->bindParam(":subcategory", $subcategory);
        $stmt->bindParam(":year", $year);
        $stmt->bindParam(":price", $price);
        $stmt->bindParam(":link", $link);
        $stmt->bindParam(":description", $description);

        // Spuštění dotazu a vrácení výsledku
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>