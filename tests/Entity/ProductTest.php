<?php

namespace App\Entity;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Product.
 */
class ProductTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */

    public function testInstance():void
    {
        $product = new Product();
        $this->assertInstanceOf("\App\Entity\Product", $product);
    }
    public function testGetSetName():void
    {
        $product = new Product();
        $product->setName("Mamma");
        $res = $product->getName();
        $exp = "Mamma";
        $this->assertEquals($res, $exp);
    }
    public function testGetSetValue():void
    {
        $product = new Product();
        $product->setValue(00000);
        $res = $product->getValue();
        $exp = 00000;
        $this->assertEquals($res, $exp);
    }
    public function testGetId():void
    {
        $product = new Product();
        $res = $product->getId();
        $exp = null;
        $this->assertEquals($res, $exp);
    }
}
