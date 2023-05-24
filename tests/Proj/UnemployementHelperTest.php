<?php

namespace App\Controller;

require_once __DIR__ . '/../../src/Controller/UnemployementHelper.php';

use App\Entity\Unemployement;

use PHPUnit\Framework\TestCase;


class UnemployementHelperTest extends TestCase

{

    public function testSetUnemployemntDataAndFormatUnemploymentData()
    {
        $helper = new UnemployementHelper();
        $entity = new Unemployement();
        
        $randomData = $this->generateRandomArray(4);
        
        $helper->setUnemployemntData($randomData, $entity);
        
        $resultData = $helper->formatUnemploymentData($entity);
        
        $this->assertEquals($randomData[0], $resultData['age_range']);
        $this->assertEquals($randomData[1], $resultData['age_2018']);
        $this->assertEquals($randomData[2], $resultData['age_2019']);
        $this->assertEquals($randomData[3], $resultData['age_2020']);
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
