<?php

class Application_Model_Slike
{
    public $id_slika;
    public $radionica;
    public $opis;
    public $putanja;
    
    public function getId_slika() {
        return $this->id_slika;
    }

    public function setId_slika($id_slika) {
        $this->id_slika = $id_slika;
    }

    public function getRadionica() {
        return $this->radionica;
    }

    public function setRadionica($radionica) {
        $this->radionica = $radionica;
    }

    public function getOpis() {
        return $this->opis;
    }

    public function setOpis($opis) {
        $this->opis = $opis;
    }

    public function getPutanja() {
        return $this->putanja;
    }

    public function setPutanja($putanja) {
        $this->putanja = $putanja;
    }

}

