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
        
        $hidden = new Zend_Form_Element_Hidden('hdnDatum');
        $hidden->setValue($this->datum);
        
        $opis = new Zend_Form_Element_Textarea('taOpis');
        $opis->setLabel('Opis');
        $opis->setRequired(true);
        $opis->setAttrib('COLS', '40')->setAttrib('ROWS', '4');
        $opis->setAttrib('required','true');
        
        $brojOsoba = new Zend_Form_Element_Text('tbBroj');
        $brojOsoba->setLabel('Broj osoba:');
        $brojOsoba->setRequired(true);
        $brojOsoba->setAttrib('required','true');
        
        
        $select = new Zend_Form_Element_Select('ddlTermin');
        $select->setLabel('Termin:');
        $select->setAttrib('required','true');
        $select->addMultiOption('0','Izaberite');
        $select->setRequired(true);
        foreach ($this->options as $option){
               $select->addMultiOption($option->id_termin,$option->vreme);
        }
        
        $button = new Zend_Form_Element_Submit('btnLogin');
        $button->setAttrib('class', 'btn btn-default');
        $button->setLabel('Rezervisi termin');
        
        $this->addElements(array($opis, $brojOsoba, $select, $button, $hidden));
    }


}

