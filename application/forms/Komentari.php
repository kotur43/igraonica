<?php

class Application_Form_Komentari extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setAttrib('class','center');
        
        $tekst = new Zend_Form_Element_Textarea('taTekst');
        $tekst->setRequired(true)->addErrorMessage('Morate uneti komentar.');
        $tekst->setAttrib('COLS', '70')->setAttrib('ROWS', '4');
        
        $button = new Zend_Form_Element_Submit('btnKomentar');
        $button->setLabel('Unesi komentar');
        $button->setAttrib('class', 'btn');
        
        $this->addElements(array($tekst, $button));
    }


}

