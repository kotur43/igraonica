<?php

class Application_Model_KorisniciMapper
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
            $this->setDbTable('Application_Model_DbTable_Korisnici');
        }

        return $this->_dbTable;
    }
    
    public function insert(Application_Model_Korisnici $korisnik){
        $data = array(
            'ime' => $korisnik->getIme(),
            'prezime' => $korisnik->getPrezime(),
            'email' => $korisnik->getEmail(),
            'lozinka' => $korisnik->getLozinka(),
            'id_uloga' => $korisnik->getUloga()
        );
        $this->getDbTable()->insert($data);
    }
    
    public function find(Application_Model_Korisnici $korisnik){
        $row = $this->getDbTable()->fetchRow($this->where($korisnik));
        return $row;
    }
    
    private function where(Application_Model_Korisnici $korisnik){
        $where = array();
        if(!empty($korisnik->getEmail())){
            $where[] = sprintf("email = '%s'",$korisnik->getEmail());
        }
        if(!empty($korisnik->getId_korisnik())){
            $where[] = sprintf("id_korisnik = %d",$korisnik->getId_korisnik());
        }
        if(!empty($korisnik->getIme())){
            $where[] = sprintf("ime = '%s'",$korisnik->getIme());
        }
        if(!empty($korisnik->getPrezime())){
            $where[] = sprintf("prezime = '%s'",$korisnik->getPrezime());
        }
        if(!empty($korisnik->getLozinka())){
            $where[] = sprintf("lozinka = '%s'",$korisnik->getLozinka());
        }
        if(!empty($korisnik->getUloga())){
            $where[] = sprintf("id_uloga = '%d'",$korisnik->getUloga());
        }
        return $where;
    }
}

