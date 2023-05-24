<?php

namespace App\Controller;

use App\Entity\Boende;

/**
 * Class HelperBoende
 * @package App\Controller
 */
class HelperBoende
{
    /**
     * Sets data to the Boende entity.
     *
     * @param array $data
     * @param Boende $entity
     */
    public function setData(array $data, Boende $entity)
    {
        $entity->setVecka($data[0]);
        $entity->setTwthousandsixteen($data[1]);
        $entity->setTwothousandseventeen($data[2]);
        $entity->setTwothousandeighteen($data[3]);
        $entity->setTwothousandnineteen($data[4]);
        $entity->setTwothousandtwenty($data[5]);
    }

    /**
     * Gets data from the Boende entity.
     *
     * @param Boende $entity
     * @return array
     */
    public function getData(Boende $entity)
    {
        return [
        'Vecka' => $entity->getVecka(),
        '2016' => $entity->getTwthousandsixteen(),
        '2017' => $entity->getTwothousandseventeen(),
        '2018' => $entity->getTwothousandeighteen(),
        '2019' => $entity->getTwothousandnineteen(),
        '2020' => $entity->getTwothousandtwenty(),
    ];
    }
}
