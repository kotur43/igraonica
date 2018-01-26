<?php

class Application_Form_Radionice extends Zend_Form
{
    public $radionica;
    
    public function getRadionica() {
        return $this->radionica;
    }

    public function setRadionica($radionica) {
        $this->radionica = $radionica;
    }

    
    public function __construct($radionica = null, $options = null) {
        $this->setRadionica($radionica);
        parent::__construct($options);
    }
    
    public function init()
    {
        $naslov = new Zend_Form_Element_Text('tbNaslov');
        $naslov->setLabel('Naslov:');
        $this->required($naslov, 'Naslov');
        $naslov->setValue($this->getRadionica()->naslov);
        
        $opis = new Zend_Form_Element_Textarea('taOpis');
        $opis->setAttrib('COLS', '40')->setAttrib('ROWS', '4');
        $this->required($opis, 'Opis');
        $opis->setValue($this->getRadionica()->opis);
        
        $tipDDL = new Zend_Form_Element_Select('ddlTip');
        $tipMapper = new Application_Model_TipoviMapper();
        
        $tipovi = $tipMapper->fetchAll();
        $tipDDL->addMultiOption('0', 'Izaberite');
        $tipDDL->setValue($this->getRadionica()->tip->id_tip);
        $tipDDL->addValidator(new Zend_Validate_Regex( '/[^0]/' ))
        ->addErrorMessage('Morate izabrati tip radionice.');
        foreach ($tipovi as $tip)
            {$tipDDL->addMultiOption($tip->getId_tip(), $tip->getNaziv());}
        
        $button = new Zend_Form_Element_Submit('btnRadionica');
        $button->setAttrib('class', 'btn btn-default');
        $label = empty($this->getRadionica()) ? 'Zakaži radionicu' : 'Izmeni radionicu';
        $button->setLabel($label);
        
        $this->addElements(array($naslov,$opis, $tipDDL, $button));
    }

    private function required(Zend_Form_Element $element, $text){
        $element->setRequired(true)->addErrorMessage('Polje "'.$text.'" je obavezno.');
    }
    


}

