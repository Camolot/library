<?php

    /**
    * @backupGlobals disabled
    * @backup StaticAttributes disabled
    */

    require_once "src/Author.php";
    require_once "src/Title.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class AuthorTest extends PHPUnit_Framework_TestCase
    {
      protected function tearDown()
      {
        Author::deleteAll();
        Title::deleteAll();
      }

      function testGetName()
      {
        //Arrange
        $name = "Orson Scott Card";
        $test_Author = new Author($name);

        //Act
        $result = $test_Author->getName();

        //Assert
        $this->assertEquals($name, $result);
      }

      function testSetname()
      {
        //Arrange
        $name = "Mary Shelly";
        $test_author = new Author($name);

        //Act
        $test_author->setName("Dean Koontz");
        $result = $test_author->getName();

        //Assert
        $this->assertEquals("Dean Koontz", $result);
      }
    }
?>
