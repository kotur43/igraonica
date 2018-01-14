<?php

class Application_Model_DbTable_Komentari extends Zend_Db_Table_Abstract
{

    protected $_name = 'komentari';
    protected $_id = 'id_komentar';
    
    protected $_referenceMap = array(
        'Radionice' =>array(
            'columns'=> 'id_radionica',
            'refTableClass'=>'Application_Model_DbTable_Radionice',
            'refColumns'=>'id_radionica'
        ),
         'Korisnici'=>array(
            'columns'=> 'id_korisnik',
            'refTableClass' => 'Application_Model_DbTable_Korisnici',
            'refColumns' => 'id_korisnik'
        ),
    );


}

