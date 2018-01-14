<?php

class Application_Model_Rezervacije
{
    public $korisnik;
    public $termin;
    public $datum;
    public $opis;
    public $broj_osoba;
    
    public function getKorisnik() {
        return $this->korisnik;
    }

    public function setKorisnik($korisnik) {
        $this->korisnik = $korisnik;
    }

    public function getTermin() {
        return $this->termin;
    }

    public function setTermin($termin) {
        $this->termin = $termin;
    }

    public function getDatum() {
        return $this->datum;
    }

    public function setDatum($datum) {
        $this->datum = $datum;
    }

    public function getOpis() {
        return $this->opis;
    }

    public function setOpis($opis) {
        $this->opis = $opis;
    }

    public function getBroj_osoba() {
        return $this->broj_osoba;
    }

    public function setBroj_osoba($broj_osoba) {
        $this->broj_osoba = $broj_osoba;
    }


}

