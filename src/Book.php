<?php
    class Book
    {
      private $title;
      private $date;
      private $id;

      function __construct($title, $date, $id = null)
      {
        $this->title = $title;
        $this->date = $date;
        $this->id = $id;
      }

      function save()
      {
        //Hey database... ("INSERT INTO tablename (column1, column2) VALUES ('value for column1', 'value for column2');")
        $GLOBALS['DB']->exec("INSERT INTO books (title, copyright) VALUES ('{$this->getTitle()}', '{$this->getDate()}');");
        $this->id = $GLOBALS['DB']->lastInsertId();
      }

      function setTitle($new_title)
      {
        $this->title = (string) $new_title;
      }

      function getTitle()
      {
        return $this->title;
      }

      function setDate($new_date)
      {
        $this->title = (string) $new_date;
      }

      function getDate()
      {
        return $this->date;
      }

      function getId()
      {
        return $this->id;
      }

      static function getAll()
      {
        $returned_books = $GLOBALS['DB']->query("SELECT * FROM books;");
        $books = array();
        foreach($returned_books as $book) {
          $title = $book['title'];
          $date = $book['copyright'];
          $id = $book['id'];
          $new_book = new Book($title, $date, $id);
          array_push($books, $new_book);
        }
        return $books;
      }

      static function deleteAll()
      {
        $GLOBALS['DB']->exec("DELETE FROM books;");
      }
    }
?>
