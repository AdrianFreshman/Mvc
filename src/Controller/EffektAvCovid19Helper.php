<?php

namespace App\Controller;

use App\Entity\EffektAvCovid19;

/**
 * Class EffektAvCovid19Helper
 * @package App\Controller
 */
class EffektAvCovid19Helper
{
    /**
     * Sets data to the EffektAvCovid19 entity.
     *
     * @param EffektAvCovid19 $entity
     */
    public function setEffektAvCovid19Data(EffektAvCovid19 $entity): void
    {
        $entity->setName('');
        $entity->setTotalDeaths(5771);
        $entity->setMaleDeaths(3104);
        $entity->setFemaleDeaths(2667);
        $entity->setUnder50(60);
        $entity->setAge5059(158);
        $entity->setAge6069(383);
        $entity->setUnder70(601);
        $entity->setAge7074(472);
        $entity->setAge7579(727);
        $entity->setAge8084(1103);
        $entity->setAge8589(1339);
        $entity->setAge85Plus(2868);
        $entity->setAge90Plus(1529);
        $entity->setCardiovascularDisease(2849);
        $entity->setHighBloodPressure(4519);
        $entity->setDiabetes(1598);
        $entity->setLungDisease(811);
        $entity->setNoDiseaseGroup(890);
        $entity->setOneDiseaseGroup(1544);
        $entity->setMultipleDiseaseGroups(3337);
        $entity->setSpecialHousing(2682);
        $entity->setHomeCare(1535);
        $entity->setHospitalDeaths(2782);
        $entity->setSpecialHousingDeaths(2625);
        $entity->setOrdinaryHousingDeaths(223);
    }

    /**
     * Formats data from the EffektAvCovid19 entity.
     *
     * @param array $data
     * @return array
     */
    public function formatEffektAvCovid19Data(array $data): array
    {
        $formattedData = [];
        foreach ($data as $item) {
            $formattedData[] = [
                'total_deaths' => $item->getTotal_Deaths(),
                'male_deaths' => $item->getMale_Deaths(),
                'female_deaths' => $item->getFemale_Deaths(),
                'under_50' => $item->getUnder_50(),
                'age_50_59' => $item->getAge_50_59(),
                'age_60_69' => $item->getAge_60_69(),
                'under_70' => $item->getUnder_70(),
                'age_70_74' => $item->getAge_70_74(),
                'age_75_79' => $item->getAge_75_79(),
                'age_80_84' => $item->getAge_80_84(),
                'age_85_89' => $item->getAge_85_89(),
                'age_85_plus' => $item->getAge_85_Plus(),
                'age_90_plus' => $item->getAge_90_Plus(),
                'cardiovascular_disease' => $item->getCardiovascular_Disease(),
                'high_blood_pressure' => $item->getHigh_Blood_Pressure(),
                'diabetes' => $item->getDiabetes(),
                'lung_disease' => $item->getLung_Disease(),
                'no_disease_group' => $item->getNo_Disease_Group(),
                'one_disease_group' => $item->getOne_Disease_Group(),
                'multiple_disease_groups' => $item->getMultiple_Disease_Groups(),
                'special_housing' => $item->getSpecial_Housing(),
                'home_care' => $item->getHome_Care(),
                'hospital_deaths' => $item->getHospital_Deaths(),
                'special_housing_deaths' => $item->getSpecial_Housing_Deaths(),
                'ordinary_housing_deaths' => $item->getOrdinary_Housing_Deaths(),
            ];
        }
        return $formattedData;
    }
}
