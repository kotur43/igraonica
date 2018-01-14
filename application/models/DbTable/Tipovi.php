<?php

class Application_Model_DbTable_Tipovi extends Zend_Db_Table_Abstract
{

    protected $_name = 'tipovi';
    protected $_id = 'id_tip';
    protected $_dependentTables = array('Application_Model_DbTable_Radionice');


}

