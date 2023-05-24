<?php

namespace App\Controller;

use App\Entity\Unemployement;

/**
 * Class UnemployementHelper
 * @package App\Controller
 */
class UnemployementHelper
{   
    /**
     * Sets data to the Unemployement entity.
     *
     * @param array $data
     * @param Unemployement $entity
     */
    public function setUnemployemntData(array $data, Unemployement $entity)
    {
        $entity->setAgeRange($data[0]);
        $entity->setAge2018($data[1]);
        $entity->setAge2019($data[2]);
        $entity->setAge2020($data[3]);        
    }

    /**
     * Formats data from the Unemployement entity.
     *
     * @param Unemployement $entity
     * @return array
     */
    public function formatUnemploymentData(Unemployement $entity): array
    {
        return [
                'age_range' => $entity->getAgeRange(),
                'age_2018' => $entity->getAge2018(),
                'age_2019' => $entity->getAge2019(),
                'age_2020' => $entity->getAge2020(),
            ];

    }
}


