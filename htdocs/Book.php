<?php
class Book {
    public $title;
    public $author;
    public $year;
    public function __construct($title, $author, $year) {
        $this->title = $title;
        $this->author = $author;
        $this->year = $year;
    }
}
?>
