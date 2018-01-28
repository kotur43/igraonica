<?php

class Application_Model_RadioniceMapper
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
            $this->setDbTable('Application_Model_DbTable_Radionice');
        }

        return $this->_dbTable;
    }
    
    public function fetchAllWhere(Application_Model_Radionice $radionica = null, $uslov = null){
        $result = null;
        if(!empty($uslov))
            $result = $this->getDbTable()->fetchAll($uslov);
        else if(!empty($radionica))
            $result = $this->getDbTable()->fetchAll($this->where($radionica));
        else
            $result = $this->getDbTable()->fetchAll();
        $radionice = array();
        foreach ($result as $row){
            $radionica = new Application_Model_Radionice();
            $radionica->setId_radionica($row->id_radionica);
            $radionica->setNaslov($row->naslov);
            $radionica->setOpis($row->opis);
            $radionica->setVremePocetka($row->vremePocetka);
            $radionica->setVremeZavrsetka($row->vremeZavrsetka);
            $radionica->setKorisnik($row->findParentRow('Application_Model_DbTable_Korisnici'));
            $radionica->setTip($row->findParentRow('Application_Model_DbTable_Tipovi'));
            $radionice[] = $radionica;
        }
        return $radionice;
    }
    public function fetchAll(Application_Model_Radionice $radionica){
        $result = $this->getDbTable()->fetchAll($this->where($radionica));
        $radionice = array();
        foreach ($result as $row){
            $radionica = new Application_Model_Radionice();
            $radionica->setId_radionica($row->id_radionica);
            $radionica->setNaslov($row->naslov);
            $radionica->setOpis($row->opis);
            $radionica->setVremePocetka($row->vremePocetka);
            $radionica->setVremeZavrsetka($row->vremeZavrsetka);
            $radionica->setKorisnik($row->findParentRow('Application_Model_DbTable_Korisnici'));
            $radionica->setTip($row->findParentRow('Application_Model_DbTable_Tipovi'));
            $radionice[] = $radionica;
        }
        return $radionice;
    }
    
    public function fetchAllOffset(){
        $result = $this->getDbTable()->fetchAll('vremePocetka > '.time(),'vremePocetka ASC');
        $radionice = array();
        foreach ($result as $row){
            $radionica = new Application_Model_Radionice();
            $radionica->setId_radionica($row->id_radionica);
            $radionica->setNaslov($row->naslov);
            $radionica->setOpis($row->opis);
            $radionica->setVremePocetka($row->vremePocetka);
            $radionica->setVremeZavrsetka($row->vremeZavrsetka);
            $radionica->setKorisnik($row->findParentRow('Application_Model_DbTable_Korisnici'));
            $radionica->setTip($row->findParentRow('Application_Model_DbTable_Tipovi'));
            $radionice[] = $radionica;
        }
        return $radionice;
    }
    
    public function fetchAllOfset($tip = 1){
        $result = $this->getDbTable()->fetchAll('vremePocetka > '.time(),'vremePocetka ASC');
        $radionice = array();
        foreach ($result as $row){
            $radionica = new Application_Model_Radionice();
            $radionica->setId_radionica($row->id_radionica);
            $radionica->setNaslov($row->naslov);
            $radionica->setOpis($row->opis);
            $radionica->setVremePocetka($row->vremePocetka);
            $radionica->setVremeZavrsetka($row->vremeZavrsetka);
            $radionica->setKorisnik($row->findParentRow('Application_Model_DbTable_Korisnici'));
            $radionica->setTip($row->$tip);
            $radionice[] = $radionica;
        }
        return $radionice;
    }
    
    public function find($id,Application_Model_Radionice $radionica){
        $result = $this->getDbTable()->find($id);
        if (count($result) == 0) {
            return;
        }
        $row = $result->current();
        $radionica->setId_radionica($row->id_radionica);
        $radionica->setKorisnik($row->findParentRow('Application_Model_DbTable_Korisnici'));
        $radionica->setNaslov($row->naslov);
        $radionica->setOpis($row->opis);
        $radionica->setVremePocetka($row->vremePocetka);
        $radionica->setTip($row->findParentRow('Application_Model_DbTable_Tipovi'));
        $radionica->setVremeZavrsetka($row->vremeZavrsetka);
    }
    
    public function update($id, Application_Model_Radionice $radionica){
        $data = array(
            'naslov'=>$radionica->getNaslov(),
            'opis'=>$radionica->getOpis(),
            'id_tip'=>$radionica->getTip(),
            'id_korisnik'=>$radionica->getKorisnik()
        );
        $this->getDbTable()->update($data, sprintf('id_radionica  = %d',$id));
    }
    public function insert(Application_Model_Radionice $radionica){
        $data = array(
            'id_korisnik'=>$radionica->getKorisnik(),
            'naslov'=>$radionica->getNaslov(),
            'opis'=>$radionica->getOpis(),
            'id_tip' => $radionica->getTip(),
            'vremePocetka'=>$radionica->getVremePocetka(),
            'vremeZavrsetka'=>$radionica->getVremeZavrsetka()
        );
        $insertId = $this->getDbTable()->insert($data);
        return $insertId;
    }
    
    public function delete(Application_Model_Radionice $radionica){
        $this->getDbTable()->delete($this->where($radionica));
    }

    private function where(Application_Model_Radionice $radionica){
        $where = array();
        if(!empty($radionica->getVremePocetka())){
            $where[] = sprintf('vremePocetka = %d',$radionica->getVremePocetka());
        }
        if(!empty($radionica->getVremeZavrsetka())){
            $where[] = sprintf('vremeZavrsetka = %d', $radionica->getVremeZavrsetka());
        }
        if(!empty($radionica->getTip())){
            $where[] = sprintf('id_tip = %d', $radionica->getTip());
        }
        if(!empty($radionica->getId_radionica())){
            $where[] = sprintf('id_radionica = %d', $radionica->getId_radionica());
        }
        return $where;
    }

}

