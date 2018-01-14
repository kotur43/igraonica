<?php

class Application_Model_Komentari
{
    public $id_komentar;
    public $radionica;
    public $korisnik;
    public $datum;
    public $tekst;
    
    public function getId_komentar() {
        return $this->id_komentar;
    }

    public function setId_komentar($id_komentar) {
        $this->id_komentar = $id_komentar;
    }

    public function getRadionica() {
        return $this->radionica;
    }

    public function setRadionica($radionica) {
        $this->radionica = $radionica;
    }

    public function getKorisnik() {
        return $this->korisnik;
    }

    public function setKorisnik($korisnik) {
        $this->korisnik = $korisnik;
    }

    public function getDatum() {
        return $this->datum;
    }

    public function setDatum($datum) {
        $this->datum = $datum;
    }

    public function getTekst() {
        return $this->tekst;
    }

    public function setTekst($tekst) {
        $this->tekst = $tekst;
    }

}

