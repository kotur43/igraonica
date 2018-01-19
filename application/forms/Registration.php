<?php

class Application_Form_Registration extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setAction('/Authentification/registration')->setMethod('post');
        
        $ime = new Zend_Form_Element_Text('tbIme');
        $ime->setLabel('Ime:');
        // provera regularnim izrazima
        $ime->addValidator('regex', false, array(
                  'pattern'   => '/^[A-Z][a-z]{2,20}$/'))
                ->addErrorMessage('Ime mora pocinjati velikim slovom i imati minimalno 3, a maksimalno 20 karaktera.');
        $ime->addFilter('StringTrim');
        $ime->setDescription('npr: Danijela');
        
        $prezime = new Zend_Form_Element_Text('tbPrezime');
        $prezime->setLabel('Prezime:');
        $prezime->addValidator('regex', false, array(
                  'pattern'   => '/^[A-Z][a-z]{2,20}$/'))
                ->addErrorMessage('Prezime mora pocinjati velikim slovom i imati minimalno 3, a maksimalno 20 karaktera.');
        $prezime->setDescription('npr: Nikitin');
        $prezime->addFilter('StringTrim');
        
        $email = new Zend_Form_Element_Text('tbEmail');
        $email->setLabel('E-mail:');
        $email->setRequired(true);
        $email->addValidator('EmailAddress')->addErrorMessage('E-mail adresa nije ispravna.');
        $email->addFilter('StringTrim');
        $email->setDescription('npr: something@example.any');
        
        $lozinka = new Zend_Form_Element_Password('tbLozinka');
        $lozinka->setLabel('Lozinka:');
        $lozinka->setRequired(true);
        $lozinka->addValidator(new Zend_Validate_StringLength(6, 20))->addErrorMessage('Lozinka mora imati minimalno 6, a maksimalno 20 karaktera');
        $lozinka->addFilter('StringTrim');
        $lozinka->setDescription('Minimalno 6, a maksimalno 20 karaktera');
        
        $lozinkaPonovo = new Zend_Form_Element_Password('tbLozinkaPonovo');
        $lozinkaPonovo->setLabel('Ponovite lozinku:');
        $lozinkaPonovo->setRequired(true);
        $lozinkaPonovo->addValidator(new Zend_Validate_Identical('tbLozinka'))->addErrorMessage('Lozinke se ne poklapaju.'); // poklapanje unetih lozinki
        $lozinkaPonovo->addFilter('StringTrim');
        
        $adresa = new Zend_Form_Element_Text('tbAdresa');
        $adresa->setLabel('Adresa:');
        $adresa->setDescription('npr: Kumodraska 15, Ilije Popovica 24a..');
        $adresa->addValidator('regex',false, array('pattern'=>'/^[A-Z][a-z]+(\s\w+)*(\d|\w)+$/'))->addErrorMessage('Adresa mora pocinjati velikim slovom i zavrsavati se brojem zgrade.');
        $adresa->addFilter('StringTrim');
        
        $brojTelefona = new Zend_Form_Element_Text('tbBrojTelefona');
        $brojTelefona->setLabel('Broj telefona:');
        $brojTelefona->setDescription('npr: 065/345-67-89');
        $brojTelefona->addValidator('regex',false, array('pattern'=>'/^06\d\/\d{3}(\-\d{2}){2}$/'))->addErrorMessage('Broj telefona nije ispravno unet.');
        
        $button = new Zend_Form_Element_Submit('btnRegister');
        $button->setLabel('Registruj se');
        $button->setAttrib('class', 'btn btn-default');
        
        $this->addElements(array($ime, $prezime, $email, $lozinka, $lozinkaPonovo, $adresa, $brojTelefona, $button));
        
    }



}

