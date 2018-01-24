<?php

class Application_Model_TipoviMapper
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
            $this->setDbTable('Application_Model_DbTable_Tipovi');
        }

        return $this->_dbTable;
    }
    
    public function fetchAll($count=null, $offset = null){
        $result = null;
        if($count!=null && $offset!=null){
            $result = $this->getDbTable()->fetchAll(null,null,$count,$offset);
        }
        else{
            $result = $this->getDbTable()->fetchAll();
        }
        
        $tipovi = array();
        foreach ($result as $row){
            $tip = new Application_Model_Tipovi();
            $tip->setId_tip($row->id_tip);
            $tip->setNaziv($row->naziv);
            $tipovi[] = $tip;
        }
        return $tipovi;
    }
}

