<?php

class Application_Form_Slike extends Zend_Form
{

    protected  $slika;
    
    public function getSlika() {
        return $this->slika;
    }

    public function setSlika($slika) {
        $this->slika = $slika;
    }

    public function __construct($slika = null, $options = null) {
        $this->setSlika($slika);
        parent::__construct($options);
    }
    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $photo = new Zend_Form_Element_Image('taSlika');
        $view = Zend_Layout::getMvcInstance()->getView();
        $photo->setImage($view->baseUrl($this->getSlika()->putanja));
        $photo->setAttrib('width', '200');
        
        $image = new Zend_Form_Element_File('file');
        $image->setLabel('Slika:');
        
        $opis = new Zend_Form_Element_Textarea('taOpis');
        $opis->setAttrib('COLS', '40')->setAttrib('ROWS', '4');
        $opis->setLabel('Opis');
        $opis->setValue($this->getSlika()->opis);
        
        $radioniceMapper = new Application_Model_RadioniceMapper();
        $radioniceDDL = new Zend_Form_Element_Select('ddlRadionica');
        $radioniceMapper->fetchAllWhere();
        $radionice = $radioniceMapper->fetchAllWhere();
        $radioniceDDL->addMultiOption('0', 'Izaberite');
       // $radioniceDDL->setValue($this->getRadionica()->tip->id_tip);
        $radioniceDDL->addValidator(new Zend_Validate_Regex( '/[^0]/' ))
        ->addErrorMessage('Morate izabrati tip radionice.');
        foreach ($radionice as $radionica){
            $radioniceDDL->addMultiOption($radionica->getId_radionica(), $radionica->getNaslov());
        }
        $radioniceDDL->setLabel('Radionice:');
        
        $button = new Zend_Form_Element_Submit('btnRadionica');
        $button->setAttrib('class', 'btn btn-default');
        $label = empty($this->getSlika()) ? 'Dodaj sliku' : 'Izmeni sliku';
        $button->setLabel($label);
        
        $this->addElements(array($photo, $image, $opis, $radioniceDDL, $button));
    }


}

