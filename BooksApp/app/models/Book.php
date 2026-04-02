<?php
// Cesta: BooksApp/app/models/Book.php

class Book {
    private $table_name = "books"; // Předpokládám, že se tvoje tabulka jmenuje 'books'

    private PDO $db;
    
    public function __construct($db) {
        $this->db = $db;
    }

    // Metoda pro vytvoření záznamu
    public function create($title, $author, $isbn, $category, $subcategory, $year, $price, $link, $description) {
        
        // SQL dotaz pro vložení dat
        $query = "INSERT INTO " . $this->table_name . " 
                  (title, author, isbn, category, subcategory, year, price, link, description) 
                  VALUES (:title, :author, :isbn, :category, :subcategory, :year, :price, :link, :description)";

        $stmt = $this->db->prepare($query);

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

        // Získání jedné konkrétní knihy podle jejího ID
    public function getById($id) {
        $sql = "SELECT * FROM books WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        
        // Používá se fetch() místo fetchAll(), protože očekáváme maximálně jeden výsledek.
        // Vrátí asociativní pole s daty knihy, nebo false, pokud kniha neexistuje.
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Aktualizace existující knihy
    public function update(
        $id, $title, $author, $category, $subcategory, 
        $year, $price, $isbn, $description, $link, $images = []
    ) {
        $sql = "UPDATE books 
                SET title = :title, 
                    author = :author, 
                    category = :category, 
                    subcategory = :subcategory, 
                    year = :year, 
                    price = :price, 
                    isbn = :isbn, 
                    description = :description, 
                    link = :link, 
                    images = :images
                WHERE id = :id";
                
        $stmt = $this->db->prepare($sql);

        // Parametrů je stejné množství jako u create, navíc je pouze :id
        return $stmt->execute([
            ':id' => $id,
            ':title' => $title,
            ':author' => $author,
            ':category' => $category,
            ':subcategory' => $subcategory ?: null,
            ':year' => $year,
            ':price' => $price,
            ':isbn' => $isbn,
            ':description' => $description,
            ':link' => $link,
            ':images' => json_encode($images)
        ]);
    }

    // Trvalé smazání knihy z databáze
    public function delete($id) {
        $sql = "DELETE FROM books WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        
        // Vrací true při úspěchu, false při chybě
        return $stmt->execute([':id' => $id]);
    }
}
?>