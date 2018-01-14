<?php

class Application_Model_DbTable_Radionice extends Zend_Db_Table_Abstract
{

    protected $_name = 'radionice';
    protected $_id = 'id_radionica';
    protected $_referenceMap = array(
        'Korisnici'=>array(
            'columns'=> 'id_korisnik',
            'refTableClass' => 'Application_Model_DbTable_Korisnici',
            'refColumns' => 'id_korisnik'
        ),
        'Tipovi' => array(
            'columns' => 'id_tip',
            'refTableClass' =>'Application_Model_DbTable_Tipovi',
            'refColumns' => 'id_tip'
        )
    );
    
    protected $_dependentTables = array('Application_Model_DbTable_Slike','Application_Model_DbTable_Komentari');



}

