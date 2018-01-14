<?php

class Application_Model_Meni
{
    public $id_meni;
    public $naslov;
    public $raspored;
    public $putanja;
    
    public function getId_meni() {
        return $this->id_meni;
    }

    public function setId_meni($id_meni) {
        $this->id_meni = $id_meni;
    }

    public function getNaslov() {
        return $this->naslov;
    }

    public function setNaslov($naslov) {
        $this->naslov = $naslov;
    }

    public function getRaspored() {
        return $this->raspored;
    }

    public function setRaspored($raspored) {
        $this->raspored = $raspored;
    }
    public function getPutanja() {
        return $this->putanja;
    }

    public function setPutanja($putanja) {
        $this->putanja = $putanja;
    }

}

