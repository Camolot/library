<?php
    /**
    * @backupGlobals disabled
    * @backup StaticAttributes disabled
    */

    require_once "src/Book.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class BookTest extends PHPUnit_Framework_TestCase
    {

      protected function tearDown()
      {
        //It doesn't like Book::deleteAll(), and there is nothing linking to Author.
        Book::deleteAll();
        Author::deleteAll();
      }

      function test_save()
      {
        //Arrange
        $title = "Speaker for the Dead";
        $date = "1987";
        $id = null;
        $test_book = new Book($title, $date, $id);
        //var_dump($test_book);

        //Act
        $test_book->save();
        var_dump($test_book);

        //Assert
        $result = Book::getAll();
        $this->assertEquals($test_book, $result[0]);
      }

      function testGetAll()
      {
        //Arrange
        $title = "Speaker for the Dead";
        $date = "1987";
        $id = null;
        $test_book = new Book($title, $date, $id);
        $test_book->save();

        $title2 = "Frankenstein";
        $date2 = "1750";
        $id2 = null;
        $test_book2 = new Book($title2, $date2, $id2);
        $test_book2->save();

        //Act
        $result = Book::getAll();

        //Assert
        $this->assertEquals([$test_book, $test_book2], $result);
      }

      function testDeleteAll()
      {
        //Arrange
        $title = "Speaker for the Dead";
        $date = "1987";
        $id = null;
        $test_book = new Book($title, $date, $id);
        $test_book->save();

        $title2 = "Frankenstein";
        $date2 = "1750";
        $id2 = null;
        $test_book2 = new Book($title2, $date2, $id2);
        $test_book2->save();

        //Act
        Book::deleteAll();

        //Assert
        $result = Book::getAll();
        $this->assertEquals([], $result);
      }
    }
?>
