<?php

class Application_Model_DbTable_Slike extends Zend_Db_Table_Abstract
{

    protected $_name = 'slike';
    protected $_id = 'id_slika';
    protected $_referenceMap = array(
        'Radionice' =>array(
            'columns'=> 'id_radionica',
            'refTableClass'=>'Application_Model_DbTable_Radionice',
            'refColumns'=>'id_radionica'
    ));


}

