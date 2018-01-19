<?php

class Application_Form_Login extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setAction('/Authentification/login')->setMethod('post');
        $this->setAttrib('class', 'loginForm');
        
        $email = new Zend_Form_Element_Text('tbEmail');
        $email->setLabel('Vasa e-mail adresa: ');
        $email->setRequired(true);
        $email->addValidator('EmailAddress')->addErrorMessage('E-mail adresa nije ispravna.');
        
        $lozinka = new Zend_Form_Element_Password('tbLozinka');
        $lozinka->setLabel('Vasa lozinka:');
        $lozinka->setRequired(true)->addErrorMessage('Polje lozinka je obavezno.');
        
        $button = new Zend_Form_Element_Submit('btnLogin');
        $button->setAttrib('class', 'btn btn-default');
        $button->setLabel('Uloguj se');
        
        $this->addElements(array($email, $lozinka, $button));
        
    }


}

