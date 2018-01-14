<?php

class Application_Model_Korisnici
{
    public $id_korisnik;
    public $ime;
    public $prezime;
    public $email;
    public $lozinka;
    public $uloga;
    
    public function getId_korisnik() {
        return $this->id_korisnik;
    }

    public function setId_korisnik($id_korisnik) {
        $this->id_korisnik = $id_korisnik;
    }

    public function getIme() {
        return $this->ime;
    }

    public function setIme($ime) {
        $this->ime = $ime;
    }

    public function getPrezime() {
        return $this->prezime;
    }

    public function setPrezime($prezime) {
        $this->prezime = $prezime;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getLozinka() {
        return $this->lozinka;
    }

    public function setLozinka($lozinka) {
        $this->lozinka = $lozinka;
    }

    public function getUloga() {
        return $this->uloga;
    }

    public function setUloga($uloga) {
        $this->uloga = $uloga;
    }


}

