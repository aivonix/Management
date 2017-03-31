<?php

class ManagementTest extends PHPUnit_Framework_TestCase 
{
    //only 2 functions from the other class can be tested for output. I have presented only 2 versions of those function outputs
    
    
    public function testGetProductPriceFirstProduct()
    {
        $management = new Management(); //fill in the inclusion of this class
        $expected = 1.80;
        $this->assertEquals($expected, $management->getProductPrice(1));
    }
    
    public function testCalcDiscountTotalPrice()
    {
        $management = new Management(); //fill in the inclusion of this class
        $expected = 12.80;
        $this->assertEquals($expected, $management->calcDiscount(3, 10, 1.60, 20));
    }
}

?>
