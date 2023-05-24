<?php

namespace App\Controller;

use App\Entity\Boende;

require_once __DIR__ . '/../../src/Controller/HelperBoende.php';



use PHPUnit\Framework\TestCase;


class HelperBoendeTest extends TestCase
{
    public function testSetDataAndGetRandomData()
    {
        $helper = new HelperBoende();
        $entity = new Boende();
        
        $randomData = $this->generateRandomArray(6);
        
        $helper->setData($randomData, $entity);
        
        $resultData = $helper->getData($entity);
        
        $this->assertEquals($randomData[0], $resultData['Vecka']);
        $this->assertEquals($randomData[1], $resultData['2016']);
        $this->assertEquals($randomData[2], $resultData['2017']);
        $this->assertEquals($randomData[3], $resultData['2018']);
        $this->assertEquals($randomData[4], $resultData['2019']);
        $this->assertEquals($randomData[5], $resultData['2020']);
    }
    
    private function generateRandomArray($length)
    {
        $array = [];
        for ($i = 0; $i < $length; $i++) {
            $array[] = rand(1, 100); // Modify the range as needed
        }
        return $array;
    }
}
