<?php

namespace App\Entity;

use App\Repository\EffektAvCovid19Repository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EffektAvCovid19Repository::class)]
class EffektAvCovid19
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $total_deaths = null;

    #[ORM\Column]
    private ?int $male_deaths = null;

    #[ORM\Column]
    private ?int $female_deaths = null;

    #[ORM\Column]
    private ?int $under_50 = null;

    #[ORM\Column]
    private ?int $age_50_59 = null;

    #[ORM\Column]
    private ?int $age_60_69 = null;

    #[ORM\Column]
    private ?int $under_70 = null;

    #[ORM\Column]
    private ?int $age_70_74 = null;

    #[ORM\Column]
    private ?int $age_75_79 = null;

    #[ORM\Column]
    private ?int $age_80_84 = null;

    #[ORM\Column]
    private ?int $age_85_89 = null;

    #[ORM\Column]
    private ?int $age_85_plus = null;

    #[ORM\Column]
    private ?int $age_90_plus = null;

    #[ORM\Column]
    private ?int $cardiovascular_disease = null;

    #[ORM\Column]
    private ?int $high_blood_pressure = null;

    #[ORM\Column]
    private ?int $diabetes = null;

    #[ORM\Column]
    private ?int $lung_disease = null;

    #[ORM\Column]
    private ?int $no_disease_group = null;

    #[ORM\Column]
    private ?int $one_disease_group = null;

    #[ORM\Column]
    private ?int $multiple_disease_groups = null;

    #[ORM\Column]
    private ?int $special_housing = null;

    #[ORM\Column]
    private ?int $home_care = null;

    #[ORM\Column]
    private ?int $hospital_deaths = null;

    #[ORM\Column]
    private ?int $special_housing_deaths = null;

    #[ORM\Column]
    private ?int $ordinary_housing_deaths = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getTotal_deaths(): ?int
{
    return $this->total_deaths;
}

    public function setTotalDeaths(int $total_deaths): self
    {
        $this->total_deaths = $total_deaths;

        return $this;
    }

    public function getMale_Deaths(): ?int
    {
        return $this->male_deaths;
    }

    public function setMaleDeaths(int $male_deaths): self
    {
        $this->male_deaths = $male_deaths;

        return $this;
    }

    public function getFemale_Deaths(): ?int
    {
        return $this->female_deaths;
    }

    public function setFemaleDeaths(int $female_deaths): self
    {
        $this->female_deaths = $female_deaths;

        return $this;
    }

    public function getUnder_50(): ?int
    {
        return $this->under_50;
    }

    public function setUnder50(int $under_50): self
    {
        $this->under_50 = $under_50;

        return $this;
    }

    public function getAge_50_59(): ?int
    {
        return $this->age_50_59;
    }

    public function setAge5059(int $age_50_59): self
    {
        $this->age_50_59 = $age_50_59;

        return $this;
    }

    public function getAge_60_69(): ?int
    {
        return $this->age_60_69;
    }

    public function setAge6069(int $age_60_69): self
    {
        $this->age_60_69 = $age_60_69;

        return $this;
    }

    public function getUnder_70(): ?int
    {
        return $this->under_70;
    }

    public function setUnder70(int $under_70): self
    {
        $this->under_70 = $under_70;

        return $this;
    }

    public function getAge_70_74(): ?int
    {
        return $this->age_70_74;
    }

    public function setAge7074(int $age_70_74): self
    {
        $this->age_70_74 = $age_70_74;

        return $this;
    }

    public function getAge_75_79(): ?int
    {
        return $this->age_75_79;
    }

    public function setAge7579(int $age_75_79): self
    {
        $this->age_75_79 = $age_75_79;

        return $this;
    }

    public function getAge_80_84(): ?int
    {
        return $this->age_80_84;
    }

    public function setAge8084(int $age_80_84): self
    {
        $this->age_80_84 = $age_80_84;

        return $this;
    }

    public function getAge_85_89(): ?int
    {
        return $this->age_85_89;
    }

    public function setAge8589(int $age_85_89): self
    {
        $this->age_85_89 = $age_85_89;

        return $this;
    }

    public function getAge_85_Plus(): ?int
    {
        return $this->age_85_plus;
    }

    public function setAge85Plus(int $age_85_plus): self
    {
        $this->age_85_plus = $age_85_plus;

        return $this;
    }

    public function getAge_90_Plus(): ?int
    {
        return $this->age_90_plus;
    }

    public function setAge90Plus(int $age_90_plus): self
    {
        $this->age_90_plus = $age_90_plus;

        return $this;
    }

    public function getCardiovascular_Disease(): ?int
    {
        return $this->cardiovascular_disease;
    }

    public function setCardiovascularDisease(int $cardiovascular_disease): self
    {
        $this->cardiovascular_disease = $cardiovascular_disease;

        return $this;
    }

    public function getHigh_Blood_Pressure(): ?int
    {
        return $this->high_blood_pressure;
    }

    public function setHighBloodPressure(int $high_blood_pressure): self
    {
        $this->high_blood_pressure = $high_blood_pressure;

        return $this;
    }

    public function getDiabetes(): ?int
    {
        return $this->diabetes;
    }

    public function setDiabetes(int $diabetes): self
    {
        $this->diabetes = $diabetes;

        return $this;
    }

    public function getLung_Disease(): ?int
    {
        return $this->lung_disease;
    }

    public function setLungDisease(int $lung_disease): self
    {
        $this->lung_disease = $lung_disease;

        return $this;
    }

    public function getNo_Disease_Group(): ?int
    {
        return $this->no_disease_group;
    }

    public function setNoDiseaseGroup(int $no_disease_group): self
    {
        $this->no_disease_group = $no_disease_group;

        return $this;
    }

    public function getOne_Disease_Group(): ?int
    {
        return $this->one_disease_group;
    }

    public function setOneDiseaseGroup(int $one_disease_group): self
    {
        $this->one_disease_group = $one_disease_group;

        return $this;
    }

    public function getMultiple_Disease_Groups(): ?int
    {
        return $this->multiple_disease_groups;
    }

    public function setMultipleDiseaseGroups(int $multiple_disease_groups): self
    {
        $this->multiple_disease_groups = $multiple_disease_groups;

        return $this;
    }

    public function getSpecial_Housing(): ?int
    {
        return $this->special_housing;
    }

    public function setSpecialHousing(int $special_housing): self
    {
        $this->special_housing = $special_housing;

        return $this;
    }

    public function getHome_Care(): ?int
    {
        return $this->home_care;
    }

    public function setHomeCare(int $home_care): self
    {
        $this->home_care = $home_care;

        return $this;
    }

    public function getHospital_Deaths(): ?int
    {
        return $this->hospital_deaths;
    }

    public function setHospitalDeaths(int $hospital_deaths): self
    {
        $this->hospital_deaths = $hospital_deaths;

        return $this;
    }

    public function getSpecial_Housing_Deaths(): ?int
    {
        return $this->special_housing_deaths;
    }

    public function setSpecialHousingDeaths(int $special_housing_deaths): self
    {
        $this->special_housing_deaths = $special_housing_deaths;

        return $this;
    }

    public function getOrdinary_Housing_Deaths(): ?int
    {
        return $this->ordinary_housing_deaths;
    }

    public function setOrdinaryHousingDeaths(int $ordinary_housing_deaths): self
    {
        $this->ordinary_housing_deaths = $ordinary_housing_deaths;

        return $this;
    }
}
