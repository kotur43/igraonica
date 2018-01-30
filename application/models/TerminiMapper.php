<?php

class Application_Model_TerminiMapper
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
            $this->setDbTable('Application_Model_DbTable_Termini');
        }

        return $this->_dbTable;
    }
    
    public function dohvati($where){
        $select = $this->getDbTable()->select(Zend_Db_Table::SELECT_WITH_FROM_PART);
        $select->where('termini.id_termin NOT IN (SELECT id_termin FROM rezervacije WHERE datum = "' .$where.'")');
        $rows = $this->getDbTable()->fetchAll($select);
        return $rows;
    }
    public function fetchAll(){
        $result = $this->getDbTable()->fetchAll();
        $termini = array();
        foreach ($result as $row){
            $termin = new Application_Model_Termini();
            $termin->setId_termin($row->id_termin);
            $termin->setCena($row->cena);
            $termin->setVreme($row->vreme);
            $termini[] = $termin;
        }
        return $termini;
    }
    
    public function find($id, Application_Model_Termini $termin){
        $result = $this->getDbTable()->find($id);
        if(count($result)==0){
            return null;
        }
        $row = $result->current();
        $termin->setId_termin($row->id_termin);
        $termin->setCena($row->cena);
        $termin->setVreme($row->vreme);
    }
    
    public function update($id, Application_Model_Termini $termin){
        $data = array(
            'cena'=>$termin->getCena(),
            'vreme'=>$termin->getVreme()
        );
        $this->getDbTable()->update($data,sprintf('id_termin = %d',$id));
    }

    public function insert(Application_Model_Termini $termin){
        $data = array(
            'cena'=>$termin->getCena(),
            'vreme'=>$termin->getVreme()
        );
        $this->getDbTable()->insert($data);
    }
    
    public function delete($id){
        $this->getDbTable()->delete(sprintf('id_termin = %d',$id));
    }
}

