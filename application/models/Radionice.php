<?php

class Application_Model_Radionice
{
    public $id_radionica;
    public $vremePocetka;
    public $vremeZavrsetka;
    public $korisnik;
    public $opis;
    public $tip;
    public $naslov;
    public $komentari;
    public $slike;
    
    public function getId_radionica() {
        return $this->id_radionica;
    }

    public function setId_radionica($id_radionica) {
        $this->id_radionica = $id_radionica;
    }

        public function getVremePocetka() {
        return $this->vremePocetka;
    }

    public function setVremePocetka($vremePocetka) {
        $this->vremePocetka = $vremePocetka;
    }

    public function getVremeZavrsetka() {
        return $this->vremeZavrsetka;
    }

    public function setVremeZavrsetka($vremeZavrsetka) {
        $this->vremeZavrsetka = $vremeZavrsetka;
    }

    public function getKorisnik() {
        return $this->korisnik;
    }

    public function setKorisnik($korisnik) {
        $this->korisnik = $korisnik;
    }

    public function getOpis() {
        return $this->opis;
    }

    public function setOpis($opis) {
        $this->opis = $opis;
    }

    public function getTip() {
        return $this->tip;
    }

    public function setTip($tip) {
        $this->tip = $tip;
    }

    public function getNaslov() {
        return $this->naslov;
    }

    public function setNaslov($naslov) {
        $this->naslov = $naslov;
    }

    public function getKomentari() {
        return $this->komentari;
    }

    public function setKomentari($komentari) {
        $this->komentari = $komentari;
    }

    public function getSlike() {
        return $this->slike;
    }

    public function setSlike($slike) {
        $this->slike = $slike;
    }


}

