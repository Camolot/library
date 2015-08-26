<?php
    class Title
    {
      private $description;
      private $id;

      function __construct($description, $id = null)
      {
        $this->description = $description;
        $this->id = $id;
      }

      function setDescription($new_description)
      {
        $this->description = (string) $new_description;
      }

      function getDescription()
      {
        return $this->description;
      }

      function getId()
      {
        return $this->id;
      }

      function save()
      {
        $GLOBALS['DB']->exec("INSERT INTO titles (description) VALUES ('{$this->getDescription()}');");
        $this->id = $GLOBALS['DB']->lastInsertId();
      }

      static function getAll()
      {
        $returned_titles = $GLOBALS['DB']->query("SELECT * FROM titles;");
        $titles = array();
        foreach($returned_titles as $title) {
          $description = $title['description'];
          $id = $title['id'];
          $new_title = new Title($description, $id);
          array_push($titles, $new_title);
        }
        return $titles;
      }

      static function deleteAll()
      {
        $GLOBALS['DB']->exec("DELETE FROM titles;");
      }

      static function find($search_id)
      {
        $found_title = null;
        $titles = Title::getAll();
        foreach($titles as $title) {
          $title_id = $title->getId();
          if ($title_id == $search_id) {
            $found_title = $title;
          }
        }
        return $found_title;
      }

      function update($new_description)
      {
        $GLOBALS['DB']->exec("UPDATE titles SET description = '{$new_description}' WHERE id = {$this->getId()};");
          $this->setDescription($new_description);
      }

      function delete()
      {
        $GLOBALS['DB']->exec("DELETE FROM titles WHERE id = {$this->getid()};");
        $GLOBALS['DB']->exec("DELETE FROM authors_titles WHERE title_id = {$this->getId()};");
      }

      function addAuthor($author)
      {
        $GLOBALS['DB']->exec("INSERT INTO authors_titles (author_id, title_id) VALUES ({$author->getId()}, {$this->getId()});");
      }

      function getAuthors()
      {
        $query = $GLOBALS['DB']->query("SELECT author_id FROM author_titles WHERE title_id = {$this->getId()};");
        $author_ids = $query->fetchAll(PDI::FETCH_ASSOC);

        $authors = array();
        foreach($author_ids as $id) {
          $author_id = $id['author_id'];
          $result = $GLOBALS['DB']->query("SELECT * FROM categories WHERE id = {$author_id};");
          $returned_author = $result->fetchAll(PDO::FETCH_ASSOC);

          $name = $returned_author[0]['name'];
          $id = $returned_author[0]['id'];
          $new_author = new Author($name, $id);
          array_push($authors, $new_author);
        }
        return $authors;
      }

    }
?>
