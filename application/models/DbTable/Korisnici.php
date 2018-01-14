<?php

class Application_Model_DbTable_Korisnici extends Zend_Db_Table_Abstract
{

    protected $_name = 'korisnici';
    protected $_id = 'id_korisnik';
    
    protected $_dependentTables = array('Application_Model_DbTable_Rezervacije','Application_Model_DbTable_Radionice','Application_Model_DbTable_Komentari');


}

