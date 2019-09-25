<?php
namespace App\Entity;

class trajetSearch{

    /**
     * @var string|null
     */
    private $Depart;

    /**
     * @var string|null
     */
    private $Arriver;




    /**
     * @return string|null
     */
    public function getDepart(): ?string
    {
        return $this->Depart;
    }

    /**
     * @param string|null $Depart
     */
    public function setDepart(?string $Depart): void
    {
        $this->Depart = $Depart;
    }

    /**
     * @return string|null
     */
    public function getArriver(): ?string
    {
        return $this->Arriver;
    }

    /**
     * @param string|null $Arriver
     */
    public function setArriver(?string $Arriver): void
    {
        $this->Arriver = $Arriver;
    }


}