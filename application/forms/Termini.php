<?php

class Application_Form_Termini extends Zend_Form
{

    protected $termin;
    
    public function getTermin() {
        return $this->termin;
    }

    public function setTermin($termin) {
        $this->termin = $termin;
    }
    public function __construct($termin = null, $options = null) {
        $this->setTermin($termin);
        parent::__construct($options);
    }
        public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod('post');
        $vreme = new Zend_Form_Element_Text('tbVreme');
        $vreme->setLabel('Vreme:');
        $vreme->setValue($this->getTermin()->vreme);
        
        $cena = new Zend_Form_Element_Text('tbCena');
        $cena->setLabel('Cena:');
        $cena->setValue($this->getTermin()->cena);
        
        $button = new Zend_Form_Element_Submit('btnTermini');
        $button->setAttrib('class', 'btn btn-default');
        $label = empty($this->getTermin()) ? 'Unesi termin' : 'Izmeni termin';
        $button->setLabel($label);
        
        $this->addElements(array($vreme, $cena, $button));
    }


}

