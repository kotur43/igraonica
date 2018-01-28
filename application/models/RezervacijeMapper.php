<?php

class Application_Model_RezervacijeMapper
{
    protected $_dbTable;

    public function setDbTable($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception("Nepostojeci table gateway");
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable() {
        if (null == $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_Rezervacije');
        }

        return $this->_dbTable;
    }
    
    public function fetchAllWhereTermin(Application_Model_Rezervacije $rezervacija){
        $rezervacije = $this->getDbTable()->fetchAll(
                'datum = "'.$rezervacija->getDatum().'" '
                . 'AND id_termin = "'.$rezervacija->getTermin(). '"');
        $idTermini = array();
        foreach ($rezervacije as $row){
            $idTermini[]= $row->id_termin;
        }
        $termini = new Application_Model_TerminiMapper();
        $resultArray=$termini->dohvati(implode(',',$idTermini));
        return $resultArray;
    }
    
    private function where(Application_Model_Rezervacije $rezervacija){
        $where = array();
        if(!empty($rezervacija->getTermin())){
            $where[] = sprintf('id_termin = %d',$rezervacija->getTermin());
        }
        if(!empty($rezervacija->getDatum())){
            $where[] = 'datum = "'.$rezervacija->getDatum().'"';
        }
        if(!empty($rezervacija->getBroj_osoba())){
            $where[] = sprintf('broj_osoba = %d',$rezervacija->getBroj_osoba());
        }
        if(!empty($rezervacija->getOpis())){
            $where[] = sprintf('opis = "%s"',$rezervacija->getOpis());
        }
        if(!empty($rezervacija->getKorisnik())){
            $where[] = sprintf('id_korisnik = %d',$rezervacija->getKorisnik());
        }
        return $where;
    }
    
    public function insert(Application_Model_Rezervacije $rezervacija){
        return $this->getDbTable()->insert(array(
            'id_termin'=>$rezervacija->getTermin(),
            'datum'=>$rezervacija->getDatum(), 
            'broj_osoba'=>$rezervacija->getBroj_osoba(), 
            'id_korisnik'=>$rezervacija->getKorisnik(), 
            'opis'=>$rezervacija->getOpis()
        ));
    }

}

