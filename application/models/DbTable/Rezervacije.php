<?php

class Application_Model_DbTable_Rezervacije extends Zend_Db_Table_Abstract
{

    protected $_name = 'rezervacije';
    protected $_id = 'id_rezervacija';
    protected $_referenceMap = array(
        'Termini'=>array(
            'columns'=> 'id_termin',
            'refTableClass'=>'Application_Model_DbTable_Termini',
            'refColumns'=>'id_termin'
        ),
        'Korisnici'=>array(
            'columns'=> 'id_korisnik',
            'refTableClass'=>'Application_Model_DbTable_Korisnici',
            'refColumns'=>'id_korisnik'
        )
    );  


}

