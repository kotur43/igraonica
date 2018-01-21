<?php

class AdministrationController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->layout->setLayout('admin');
        /* Initialize action controller here */
        $session = new Zend_Auth_Storage_Session();
        $idUloga = $session->read()->id_uloga;
        if($idUloga!=1) $this->redirect('Index');
        $this->view->headTitle()->prepend("Administracija");
    }

    public function indexAction()
    {
        // action body
    }

    public function radioniceAction()
    {
        // action body
    }

    public function slikeAction()
    {
        // action body
    }

    public function terminiAction()
    {
        // action body
    }


}







