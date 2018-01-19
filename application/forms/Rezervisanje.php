<?php

class Application_Form_Rezervisanje extends Zend_Form
{

    public $options;
    public $datum;
    
    public function __construct($options = null, $datum = null) {
        $this->options = $options;
        $this->datum=$datum;
        parent::__construct($options);
        
    }
    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setAction('/User/reservation/operation/rezervisi')->setMethod('post');
        
        $select = new Zend_Form_Element_Select('ddlTermin');
        $select->setLabel('Termin:');
        $select->addMultiOption('0','Izaberite');
        foreach ($this->options as $option){
               $select->addMultiOption($option->id_termin,$option->vreme);
        }
        $hidden = new Zend_Form_Element_Hidden('hdnDatum');
        $hidden->setValue($this->datum);
        $select->setRequired(true);
        
        $opis = new Zend_Form_Element_Textarea('taOpis');
        $opis->setLabel('Opis');
        $opis->setRequired(true);
        $opis->setAttrib('COLS', '40')->setAttrib('ROWS', '4');
        
        $brojOsoba = new Zend_Form_Element_Text('tbBroj');
        $brojOsoba->setLabel('Broj osoba:');
        $brojOsoba->addValidator('regex',false,array('pattern'=>'/^\d{1,3}$/'))->addErrorMessage('Morate uneti od 1 do 3 cifre.');
        
        $button = new Zend_Form_Element_Submit('btnLogin');
        $button->setAttrib('class', 'btn btn-default');
        $button->setLabel('Rezervisi termin');
        
        $this->addElements(array($opis, $brojOsoba, $select, $button, $hidden));
    }


}

