<?php

class Application_Model_Termini
{
    public $id_termin;
    public $vreme;
    public $cena;
    
    public function getId_termin() {
        return $this->id_termin;
    }

    public function setId_termin($id_termin) {
        $this->id_termin = $id_termin;
    }

    public function getVreme() {
        return $this->vreme;
    }

    public function setVreme($vreme) {
        $this->vreme = $vreme;
    }

    public function getCena() {
        return $this->cena;
    }

    public function setCena($cena) {
        $this->cena = $cena;
    }


}

