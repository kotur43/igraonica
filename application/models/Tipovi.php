<?php

class Application_Model_Tipovi
{
    public $id_tip;
    public $naziv;
    public $fotka; 
    
    
    public function getId_tip() {
        return $this->id_tip;
    }

    public function setId_tip($id_tip) {
        $this->id_tip = $id_tip;
    }

    public function getNaziv() {
        return $this->naziv;
    }

    public function setNaziv($naziv) {
        $this->naziv = $naziv;
    }

    public function getIkonica() {
        return $this->fotka;
    }

    public function setIkonica($ikonica) {
        $this->fotka = $fotka;
    }


}

