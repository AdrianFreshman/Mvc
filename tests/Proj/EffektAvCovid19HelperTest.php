<?php

namespace App\Controller;

use App\Entity\EffektAvCovid19;


require_once __DIR__ . '/../../src/Controller/EffektAvCovid19Helper.php';




use PHPUnit\Framework\TestCase;


class EffektAvCovid19HelperTest extends TestCase
{

    public function testSetEffektAvCovid19Data()
    {
        $helper = new EffektAvCovid19Helper();
        $entity = new EffektAvCovid19();

        $helper->setEffektAvCovid19Data($entity);

        $this->assertEquals('', $entity->getName());
        $this->assertEquals(5771, $entity->getTotal_Deaths());
        $this->assertEquals(3104, $entity->getMale_Deaths());
        $this->assertEquals(2667, $entity->getFemale_Deaths());
        // Test other property assignments...
    }

    public function testFormatEffektAvCovid19Data()
    {
        $helper = new EffektAvCovid19Helper();
        $data = [
            new EffektAvCovid19(/* initialize with some values */),
            new EffektAvCovid19(/* initialize with some values */),
        ];

        $formattedData = $helper->formatEffektAvCovid19Data($data);

        // Assert the formatting logic
        // For example:
        $this->assertEquals($data[0]->getTotal_Deaths(), $formattedData[0]['total_deaths']);
        $this->assertEquals($data[0]->getMale_Deaths(), $formattedData[0]['male_deaths']);
        // Test other property mappings...
    }
}
