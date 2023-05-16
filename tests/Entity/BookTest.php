<?php

namespace App\Entity;

use PHPUnit\Framework\TestCase;

/*
 * Test cases for class Book.
 */
class BookTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */

    public function testInstance():void
    {
        $book = new Book();
        $this->assertInstanceOf("\App\Entity\Book", $book);
    }
    public function testGetSetTitle():void
    {
        $book = new Book();
        $book->setTitle("Mamma");
        $res = $book->getTitle();
        $exp = "Mamma";
        $this->assertEquals($res, $exp);
    }
    public function testGetSetIsbn():void
    {
        $book = new Book();
        $book->setIsbn("1-2-5456879");
        $res = $book->getIsbn();
        $exp = "1-2-5456879";
        $this->assertEquals($res, $exp);
    }
    public function testGetSetAuthor():void
    {
        $book = new Book();
        $book->setAuthor("1-2-5456879");
        $res = $book->getAuthor();
        $exp = "1-2-5456879";
        $this->assertEquals($res, $exp);
    }
    public function testGetSetImg():void
    {
        $book = new Book();
        $book->setImg("img/hej.jpg");
        $res = $book->getImg();
        $exp = "img/hej.jpg";
        $this->assertEquals($res, $exp);
    }
}
