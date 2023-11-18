<?php
class Library {
    public $books = array();

    public function addBook($book) {
        $this->books[] = $book;
    }
    public function removeBook($title) {
        foreach ($this->books as $key => $book) {
            if ($book->title === $title) {
                unset($this->books[$key]);
                return true;
            }
        }
        return false;
    }
    public function getBookList() {
        $bookList = array();
        foreach ($this->books as $book) {
            $bookList[] = array(
                'title' => $book->title,
                'author' => $book->author,
                'year' => $book->year
            );
        }
        return $bookList;
    }
}
?>
