<?php

class Application_Model_KomentariMapper
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
            $this->setDbTable('Application_Model_DbTable_Komentari');
        }

        return $this->_dbTable;
    }
    
    public function fetchAllWhere(Application_Model_Komentari $komentar){
        $result = $this->getDbTable()->fetchAll($this->where($komentar),'datum DESC');
        $komentari = array();
        foreach($result as $row){
            $komentar = new Application_Model_Komentari();
            $komentar->setDatum($row->datum);
            $komentar->setId_komentar($row->id_komentar);
            $komentar->setKorisnik($row->findParentRow('Application_Model_DbTable_Korisnici'));
            $komentar->setTekst($row->tekst);
            $komentari[] = $komentar;
        }
        return $komentari;
    }
    public function fetchAllLimit($count, $offset){
        $result = $this->getDbTable()->fetchAll(null,'datum DESC',$count,$offset);
        $komentari = array();
        foreach($result as $row){
            $komentar = new Application_Model_Komentari();
            $komentar->setDatum($row->datum);
            $komentar->setId_komentar($row->id_komentar);
            $komentar->setKorisnik($row->findParentRow('Application_Model_DbTable_Korisnici'));
            $komentar->setRadionica($row->findParentRow('Application_Model_DbTable_Radionice'));
            $komentar->setTekst($row->tekst);
            $komentari[] = $komentar;
        }
        return $komentari;
    }
    
    public function insert(Application_Model_Komentari $komentar){
        $data = array(
            'id_korisnik'=> $komentar->getKorisnik(),
            'datum'=>time(),
            'id_radionica'=>$komentar->getRadionica(),
            'tekst'=>$komentar->getTekst()
        );
        $idKomentar = $this->getDbTable()->insert($data);
        return $idKomentar;
    }
    private function where(Application_Model_Komentari $komentar){
        $where = array();
        if(!empty($komentar->getRadionica())){
            $where[] = sprintf('id_radionica = %d',$komentar->getRadionica());
        }
        return $where;
    }
}

