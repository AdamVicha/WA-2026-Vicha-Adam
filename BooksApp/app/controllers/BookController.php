<?php

class BookController {
    public function index() {
        require_once '../app/views/books/books_list.php';
    }

    public function create() {
        require_once '../app/views/books/book_create.php';
    }
}