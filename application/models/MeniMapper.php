<?php

class Application_Model_MeniMapper
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
            $this->setDbTable('Application_Model_DbTable_Meni');
        }

        return $this->_dbTable;
    }
    
    public function fetchAllWithOrder(){
        $result = $this->getDbTable()->fetchAll(null, 'raspored ASC');
        $resultArray = array();
        foreach ($result as $row){
            $meni = new Application_Model_Meni();
            $meni->setId_meni($row->id_meni);
            $meni->setNaslov($row->naslov);
            $meni->setPutanja($row->putanja);
            $resultArray[] = $meni;
        }
        return $resultArray;
    }
}

