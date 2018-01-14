<?php

class Application_Model_DbTable_Termini extends Zend_Db_Table_Abstract
{

    protected $_name = 'termini';
    protected $_id = 'id_termin';
    protected $_dependentTables = array('Application_Model_DbTable_Rezervacije');

}

