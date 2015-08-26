<?php
    class Author
    {
      private $name;
      private $id;

      function __construct($name, $id = null)
      {
        $this->name = $name;
        $this->id = $id;
      }

      function setName($new_name)
      {
        $this->name = (string) $new_name;
      }

      function getName()
      {
        return $this->name;
      }

      function save()
      {
        $GLOBALS['DB']->exec("INSERT INTO categories (name) VALUES ('{$this->getName()}')");
        $this->id = $GLOBALS['DB']->lastInsertId();
      }

      function update($new_name)
      {
        $GLOBALS['DB']->exec("DELETE FROM authors WHERE id = {$this->getId()};");
        $GLOBALS['DB']->exec("DELETE FROM authors_titles WHERE author_id = {$this->getId()};");
      }

      static function getAll()
      {
        $returned_authors = $GLOBALS['DB']->query("SELECT * FROM authors;");
          //var_dump($returned_authors);
          $authors = array();
          foreach($returned_authors as $author) {
            $name = $author['name'];
            $id = $author['id'];
            $new_author = new Author($name, $id);
            array_push($authors, $new_author);
          }
          return $authors;
      }

      static function deleteAll()
      {
        $GLOBALS['DB']->exec("DELETE FROM authors;");
      }

      static function find($search_id)
      {
        $found_author = null;
        $authors = Author::getAll();
        foreach($authors as $author) {
          $author_id = $author->getId();
          if ($author_id == $search_id) {
            $found_author = $author;
          }
        }
        return $found_author;
      }

      function addTitle($title)
      {
        $GLOBALS['DB']->exec("INSERT INTO authors_titles (author_id, title_id) VALUES ({$this->getId()}, {$task->getId()});");
      }

      function getTitles()
      {
        $query = $GLOBALS['DB']->query("SELECT task_id FROM authors_titles WHERE author_id = {$this->getId()};");
        $title_ids = $query->fetchAll(PDO::FETCH_ASSOC);

        $titles = array();
        foreach($title_ids as $id) {
          $title_id = $id['title_id'];
          $result = $GLOBALS['DB']->query("SELECT * FROM titles WHERE id = {$taks_id};");
          $returned_title = $result->fetchAll(PDO::FETCH_ASSOC);

          $description = $returned_title[0]['description'];
          $id = $returned_title[0]['id'];
          $new_title = new Title($description, $id);
          array_push($titles, $new_title);
        }
        return $titles;
      }
    }
?>
