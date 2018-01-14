<?php

class Application_Model_SlikeMapper
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
            $this->setDbTable('Application_Model_DbTable_Slike');
        }

        return $this->_dbTable;
    }
    public function fetchAll(){
        $result = $this->getDbTable()->fetchAll();
        $slike = array();
        foreach ($result as $row){
            $slika = new Application_Model_Slike();
            $slika->setId_slika($row->id_slika);
            $slika->setOpis($row->opis);
            $slika->setPutanja($row->putanja);
            $slika->setRadionica($row->findParentRow('Application_Model_DbTable_Radionice'));
            $slike[] = $slika;
        }
        return $slike;
    }
    
    public function insert(Application_Model_Slike $slika){
        $data = array(
            'id_radionica'=>$slika->getRadionica(),
            'putanja'=>$slika->getPutanja(),
            'opis'=>$slika->getOpis()
        );
        $this->getDbTable()->insert($data);
    }
    
    public function find($id, Application_Model_Slike $slika){
        $result = $this->getDbTable()->find($id);
        if(count($result)==0)
            return null;
        $row = $result->current();
        $slika->setId_slika($row->id_slika);
        $slika->setOpis($row->opis);
        $slika->setPutanja($row->putanja);
        $slika->setRadionica($row->findParentRow('Application_Model_DbTable_Radionice'));
    }
    public function fetchAllWhere(Application_Model_Slike $slika){
        $result = null;
        if(!empty($slika)){
            $result = $this->getDbTable()->fetchAll($this->where($slika));
        }
        $slike = array();
        foreach ($result as $row){
            $slika = new Application_Model_Slike();
            $slika->setId_slika($row->id_slika);
            $slika->setOpis($row->opis);
            $slika->setPutanja($row->putanja);
            $slika->setRadionica($row->findParentRow('Application_Model_DbTable_Radionice'));
            $slike[] = $slika;
        }
        return $slike;
    }
    public function update($id, Application_Model_Slike $slika){
        $data = array(
            'id_radionica'=>$slika->getRadionica(),
            'opis'=>$slika->getOpis()
        );
        if($slika->getPutanja()!=null){
            $data['putanja']= $slika->getPutanja();
        }
        $this->getDbTable()->update($data,  sprintf('id_slika = %d',$id));
    }
    
    public function delete($id){
        $this->getDbTable()->delete(sprintf('id_slika = %d',$id));
    }
    private function where(Application_Model_Slike $slika){
        $where = array();
        if(!empty($slika->getRadionica())){
            $where[] = sprintf('id_radionica = %d', $slika->getRadionica());
        }
        return $where;
    }

}

